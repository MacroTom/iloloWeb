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
            selectedPlan: null,
            current_page: null,
            search: '',
            addVisible: false,
            updateVisible: false,
            form: {
                id: null,
                tag: '',
                icon: '',
                title: '',
                price: 0,
                discount: 0,
                duration: 0,
                properties: {
                    count: 1,
                    autorenew: null,
                    sms: false,
                    badge: null,
                    links: null
                },
                category_type: ''
            },
            icon: null,
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
            icons: [
                {title: 'Free', class: 'bx-cookie', count: 1, autorenew: null, sms: false, badge: null, links: false},
                {title: 'Regular', class: 'bx-trending-up', count: 5, autorenew: 24, sms: false, badge: null, links: false},
                {title: 'Premium', class: 'bx-crown', count: 20, autorenew: 12, sms: true, badge: 'Premium', links: false},
                {title: 'Gold', class: 'bx-trophy', count: 50, autorenew: 6, sms: true, badge: 'Gold', links: true},
                {title: 'Diamond', class: 'bx-diamond', count: 80, autorenew: 3, sms: true, badge: 'Diamond', links: true},
            ],
            category_types: [
                {title: 'Land & Properties', value: 'L'},
                {title: 'Cars', value: 'C'},
                {title: 'Others', value: 'O'}
            ],
            bools: [
                {title: 'No', value: false},
                {title: 'Yes', value: true},
            ],
            durations: [
                {title: '1 Month', value: 1},
                {title: '3 Months', value: 3},
                {title: '6 Months', value: 6}
            ],
            activeTab: 0,
        }
    },
    watch: {
        icon(){
            this.form.icon = this.icon?.class;
            this.form.title = this.icon?.title;
            this.form.properties.count = this.icon?.count;
            this.form.properties.autorenew = this.icon?.autorenew;
            this.form.properties.sms = this.icon?.sms;
            this.form.properties.badge = this.icon?.badge;
            this.form.properties.links = this.icon?.links;
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
                tag: '',
                icon: '',
                title: '',
                price: 0,
                discount: 0,
                duration: 0,
                properties: {
                    count: 1,
                    autorenew: null,
                    sms: false,
                    badge: null,
                    links: null
                },
                category_type: ''
            }
            this.activeTab = 0
            this.icon = null;
        },
        addPlan(button){
            button.disabled = true;
            if(
                this.form.title &&
                this.form.icon &&
                this.form.properties.count > 0 &&
                this.form.category_type
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
                            id: null,
                            tag: '',
                            icon: '',
                            title: '',
                            price: 0,
                            discount: 0,
                            duration: 0,
                            properties: {
                                count: 1,
                                autorenew: null,
                                sms: false,
                                badge: null,
                                links: null
                            },
                            category_type: ''
                        }
                        this.activeTab = 0
                        this.icon = null;
                    },
                    onError: (err) => {
                        console.log(err);
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
                tag: data.tag,
                icon: data.icon,
                title: data.title,
                price: data.price,
                discount: data.discount,
                duration: data.duration,
                properties: data.properties,
                category_type: data.category_type
            }
            this.updateVisible = true;
        },
        updatePlan(button){
            router.post('updateplan/'+this.form.id, this.form,
            {
                onSuccess: (res) => {
                    this.$toast.add({ severity: 'success', summary: 'Successful', detail: res.props.flash.message, life: 3000 });
                    this.form = {
                        id: null,
                        tag: '',
                        icon: '',
                        title: '',
                        price: 0,
                        discount: 0,
                        duration: 0,
                        properties: {
                            count: 1,
                            autorenew: null,
                            sms: false,
                            badge: null,
                            links: null
                        },
                        category_type: ''
                    }
                    this.updateVisible = false;
                    this.activeTab = 0;
                    this.icon = null;
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
                    v-model:selection="selectedPlan"
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
                    <Column field="icon" header="Icon">
                        <template #body="{ data }">
                            <i :class="data.icon" class="bx text-slate-600 text-xl mr-2"></i>
                        </template>
                    </Column>
                    <Column header="Type">
                        <template #body="{ data }">
                            {{ data.category_type }}
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
                    <Column field="duration" header="Duration" style="min-width: 8rem">
                        <template #body="{ data }">
                            {{ data.duration  }} {{ data.duration > 1 ? 'Months' : 'Month' }}
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
                                <label>Icon*</label>
                                <Dropdown v-model="icon" :options="icons" optionLabel="title" placeholder="Select an Icon" class="w-full">
                                    <template #value="slotProps">
                                        <div v-if="slotProps.value" class="flex align-items-center">
                                            <i :class="slotProps.value.class" class="bx text-slate-600 text-xl mr-2"></i>
                                        </div>
                                        <span v-else>
                                            {{ slotProps.placeholder }}
                                        </span>
                                    </template>
                                    <template #option="slotProps">
                                        <div class="flex align-items-center">
                                            <i :class="slotProps.option.class" class="bx text-slate-600 text-xl mr-2"></i>
                                            <div>{{ slotProps.option.title }}</div>
                                        </div>
                                    </template>
                                </Dropdown>
                            </div>
                            <div class="flex flex-column gap-2 mb-2">
                                <label for="title">Tag</label>
                                <Dropdown v-model="form.tag" :options="['','Most Popular','Recommended','Best value']" placeholder="" class="w-full" />
                            </div>
                            <div class="flex gap-2 mb-2 flex-column">
                                <label>Title*</label>
                                <InputText id="title" v-model="form.title" />
                                <!-- <small id="values-help">This is the name of the property! <strong>e.g Laptop Brand</strong></small> -->
                            </div>
                            <div class="flex gap-2 mb-2 flex-column">
                                <label>Price*</label>
                                <InputNumber v-model="form.price" :min="0" prefix="₦ " inputId="integeronly"/>
                                <small id="values-help"><strong>Leave price as ₦0</strong>, if it's free</small>
                            </div>
                            <div class="flex gap-2 mb-2 flex-column">
                                <label>Discount*</label>
                                <InputNumber v-model="form.discount" :min="0" suffix="%" :useGrouping="false" inputId="integeronly" />
                                <small id="values-help">Discount should be in <strong>Percentage</strong>! If no Discount, leave as 0%.</small>
                            </div>
                            <div class="flex gap-2 mb-2 flex-column">
                                <div class="flex flex-column gap-2 mb-2">
                                    <label for="title">Category Type*</label>
                                    <Dropdown v-model="form.category_type" :options="category_types" optionLabel="title" optionValue="value" placeholder="" class="w-full" />
                                </div>
                            </div>
                        </TabPanel>
                        <TabPanel header="Additional details">
                            <div class="flex gap-2 mb-2 flex-column">
                                <div class="flex flex-column gap-2 mb-2">
                                    <label for="title">Duration*</label>
                                    <Dropdown v-model="form.duration" :options="durations" optionLabel="title" optionValue="value" placeholder="" class="w-full" />
                                </div>
                            </div>
                            <div class="flex gap-2 mb-2 flex-column">
                                <label>No of Ads*</label>
                                <InputNumber v-model="form.properties.count" :min="0" :suffix="form.properties?.count > 1 ? ' ads' : ' ad'" :useGrouping="false" inputId="integeronly" />
                            </div>
                            <div class="flex gap-2 mb-2 flex-column">
                                <label>Ad Indication*</label>
                                <InputText placeholder="<Blank>" v-model="form.properties.badge"/>
                            </div>
                            <div class="flex gap-2 mb-2 flex-column">
                                <label>Ad Auto renew*</label>
                                <InputNumber v-model="form.properties.autorenew" :min="0" :suffix="form.properties?.autorenew > 1 ? ' hours' : ' hour'" :useGrouping="false" inputId="integeronly" />
                            </div>
                            <div class="flex gap-2 mb-2 flex-column">
                                <label>New message notifications*</label>
                                <SelectButton class="w-full" v-model="form.properties.sms" :options="bools" optionLabel="title" optionValue="value" aria-labelledby="basic" />
                            </div>
                            <div class="flex gap-2 mb-2 flex-column">
                                <label>Website & Social media link inclusion*</label>
                                <SelectButton class="w-full" v-model="form.properties.links" :options="bools" optionLabel="title" optionValue="value" aria-labelledby="basic" />
                            </div>
                        </TabPanel>
                    </TabView>
                    <template #footer>
                        <Button label="Cancel" icon="pi pi-times" @click="addVisible = false" text />
                        <Button v-if="activeTab == 0" label="Next" icon="pi pi-arrow-right" @click="activeTab = 1" autofocus />
                        <Button v-else label="Add" icon="pi pi-check" @click="addPlan(this)" autofocus />
                    </template>
                </Dialog>
                <Dialog v-model:visible="updateVisible" modal :header="`New plan`" :style="{ width: '30vw' }" :breakpoints="{ '960px': '50vw', '641px': '50vw', '360px': '90vw'  }">
                    <TabView v-model:activeIndex="activeTab">
                        <TabPanel header="Basic info">
                            <div class="flex gap-2 mb-2 flex-column">
                                <label>Icon*</label>
                                <Dropdown v-model="icon" :options="icons" optionLabel="title" placeholder="Select an Icon" class="w-full">
                                    <template #value="slotProps">
                                        <div v-if="slotProps.value" class="flex align-items-center">
                                            <i :class="slotProps.value.class" class="bx text-slate-600 text-xl mr-2"></i>
                                        </div>
                                        <span v-else>
                                            {{ slotProps.placeholder }}
                                        </span>
                                    </template>
                                    <template #option="slotProps">
                                        <div class="flex align-items-center">
                                            <i :class="slotProps.option.class" class="bx text-slate-600 text-xl mr-2"></i>
                                            <div>{{ slotProps.option.title }}</div>
                                        </div>
                                    </template>
                                </Dropdown>
                            </div>
                            <div class="flex flex-column gap-2 mb-2">
                                <label for="title">Tag</label>
                                <Dropdown v-model="form.tag" :options="['','Most Popular','Recommended','Best value']" placeholder="" class="w-full" />
                            </div>
                            <div class="flex gap-2 mb-2 flex-column">
                                <label>Title*</label>
                                <InputText id="title" v-model="form.title" />
                                <!-- <small id="values-help">This is the name of the property! <strong>e.g Laptop Brand</strong></small> -->
                            </div>
                            <div class="flex gap-2 mb-2 flex-column">
                                <label>Price*</label>
                                <InputNumber v-model="form.price" :min="0" prefix="₦ " inputId="integeronly"/>
                                <small id="values-help"><strong>Leave price as ₦0</strong>, if it's free</small>
                            </div>
                            <div class="flex gap-2 mb-2 flex-column">
                                <label>Discount*</label>
                                <InputNumber v-model="form.discount" :min="0" suffix="%" :useGrouping="false" inputId="integeronly" />
                                <small id="values-help">Discount should be in <strong>Percentage</strong>! If no Discount, leave as 0%.</small>
                            </div>
                            <div class="flex gap-2 mb-2 flex-column">
                                <div class="flex flex-column gap-2 mb-2">
                                    <label for="title">Category Type*</label>
                                    <Dropdown v-model="form.category_type" :options="category_types" optionLabel="title" optionValue="value" placeholder="" class="w-full" />
                                </div>
                            </div>
                        </TabPanel>
                        <TabPanel header="Additional details">
                            <div class="flex gap-2 mb-2 flex-column">
                                <div class="flex flex-column gap-2 mb-2">
                                    <label for="title">Duration*</label>
                                    <Dropdown v-model="form.duration" :options="durations" optionLabel="title" optionValue="value" placeholder="" class="w-full" />
                                </div>
                            </div>
                            <div class="flex gap-2 mb-2 flex-column">
                                <label>No of Ads*</label>
                                <InputNumber v-model="form.properties.count" :min="0" :suffix="form.properties?.count > 1 ? ' ads' : ' ad'" :useGrouping="false" inputId="integeronly" />
                            </div>
                            <div class="flex gap-2 mb-2 flex-column">
                                <label>Ad Indication*</label>
                                <InputText placeholder="<Blank>" v-model="form.properties.badge"/>
                            </div>
                            <div class="flex gap-2 mb-2 flex-column">
                                <label>Ad Auto renew*</label>
                                <InputNumber v-model="form.properties.autorenew" :min="0" :suffix="form.properties?.autorenew > 1 ? ' hours' : ' hour'" :useGrouping="false" inputId="integeronly" />
                            </div>
                            <div class="flex gap-2 mb-2 flex-column">
                                <label>New message notifications*</label>
                                <SelectButton class="w-full" v-model="form.properties.sms" :options="bools" optionLabel="title" optionValue="value" aria-labelledby="basic" />
                            </div>
                            <div class="flex gap-2 mb-2 flex-column">
                                <label>Website & Social media link inclusion*</label>
                                <SelectButton class="w-full" v-model="form.properties.links" :options="bools" optionLabel="title" optionValue="value" aria-labelledby="basic" />
                            </div>
                        </TabPanel>
                    </TabView>
                    <template #footer>
                        <Button label="Cancel" icon="pi pi-times" @click="updateVisible = false" text />
                        <Button v-if="activeTab == 0" label="Next" icon="pi pi-arrow-right" @click="activeTab = 1" autofocus />
                        <Button v-else label="Update" icon="pi pi-check" @click="updatePlan(this)" autofocus />
                    </template>
                </Dialog>
            </div>
        </div>
    </div>
</template>

<style scoped lang="scss">
@import '@/assets/demo/styles/badges.scss';
</style>
