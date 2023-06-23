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
        plans: Object,
        categories: Object
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
            addVisible: false,
            updateVisible: false,
            form: {
                id: null,
                title: '',
                price: 0,
                discount: 0,
                properties: {
                    adnumber: 0,
                    adindication: '',
                    adautorenew: 'No',
                    newmessage: 'No',
                    websociallink: 'No'
                },
                categories: []
            },
            selectedProperty: null,
            category: null,
            properties: [
                { title: 'No of Ads' },
                { title: 'Ads indications' },
                { title: 'Ads auto-renew' },
                { title: 'New message notifications' },
                { title: 'Social media links' },
                { title: 'Website link' },
                { title: 'Email Promotion' }
            ],
            activeTab: 0,
        }
    },
    watch: {
        // whenever category changes, this function will run
        category(newCategory, oldCategory) {
            if(newCategory !== null){
                !this.form.categories.includes(newCategory) && this.form.categories.push(newCategory);
            }
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
            router.get(`plans?page=${page}`, {},
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
                const page = this.current_page === 0 ? 1 : Math.floor((this.current_page/this.plans?.per_page))+1;
                this.gotoPage(page);
            }
        },
        searchPlan(){
            router.get(`plans?q=${this.search}`, {},
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
        addButtonClicked(){
            this.addVisible = true;
            this.form = {
                id: null,
                title: '',
                price: 0,
                discount: 0,
                properties: {
                    adnumber: 0,
                    adindication: '',
                    adautorenew: 'No',
                    newmessage: 'No',
                    websociallink: 'No'
                },
                categories: []
            }
        },
        addPlan(button){
            button.disabled = true;
            if(
                this.form.title &&
                this.form.price > 0 &&
                this.form.properties.adnumber > 0 &&
                this.form.categories.length > 0
            ){
                if(!this.form.discount){
                    this.form.discount = 0;
                }
                router.post('addplan', this.form,
                {
                    onSuccess: (res) => {
                        this.$toast.add({ severity: 'success', summary: 'Successful', detail: res.props.flash.message, life: 3000 });
                        this.addVisible = false;
                        button.disabled = false;
                        this.form = {
                            title: '',
                            price: 0,
                            discount: 0,
                            properties: {
                                adnumber: 0,
                                adindication: '',
                                adautorenew: 'No',
                                newmessage: 'No',
                                websociallink: 'No'
                            },
                            categories: []
                        }
                    },
                    onError: (err) => {
                        button.disabled = false;
                        this.$toast.add({ severity: 'error', summary: 'Error!', detail: err.message, life: 3000 });
                    },
                },
                );
            }
            else{
                button.disabled = false;
                this.$toast.add({ severity: 'error', summary: 'Error!', detail: 'Please complete the form!', life: 3000 });
            }
        },
        updateModal(button, data){
            button.disabled = true;
            this.form = {
                id: data.id,
                title: data.title,
                price: data.price,
                discount: data.discount,
                properties: JSON.parse(data.properties),
                categories: data.categories
            }
            this.updateVisible = true;
        },
        updatePlan(button){
            router.post('updateplan/'+this.form.id, this.form,
            {
                onSuccess: (res) => {
                    this.$toast.add({ severity: 'success', summary: 'Successful', detail: res.props.flash.message, life: 3000 });
                    this.form = {
                        title: '',
                        price: 0,
                        discount: 0,
                        properties: {
                            adnumber: 0,
                            adindication: '',
                            adautorenew: 'No',
                            newmessage: 'No',
                            websociallink: 'No'
                        },
                        categories: []
                    }
                    this.updateVisible = false;
                },
                onError: (err) => {
                    this.$toast.add({ severity: 'error', summary: 'Error!', detail: err.message, life: 3000 });
                    button.disabled = false;
                },
            },
            );
        },
        deletePlan(button,id){
            button.disabled = true;
            this.$confirm.require({
                message: 'Do you want to delete this plan?',
                header: 'Delete Confirmation',
                icon: 'pi pi-info-circle',
                acceptClass: 'p-button-danger',
                accept: () => {
                    router.post('deleteplan/'+id, {},
                    {
                        onSuccess: (res) => {
                            this.$toast.add({ severity: 'success', summary: 'Successful', detail: res.props.flash.message, life: 3000 });
                        },
                        onError: (err) => {
                            this.$toast.add({ severity: 'error', summary: 'Error!', detail: err.message, life: 3000 });
                            button.disabled = false;
                        },
                    },
                    );
                },
                reject: () => {
                    button.disabled = false;
                }
            });
        }
    },
    mounted(){
        var page = this.plans?.current_page === 1 ? this.plans?.current_page :
        this.plans?.per_page * (this.plans?.current_page - 1);
        this.current_page = page ? page : 1;
    }
}
</script>

<template>
    <Head>
        <title>Plans</title>
    </Head>
    <div class="grid">
        <div class="col-12">
            <div class="p-4 card lg:p-5">
                <h5>Plans</h5>
                <DataTable
                    v-model:selection="selectedUser"
                    :value="plans?.data ? plans?.data : plans"
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
                        <div class="flex flex-col items-center justify-center gap-2 md:flex-row md:justify-between">
                            <Button icon="pi pi-plus" size="small" label="Add" @click="addButtonClicked"/>
                            <span class="p-input-icon-left">
                                <i class="pi pi-search" />
                                <InputText
                                    v-model="search"
                                    @keyup.enter="searchPlan"
                                    @blur="search ? searchPlan() : ()=>{}"
                                    @input="clearSearch"
                                    placeholder="Search" />
                            </span>
                        </div>
                    </template>
                    <template #empty> No plans found. </template>
                    <Column header="Actions" style="min-width: 10rem">
                        <template #body="{data}">
                            <div class="p-buttonset">
                                <Button icon="pi pi-pencil" size="small" @click="updateModal(this,data)"/>
                                <Button icon="pi pi-trash" size="small" severity="danger" @click="deletePlan(this,data.id)"/>
                            </div>
                        </template>
                    </Column>
                    <Column field="title" :sortable="true" header="Name" style="min-width: 12rem">
                    </Column>
                    <Column field="price" header="Price">
                        <template #body="{ data }">
                            {{ formatCurrency(data.price) }}
                        </template>
                    </Column>
                    <Column field="discount" header="Discount">
                        <template #body="{ data }">
                            {{ data.discount }}%
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
                    :rows="plans?.per_page"
                    :totalRecords="plans?.total"
                    :template="{
                        '640px': 'PrevPageLink CurrentPageReport NextPageLink',
                        '960px': 'FirstPageLink PrevPageLink CurrentPageReport NextPageLink LastPageLink',
                        '1300px': 'FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink',
                        default: 'FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink'
                    }"
                />
                <Dialog v-model:visible="addVisible" modal :header="`New plan`" :style="{ width: '30vw' }" :breakpoints="{ '960px': '50vw', '641px': '50vw', '360px': '90vw'  }">
                    <TabView v-model:activeIndex="activeTab">
                        <TabPanel header="Basic info">
                            <div class="flex gap-2 mb-2 flex-column">
                                <label>Title*</label>
                                <InputText id="title" v-model="form.title" />
                                <!-- <small id="values-help">This is the name of the property! <strong>e.g Laptop Brand</strong></small> -->
                            </div>
                            <div class="flex gap-2 mb-2 flex-column">
                                <label>Price*</label>
                                <InputNumber v-model="form.price" :min="0" prefix="₦ " inputId="integeronly"/>
                                <!-- <small id="values-help">This is the text that will show above the option component! <strong>e.g Brand</strong>.</small> -->
                            </div>
                            <div class="flex gap-2 mb-2 flex-column">
                                <label>Discount*</label>
                                <InputNumber v-model="form.discount" :min="0" suffix="%" :useGrouping="false" inputId="integeronly" />
                                <small id="values-help">Discount should be in <strong>Percentage</strong>! If no Discount, leave as 0%.</small>
                            </div>
                            <div class="flex gap-2 mb-2 flex-column">
                                <label for="title">Categories*</label>
                                <Chips class="disabled" v-model="form.categories" separator=",">
                                    <template #chip="data">
                                        {{ data.value.title }}
                                    </template>
                                </Chips>
                                <Dropdown v-model="category" :options="categories" placeholder="Select categories" optionLabel="title" class="w-full text-lg" />
                                <small id="values-help">You can add as many categories as you want!</small>
                            </div>
                        </TabPanel>
                        <TabPanel header="Additional details">
                            <div class="flex gap-2 mb-2 flex-column">
                                <label>No of Ads*</label>
                                <InputNumber v-model="form.properties.adnumber" :min="0" :suffix="form.properties?.adnumber > 1 ? ' ads' : ' ad'" :useGrouping="false" inputId="integeronly" />
                            </div>
                            <div class="flex gap-2 mb-2 flex-column">
                                <label>Ad Indication*</label>
                                <InputText placeholder="<Blank>" v-model="form.properties.adindication"/>
                            </div>
                            <div class="flex gap-2 mb-2 flex-column">
                                <label>Ad Auto renew*</label>
                                <SelectButton class="w-full" v-model="form.properties.adautorenew" :options="['No','Yes']" aria-labelledby="basic" />
                            </div>
                            <div class="flex gap-2 mb-2 flex-column">
                                <label>New message notifications*</label>
                                <SelectButton class="w-full" v-model="form.properties.newmessage" :options="['No','Yes']" aria-labelledby="basic" />
                            </div>
                            <div class="flex gap-2 mb-2 flex-column">
                                <label>Website & Social media link inclusion*</label>
                                <SelectButton class="w-full" v-model="form.properties.websociallink" :options="['No','Yes']" aria-labelledby="basic" />
                            </div>
                        </TabPanel>
                    </TabView>
                    <template #footer>
                        <Button label="Cancel" icon="pi pi-times" @click="addVisible = false" text />
                        <Button v-if="activeTab == 0" label="Next" icon="pi pi-arrow-right" @click="activeTab = 1" autofocus />
                        <Button v-else label="Add" icon="pi pi-check" @click="addPlan(this)" autofocus />
                    </template>
                </Dialog>
                <Dialog v-model:visible="updateVisible" modal :header="`Edit plan`" :style="{ width: '30vw' }" :breakpoints="{ '960px': '50vw', '641px': '50vw', '360px': '90vw'  }">
                    <TabView v-model:activeIndex="activeTab">
                        <TabPanel header="Basic info">
                            <div class="flex gap-2 mb-2 flex-column">
                                <label>Title*</label>
                                <InputText id="title" v-model="form.title" />
                                <!-- <small id="values-help">This is the name of the property! <strong>e.g Laptop Brand</strong></small> -->
                            </div>
                            <div class="flex gap-2 mb-2 flex-column">
                                <label>Price*</label>
                                <InputNumber v-model="form.price" :min="0" prefix="₦ " inputId="integeronly"/>
                                <!-- <small id="values-help">This is the text that will show above the option component! <strong>e.g Brand</strong>.</small> -->
                            </div>
                            <div class="flex gap-2 mb-2 flex-column">
                                <label>Discount*</label>
                                <InputNumber v-model="form.discount" :min="0" suffix="%" :useGrouping="false" inputId="integeronly" />
                                <small id="values-help">Discount should be in <strong>Percentage</strong>! If no Discount, leave as 0%.</small>
                            </div>
                            <div class="flex gap-2 mb-2 flex-column">
                                <label for="title">Categories*</label>
                                <Chips class="disabled" v-model="form.categories" separator=",">
                                    <template #chip="data">
                                        {{ data.value.title }}
                                    </template>
                                </Chips>
                                <Dropdown v-model="category" :options="categories" placeholder="Select categories" optionLabel="title" class="w-full text-lg" />
                                <small id="values-help">You can add as many categories as you want!</small>
                            </div>
                        </TabPanel>
                        <TabPanel header="Additional details">
                            <div class="flex gap-2 mb-2 flex-column">
                                <label>No of Ads*</label>
                                <InputNumber v-model="form.properties.adnumber" :min="0" :suffix="form.properties?.adnumber > 1 ? ' ads' : ' ad'" :useGrouping="false" inputId="integeronly" />
                            </div>
                            <div class="flex gap-2 mb-2 flex-column">
                                <label>Ad Indication*</label>
                                <InputText placeholder="<Blank>" v-model="form.properties.adindication"/>
                            </div>
                            <div class="flex gap-2 mb-2 flex-column">
                                <label>Ad Auto renew*</label>
                                <SelectButton class="w-full" v-model="form.properties.adautorenew" :options="['No','Yes']" aria-labelledby="basic" />
                            </div>
                            <div class="flex gap-2 mb-2 flex-column">
                                <label>New message notifications*</label>
                                <SelectButton class="w-full" v-model="form.properties.newmessage" :options="['No','Yes']" aria-labelledby="basic" />
                            </div>
                            <div class="flex gap-2 mb-2 flex-column">
                                <label>Website & Social media link inclusion*</label>
                                <SelectButton class="w-full" v-model="form.properties.websociallink" :options="['No','Yes']" aria-labelledby="basic" />
                            </div>
                        </TabPanel>
                    </TabView>
                    <template #footer>
                        <Button label="Cancel" icon="pi pi-times" @click="updateVisible = false" text />
                        <Button v-if="activeTab == 0" label="Next" icon="pi pi-arrow-right" @click="activeTab = 1" autofocus />
                        <Button v-else label="Add" icon="pi pi-check" @click="updatePlan(this)" autofocus />
                    </template>
                </Dialog>
            </div>
        </div>
    </div>
</template>

<style scoped lang="scss">
@import '@/assets/demo/styles/badges.scss';
</style>
