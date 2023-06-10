<script>
import AppLayout from '../../layout/AppLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
export default{
    props:{
        auth: Object,
        categories: Object
    },
    components:{
        Head,
        Link,
        AppLayout
    },
    layout: AppLayout,
    data(){
        return{
            selectedCategory: null,
            search: '',
            addVisible: false,
            updateVisible: false,
            values: [],
            form: {
                title: ''
            }
        }
    },
    methods:{
        addCategory(){
            router.post('addcategory', this.form,
            {
                onSuccess: (res) => {
                    this.$toast.add({ severity: 'success', summary: 'Successful', detail: res.props.flash.message, life: 3000 });
                    this.addVisible = false;
                    this.form = {
                        title: ''
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
                title: data.title
            }
            this.updateVisible = true;
        },
        updateCategory(button){
            router.post('updatecategory/'+this.form.id, this.form,
            {
                onSuccess: (res) => {
                    this.$toast.add({ severity: 'success', summary: 'Successful', detail: res.props.flash.message, life: 3000 });
                    this.form = {
                        title: ''
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
        deleteCategory(button,id){
            button.disabled = true;
            this.$confirm.require({
                message: 'Do you want to delete this property?',
                header: 'Delete Confirmation',
                icon: 'pi pi-info-circle',
                acceptClass: 'p-button-danger',
                accept: () => {
                    router.post('deletecategory/'+id, {},
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
        }
    },
    mounted(){
        // console.log(this.categories);
    }
}
</script>

<template>
    <Head>
        <title>Categories</title>
    </Head>
    <div class="grid">
        <div class="col-12">
            <div class="p-4 card lg:p-5">
                <h5>Categories</h5>
                <DataTable
                    paginator
                    :rows="6"
                    paginatorTemplate="PrevPageLink CurrentPageReport NextPageLink"
                    stripedRows
                    v-model:selection="selectedCategory"
                    :value="categories?.data ? categories?.data : categories"
                    dataKey="id"
                    responsiveLayout="scroll"
                >
                    <template #header>
                        <div class="flex flex-col md:flex-row items-center justify-center md:justify-between gap-2">
                            <Button icon="pi pi-plus" size="small" label="Add" @click="addVisible = true"/>
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
                    <template #empty> No categories yet. </template>
                    <Column header="Actions" style="min-width: 10rem">
                        <template #body="{data}">
                            <div class="p-buttonset">
                                <Button icon="pi pi-pencil" size="small" @click="updateModal(this,data)"/>
                                <Button icon="pi pi-trash" size="small" severity="danger" @click="deleteCategory(this,data.id)"/>
                            </div>
                        </template>
                    </Column>
                    <Column field="title" :sortable="true" header="Title" style="min-width: 12rem">
                    </Column>
                    <Column field="image" header="Image" style="min-width: 12rem">
                        <template #body="{data}">
                            {{ data?.image ? '<Image>' : '<Blank>' }}
                        </template>
                    </Column>
                    <Column field="created_at" header="Date">
                        <template #body="{data}">
                            {{ formatDate(new Date(data.created_at)) }}
                        </template>
                    </Column>
                </DataTable>
                <Dialog v-model:visible="addVisible" modal header="New category" :style="{ width: '30vw' }" :breakpoints="{ '960px': '50vw', '641px': '50vw', '360px': '90vw'  }">
                    <div class="flex flex-column gap-2 mb-2">
                        <label for="title">Title*</label>
                        <InputText id="title" v-model="form.title" />
                        <small id="values-help">This is the name of the category! <strong>e.g Electronics</strong></small>
                    </div>
                    <!-- <div class="flex flex-column gap-2 mb-2">
                        <label for="title">Label</label>
                        <InputText id="title" v-model="form.label" />
                        <small id="values-help">This is the text that will show above the option component! <strong>e.g Brand</strong>. If not label is provided, the title will be used instead!</small>
                    </div> -->
                    <!-- <div class="flex flex-column gap-2">
                        <label for="values">Values*</label>
                        <Chips v-model="form.propertyValues" separator="," />
                        <small id="values-help">The values should be <strong>comma separated</strong> or Press <strong>enter key</strong> to add a value after typing!</small>
                    </div> -->
                    <template #footer>
                        <Button label="Cancel" icon="pi pi-times" @click="addVisible = false" text />
                        <Button label="Add" icon="pi pi-check" @click="addCategory" autofocus />
                    </template>
                </Dialog>
                <Dialog v-model:visible="updateVisible" modal header="Update category" :style="{ width: '30vw' }" :breakpoints="{ '960px': '50vw', '641px': '50vw', '360px': '90vw'  }">
                    <div class="flex flex-column gap-2 mb-2">
                        <label for="title">Title*</label>
                        <InputText id="title" v-model="form.title" />
                        <small id="values-help">This is the name of the category! <strong>e.g Electronics</strong></small>
                    </div>
                    <!-- <div class="flex flex-column gap-2 mb-2">
                        <label for="title">Label</label>
                        <InputText id="title" v-model="form.label" />
                        <small id="values-help">This is the text that will show above the option component! <strong>e.g Brand</strong>. If not label is provided, the title will be used instead!</small>
                    </div>
                    <div class="flex flex-column gap-2">
                        <label for="values">Values*</label>
                        <Chips v-model="form.propertyValues" separator=","  />
                        <small id="values-help">The values should be comma separated or press enter key to add a value after typing!</small>
                    </div> -->
                    <template #footer>
                        <Button label="Cancel" icon="pi pi-times" @click="updateVisible = false" text />
                        <Button label="Update" icon="pi pi-check" @click="updateCategory(this)" autofocus />
                    </template>
                </Dialog>
            </div>
        </div>
    </div>
</template>

<style scoped lang="scss">
@import '@/assets/demo/styles/badges.scss';
</style>
