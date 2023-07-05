<script>
import { markRaw } from 'vue';
import { FilterMatchMode, FilterOperator } from 'primevue/api';
import AppLayout from '../../layout/AppLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
export default{
    props:{
        auth: Object,
        adverts: Object
    },
    components:{
        Head,
        Link,
        AppLayout
    },
    layout: AppLayout,
    data(){
        return{
            filters: {
                global: { value: null, matchMode: FilterMatchMode.CONTAINS },
                name: { value: null, matchMode: FilterMatchMode.STARTS_WITH },
                'country.name': { value: null, matchMode: FilterMatchMode.STARTS_WITH },
                representative: { value: null, matchMode: FilterMatchMode.IN },
                status: { value: null, matchMode: FilterMatchMode.EQUALS },
                verified: { value: null, matchMode: FilterMatchMode.EQUALS }
            },
            selectedAdvert: null,
            current_page: null,
            search: '',
        }
    },
    methods:{
        formatCurrency(value){
            let currency = new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'NGN',
            });
            return "₦" + currency.format(value).replace("NGN","");
        },
        formatDate(value){
            return value.toLocaleDateString('en-US', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric'
            });
        },
        onRowSelect(evt){
            // this.selectedAdvert = evt.data;
            // var id = this.selectedAdvert.id;
            // router.get(`advert/${id}`, {},
            // {
            //     onError: (err) => {
            //         this.$toast.add({ severity: 'error', summary: 'Error!', detail: err.message, life: 3000 });
            //     }
            // }
            // );
        },
        onRowUnselect(evt){
        },
        gotoPage(page){
            router.get(`adverts?page=${page}`, {},
            {
                preserveState: true,
                onSuccess: (res) => {
                    // this.$toast.add({ severity: 'success', summary: 'Successful', detail: 'Data Retrieved!', life: 3000 });
                    // console.log(res);
                },
            }
            );
        },
        handleClick(evt){
            var target = evt.target;
            if(target.classList.contains('p-link') || target.nodeName === 'svg' || target.nodeName === 'path'){
                const page = this.current_page === 0 ? 1 : Math.floor((this.current_page/this.adverts?.per_page))+1;
                this.gotoPage(page);
            }
        },
        searchAdvert(){
            router.get(`adverts?q=${this.search}`, {},
            {
                preserveState: true,
                onSuccess: (res) => {
                    // this.$toast.add({ severity: 'success', summary: 'Successful', detail: 'Data Retrieved!', life: 3000 });
                    // console.log(res);
                },
                onError: (err) => {
                    this.$toast.add({ severity: 'error', summary: 'Error!', detail: 'An error has occurred!', life: 3000 });
                }
            }
            );
        },
        clearSearch(){
            !this.search && this.gotoPage(1);
        },
        handleAction(id,action){
            router.post(`advert/${id}?action=${action}`, {},
            {
                onSuccess: (res) => {
                    this.$toast.add({ severity: 'success', summary: 'Successful', detail: res.props.flash.message, life: 3000 });
                },
                onError: (err) => {
                    this.$toast.add({ severity: 'error', summary: 'Error!', detail: err.message, life: 3000 });
                },
                preserveScroll: true
            }
            );
        }
    },
    mounted(){
        var page = this.adverts?.current_page === 1 ? this.adverts?.current_page :
        this.adverts?.per_page * (this.adverts?.current_page - 1);
        this.current_page = page ? page : 1;
    }
}
</script>

<template>
    <Head>
        <title>Adverts</title>
    </Head>
    <div class="grid">
        <div class="col-12">
            <div class="p-4 card lg:p-5">
                <h5>Adverts</h5>
                <DataTable
                    v-model:selection="selectedAdvert"
                    :value="adverts?.data ? adverts?.data : adverts"
                    class="p-datatable-gridlines"
                    dataKey="id"
                    v-model:filters="filters"
                    :rowHover="true"
                    responsiveLayout="scroll"
                    selectionMode="single"
                    :metaKeySelection="false"
                    @row-select="onRowSelect($event)"
                    @row-unselect="onRowUnselect($event)"
                >
                    <template #header>
                        <div class="flex justify-center lg:justify-end gap-2">
                            <span class="p-input-icon-left">
                                <i class="pi pi-search" />
                                <InputText
                                    v-model="search"
                                    @keyup.enter="searchAdvert()"
                                    @blur="search ? searchAdvert() : ()=>{}"
                                    @input="clearSearch"
                                    placeholder="Search" />
                            </span>
                        </div>
                    </template>
                    <template #empty> No adverts found. </template>
                    <Column header="Actions" style="min-width: 13rem">
                        <template #body="{data}">
                            <div class="p-buttonset">
                                <Button @click="handleAction(data.id,'approve')" :disabled="data.status === 'closed' || data.status === 'active'" icon="pi pi-thumbs-up" size="small" severity="success"/>
                                <Button icon="pi pi-eye" size="small"/>
                                <Button @click="handleAction(data.id,'reject')" :disabled="data.status === 'closed'" icon="pi pi-thumbs-down" size="small" severity="danger"/>
                            </div>
                        </template>
                    </Column>
                    <Column field="images" header="Image">
                        <template #body="{ data }">
                            <img alt="avatar" class="object-cover rounded" :src="data.images[0].source" width="80" style="vertical-align: middle" />
                        </template>
                    </Column>
                    <Column field="title" :sortable="true" header="Title" style="min-width: 12rem">
                    </Column>
                    <Column field="price" header="Price">
                        <template #body="{ data }">
                            {{ formatCurrency(data.price) }}
                        </template>
                    </Column>
                    <Column field="state" header="Location" style="min-width: 12rem">
                        <template #body="{ data }">
                            {{ data.lga }}, {{ data.state }}
                        </template>
                    </Column>
                    <Column field="status" header="Status">
                        <template #body="{ data }">
                            <span :class="'customer-badge status-' + (data.status === 'active'? 'qualified' : 'unqualified')">{{ data.status }}</span>
                        </template>
                    </Column>
                    <Column field="created_at" header="Date">
                        <template #body="{data}">
                            {{ formatDate(new Date(data.created_at)) }}
                        </template>
                    </Column>
                </DataTable>
                <Paginator
                    @click="handleClick($event)"
                    v-model:first="current_page"
                    :rows="adverts?.per_page"
                    :totalRecords="adverts?.total"
                    :template="{
                        '640px': 'PrevPageLink CurrentPageReport NextPageLink',
                        '960px': 'FirstPageLink PrevPageLink CurrentPageReport NextPageLink LastPageLink',
                        '1300px': 'FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink',
                        default: 'FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink'
                    }"
                />
            </div>
        </div>
    </div>
</template>

<style scoped lang="scss">
@import '@/assets/demo/styles/badges.scss';
</style>
