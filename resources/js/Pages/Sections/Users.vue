<script>
import { markRaw } from 'vue';
import { FilterMatchMode, FilterOperator } from 'primevue/api';
import AppLayout from '../../layout/AppLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import Formlayout from '../../Components/Form.vue';
import Bottomnavigationbar from '../../Components/Bottomnavigationbar.vue';
export default{
    props:{
        auth: Object,
        users: Object
    },
    components:{
        Head,
        Link,
        Formlayout,
        Bottomnavigationbar,
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
            filters1: null,
            selectedUser: null,
            current_page: null,
            search: '',
        }
    },
    methods:{
        formatCurrency(value){
            return value.toLocaleString('en-US', { style: 'currency', currency: 'USD' });
        },
        formatDate(value){
            return value.toLocaleDateString('en-US', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric'
            });
        },
        onRowSelect(evt){
            this.selectedUser = evt.data;
            var id = this.selectedUser.id;
            router.get(`user/${id}`, {},
            {
                onError: (err) => {
                    this.$toast.add({ severity: 'error', summary: 'Error!', detail: err.message, life: 3000 });
                }
            }
            );
        },
        onRowUnselect(evt){
        },
        gotoPage(page){
            router.get(`users?page=${page}`, {},
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
                const page = this.current_page === 0 ? 1 : Math.floor((this.current_page/this.users?.per_page))+1;
                this.gotoPage(page);
            }
        },
        searchUser(){
            router.get(`users?q=${this.search}`, {},
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
        }
    },
    mounted(){
        var page = this.users?.current_page === 1 ? this.users?.current_page :
        this.users?.per_page * (this.users?.current_page - 1);
        this.current_page = page ? page : 1;
    }
}
</script>

<template>
    <Head>
        <title>Users</title>
    </Head>
    <div class="grid">
        <div class="col-12">
            <div class="p-4 card lg:p-5">
                <h5>Users</h5>
                <DataTable
                    v-model:selection="selectedUser"
                    :value="users?.data ? users?.data : users"
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
                                    @keyup.enter="searchUser"
                                    @blur="search ? searchUser() : ()=>{}"
                                    @input="clearSearch"
                                    placeholder="Search" />
                            </span>
                        </div>
                    </template>
                    <template #empty> No users found. </template>
                    <Column field="avatar" header="Avatar">
                        <template #body="{ data }">
                            <img v-if="data.avatar" alt="avatar" :src="'/demo/images/avatar/ionibowcher.png'" width="50" style="vertical-align: middle" />
                            <Avatar v-else :label="data.firstname[0] + data.lastname[0]" class="mr-2" size="large" shape="circle" />
                            <!-- <img alt="avatar" :src="'/demo/images/avatar/' + data.avatar" width="32" style="vertical-align: middle" /> -->
                        </template>
                    </Column>
                    <Column field="firstname" :sortable="true" header="Name" style="min-width: 12rem">
                        <template #body="{data}">
                            {{ data.firstname }} {{ data.lastname }}
                        </template>
                    </Column>
                    <Column field="email" header="Email" style="min-width: 12rem"></Column>
                    <Column field="phone" header="Phone"></Column>
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
                    :rows="users?.per_page"
                    :totalRecords="users?.total"
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
