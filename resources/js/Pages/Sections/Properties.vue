<script>
import AppLayout from '../../layout/AppLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
export default{
    props:{
        auth: Object,
        properties: Object,
        categories: Object,
    },
    components:{
        Head,
        Link,
        AppLayout
    },
    layout: AppLayout,
    data(){
        return{
            selectedProperty: null,
            search: '',
            addVisible: false,
            updateVisible: false,
            values: [],
            form: {
                title: '',
                label: '',
                propertyValues: null,
                categories: []
            },
            category: null
        }
    },
    watch: {
        // whenever category changes, this function will run
        category(newCategory, oldCategory) {
            newCategory !== null && !this.form.categories.includes(newCategory) && this.form.categories.push(newCategory);
        }
    },
    methods:{
        addButtonClicked(){
            this.addVisible = true;
            this.form = {
                title: '',
                label: '',
                propertyValues: null,
                categories: []
            }
        },
        addProperty(){
            router.post('addproperty', this.form,
            {
                onSuccess: (res) => {
                    this.$toast.add({ severity: 'success', summary: 'Successful', detail: res.props.flash.message, life: 3000 });
                    this.addVisible = false;
                    this.form = {
                        title: '',
                        label: '',
                        propertyValues: null,
                        categories: []
                    }
                },
                onError: (err) => {
                    this.$toast.add({ severity: 'error', summary: 'Error!', detail: err.message, life: 3000 });
                },
            },

            );
        },
        updateModal(button, data){
            button.disabled = true;
            this.form = {
                id: data.id,
                title: data.title,
                label: data?.label,
                propertyValues: data?.values,
                categories: data?.categories
            }
            this.updateVisible = true;
        },
        updateProperty(button){
            router.post('updateproperty/'+this.form.id, this.form,
            {
                onSuccess: (res) => {
                    this.$toast.add({ severity: 'success', summary: 'Successful', detail: res.props.flash.message, life: 3000 });
                    this.form = {
                        title: '',
                        label: '',
                        propertyValues: null,
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
        deleteProperty(button,id){
            button.disabled = true;
            this.$confirm.require({
                message: 'Do you want to delete this property?',
                header: 'Delete Confirmation',
                icon: 'pi pi-info-circle',
                acceptClass: 'p-button-danger',
                accept: () => {
                    router.post('deleteproperty/'+id, {},
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
        },
        formatDate(value){
            return value.toLocaleDateString('en-US', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric'
            });
        },
        toJSON(text){
            return JSON.parse(text);
        }
    },
    mounted(){
        // console.log(this.properties);
    }
}
</script>

<template>
    <Head>
        <title>Properties</title>
    </Head>
    <div class="grid">
        <div class="col-12">
            <div class="p-4 card lg:p-5">
                <h5>Properties</h5>
                <DataTable
                    paginator
                    :rows="6"
                    paginatorTemplate="PrevPageLink CurrentPageReport NextPageLink"
                    stripedRows
                    v-model:selection="selectedProperty"
                    :value="properties?.data ? properties?.data : properties"
                    dataKey="id"
                    responsiveLayout="scroll"
                >
                    <template #header>
                        <div class="flex flex-col md:flex-row items-center justify-center md:justify-between gap-2">
                            <Button icon="pi pi-plus" size="small" label="Add" @click="addButtonClicked"/>
                            <span class="p-input-icon-left">
                                <i class="pi pi-search" />
                                <InputText
                                    v-model="search"
                                    @keyup.enter="()=>{}"
                                    @blur="search ? ()=>{} : ()=>{}"
                                    @input="()=>{}"
                                    placeholder="Search" />
                            </span>
                        </div>
                    </template>
                    <template #empty> No properties yet. </template>
                    <Column header="Actions" style="min-width: 10rem">
                        <template #body="{data}">
                            <div class="p-buttonset">
                                <Button icon="pi pi-pencil" size="small" @click="updateModal(this,data)"/>
                                <Button icon="pi pi-trash" size="small" severity="danger" @click="deleteProperty(this,data.id)"/>
                            </div>
                        </template>
                    </Column>
                    <Column field="title" :sortable="true" header="Title" style="min-width: 12rem">
                    </Column>
                    <Column field="label" :sortable="true" header="Label" style="min-width: 12rem">
                        <template #body="{data}">
                            {{ data?.label ? data?.label : '<Blank>' }}
                        </template>
                    </Column>
                    <Column field="created_at" header="Date">
                        <template #body="{data}">
                            {{ formatDate(new Date(data.created_at)) }}
                        </template>
                    </Column>
                </DataTable>
                <Dialog v-model:visible="addVisible" modal header="New property" :style="{ width: '30vw' }" :breakpoints="{ '960px': '50vw', '641px': '50vw', '360px': '90vw'  }">
                    <div class="flex flex-column gap-2 mb-2">
                        <label for="title">Title*</label>
                        <InputText id="title" v-model="form.title" />
                        <small id="values-help">This is the name of the property! <strong>e.g Laptop Brand</strong></small>
                    </div>
                    <div class="flex flex-column gap-2 mb-2">
                        <label for="title">Label</label>
                        <InputText id="title" v-model="form.label" />
                        <small id="values-help">This is the text that will show above the option component! <strong>e.g Brand</strong>.</small>
                    </div>
                    <div class="flex flex-column gap-2 mb-2">
                        <label for="values">Values*</label>
                        <Chips v-model="form.propertyValues" separator="," />
                        <small id="values-help">The values should be <strong>comma separated</strong> or Press <strong>enter key</strong> to add a value after typing!</small>
                    </div>
                    <div class="flex flex-column gap-2 mb-2">
                        <label for="title">Categories*</label>
                        <Chips class="disabled" v-model="form.categories" separator=",">
                            <template #chip="data">
                                {{ data.value.title }}
                            </template>
                        </Chips>
                        <Dropdown v-model="category" :options="categories" placeholder="Choose a category" optionLabel="title" class="w-full text-lg" />
                        <small id="values-help">You can add as many categories as you want!</small>
                    </div>
                    <template #footer>
                        <Button label="Cancel" icon="pi pi-times" @click="addVisible = false" text />
                        <Button label="Add" icon="pi pi-check" @click="addProperty" autofocus />
                    </template>
                </Dialog>
                <Dialog v-model:visible="updateVisible" modal header="Update property" :style="{ width: '30vw' }" :breakpoints="{ '960px': '50vw', '641px': '50vw', '360px': '90vw'  }">
                    <div class="flex flex-column gap-2 mb-2">
                        <label for="title">Title*</label>
                        <InputText id="title" v-model="form.title" />
                        <small id="values-help">This is the name of the property! <strong>e.g Laptop Brand</strong></small>
                    </div>
                    <div class="flex flex-column gap-2 mb-2">
                        <label for="title">Label</label>
                        <InputText id="title" v-model="form.label" />
                        <small id="values-help">This is the text that will show above the option component! <strong>e.g Brand</strong>.</small>
                    </div>
                    <div class="flex flex-column gap-2 mb-2">
                        <label for="values">Values*</label>
                        <Chips v-model="form.propertyValues" separator="," />
                        <small id="values-help">The values should be <strong>comma separated</strong> or Press <strong>enter key</strong> to add a value after typing!</small>
                    </div>
                    <div class="flex flex-column gap-2 mb-2">
                        <label for="title">Categories*</label>
                        <Chips class="disabled" v-model="form.categories" separator=",">
                            <template #chip="data">
                                {{ data.value.title }}
                            </template>
                        </Chips>
                        <Dropdown v-model="category" :options="categories" placeholder="Choose a category" optionLabel="title" class="w-full text-lg" />
                        <small id="values-help">You can add as many categories as you want!</small>
                    </div>
                    <template #footer>
                        <Button label="Cancel" icon="pi pi-times" @click="updateVisible = false" text />
                        <Button label="Update" icon="pi pi-check" @click="updateProperty(this)" autofocus />
                    </template>
                </Dialog>
            </div>
        </div>
    </div>
</template>

<style scoped lang="scss">
@import '@/assets/demo/styles/badges.scss';
</style>
