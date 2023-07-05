<script>
import { Head, router, Link } from '@inertiajs/vue3';
import draggable from 'vuedraggable';
import { store } from '../store.js';
import Heading from '../Components/Heading.vue';
import Timeliner from '../Components/Timeliner.vue';
import OptionPicker from '../Components/OptionPicker.vue';
import FlatButton from '../Components/FlatButton.vue';
import SnackBar from '../Components/SnackBar.vue';
import Navbar from '../Components/Navbar.vue';
import Preloader from '../Components/Preloader.vue';
import InternetChecker from '../Components/InternetChecker.vue';
import axios from 'axios';
export default{
    props: {
        properties: Object,
        categories: Object,
        states: Object,
        errors: Object,
        advert: Object
    },
    components:{
        Head,
        Heading,
        Timeliner,
        OptionPicker,
        FlatButton,
        draggable,
        SnackBar,
        Navbar,
        Preloader,
        Link,
        InternetChecker
    },
    data(){
        return{
            store,
            currentStep: 1,
            form: {
                title: '',
                category: '',
                subcategory: '',
                state: '',
                lga: '',
                price: '',
                negotiable: false,
                description: '',
                photos: [],
                properties: {}
            },
            processing: false,
            placeholder: {
                category: '',
                state: '',
                properties: {}
            },
            preview: [
                '/images/product.png'
            ],
            loading: {
                continue: false,
                save: false,
                back: false,
                cancel: false
            },
            timelines: [
                { label: '01', description: 'Basic info' },
                { label: '02', description: 'Advert properties' },
                { label: '03', description: 'Gallery' },
                { description: 'Done' },
            ],
            internet: navigator.onLine,
            currentTimeline: 0,
            propertyList: [],
            formErrors: [],
            fields: {}
        }
    },
    watch: {
        // whenever category changes, this function will run
        'form.category'(newvalue, oldvalue) {
            if(oldvalue !== ''){
                this.form.properties = {}
                this.placeholder.properties = {}
            }
            this.setProps();
        },
        internet(newvalue, oldvalue){
            if(newvalue){
                this.store.snackbar.add({
                    message: "Connected to internet!",
                    severity: "success"
                });
                if(!this.processing){
                    this.loading = {
                        continue: false,
                        save: false,
                    }
                }
            }
            else{
                this.store.snackbar.add({
                    message: "No internet connection!",
                    severity: "warning"
                });
                this.loading = {
                    continue: true,
                    save: true,
                }
            }
        }
    },
    methods:{
        getLastPathWithoutExtension(url) {
            // Remove query parameters and hash fragment
            const cleanUrl = url.split(/[?#]/)[0];

            // Get the last path segment
            const segments = cleanUrl.split('/');
            const lastSegment = segments[segments.length - 1];

            // Remove file extension
            const fileName = lastSegment.split('.')[0];

            return fileName;
        },
        onFileChange(e) {
            const files = e.target.files;
            for(const file of files){
                if((file.type === 'image/png' || file.type === 'image/jpeg') && file.size < 5242880 && this.form.photos.length <= 12){
                    this.uploadPhoto(file,e.target);
                }
            }
        },
        deleteFile(pos){
            let photo = this.form.photos[pos];
            this.form.photos[pos] = '';

            this.store.snackbar.add({
                message: "Removing photo!",
                severity: "info"
            });
            const url = "/deletephoto";
            const formData = {
                public_id: this.getLastPathWithoutExtension(photo)
            };
            router.post(url, formData,
            {
                onSuccess: (res) => {
                    (pos < this.form.photos.length && pos > -1) && this.form.photos.splice(pos,1);
                    this.store.snackbar.add({
                        message: "Photo Deleted!",
                        severity: "warning"
                    });
                },
                onError: (err) => {
                    this.form.photos[pos] = photo;
                    this.store.snackbar.add({
                        message: "Could not delete photo!",
                        severity: "warning"
                    });
                },
                preserveScroll: true
            },
            );
        },
        back(){
            if(this.currentTimeline >= this.timelines.length){
                window.history.back();
                return;
            }
            var goBack = confirm("Are you sure ? Progress will be lost!");
            goBack && window.history.back();
        },
        setTimeline(timeline, newtimeline={}){
            for (const key in newtimeline) {
                this.timelines[currentTimeline][key] = newtimeline[key];
            }
            this.currentTimeline = timeline;
        },
        nextTimeline(event, num=1){
            this.currentTimeline += num;
        },
        prevTimeline(){
            this.currentTimeline--;
        },
        getPosition(arr, item){
            return item && arr.indexOf(item);
        },
        getCategory(){
            return this.form.category;
        },
        setProps(){
            this.propertyList = this.properties.filter((property)=>property.categories.map((category)=>category.id).includes(this.form.category));
        },
        getStates(){
            return this.states.map(function(state){
                return {
                    state: state.state,
                    lgas: state.lgas.map(function(lga){return{lga: lga}})
                }
            });
        },
        createId(){
            let id = '';
            const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            for (let i = 0; i < 5; i++) {
                id += chars.charAt(Math.floor(Math.random() * chars.length));
            }
            return id;
        },
        createURL(file){
            return URL.createObjectURL(file);
        },
        onDrop(event){
            const files = event.dataTransfer.files;
            for(const file of files){
                if((file.type === 'image/png' || file.type === 'image/jpeg') && file.size < 5242880 && this.form.photos.length <= 12){
                    this.uploadPhoto(file);
                }
            }
            event.target.nodeName === 'DIV' && event.target.classList.remove('dragover');
        },
        onDragEnter(event){
            event.target.nodeName === 'DIV' && event.target.classList.add('dragover');
        },
        onDragLeave(event){
            event.target.nodeName === 'DIV' && event.target.classList.remove('dragover');
        },
        clearForm(){
            this.form = {
                title: '',
                category: '',
                subcategory: '',
                state: '',
                lga: '',
                price: '',
                negotiable: false,
                description: '',
                photos: [],
                properties: {}
            }
            this.loading = {
                continue: false,
                save: false,
                back: false,
                cancel: false
            }
            this.placeholder = {
                category: '',
                state: '',
                properties: {}
            }
        },
        checkForRequiredFields(timeline, innerParent=null){
            this.fields = {
                basicInfo: [
                    'title', 'category', 'state', 'price', 'description'
                ],
                properties: this.propertyList.map((property)=>property.label),
                gallery: ['photos']
            }
            for (const field of this.fields[timeline]) {
                if(innerParent){
                    if(!this.form[innerParent][field]){
                        !this.formErrors.includes(field) && this.formErrors.push(field);
                    }
                    else{
                        this.formErrors.includes(field) && this.formErrors.splice(this.formErrors.indexOf(field),1);
                    }
                }
                else{
                    if(!this.form[field]){
                        !this.formErrors.includes(field) && this.formErrors.push(field);
                    }
                    else{
                        this.formErrors.includes(field) && this.formErrors.splice(this.formErrors.indexOf(field),1);
                    }
                }
            }
            return this.formErrors.length > 0 ? false : true;
        },
        authField(field, innerParent=null){
            if(innerParent){
                if(this.form[innerParent][field] || this.form[innerParent]){
                    this.formErrors.includes(field) && this.formErrors.splice(this.formErrors.indexOf(field),1);
                }
            }
            else{
                if(this.form[field]){
                    this.formErrors.includes(field) && this.formErrors.splice(this.formErrors.indexOf(field),1);
                }
            }
        },
        basicInfo(){
            this.loading.continue = true;
            if (this.checkForRequiredFields('basicInfo')) {
                // this.store.snackbar.add({
                //     message: "Added successfully!",
                //     severity: "success"
                // });
                this.loading.continue = false;
                this.nextTimeline();
            }
            else{
                this.store.snackbar.add({
                    message: "Please fill in all details!",
                    severity: "warning"
                });
                this.loading.continue = false;
            }
        },
        advertProperties(){
            this.loading.continue = true;
            if (this.checkForRequiredFields('properties','properties')) {
                this.loading.continue = false;
                this.nextTimeline();
            }
            else{
                this.store.snackbar.add({
                    message: "Please fill in all properties!",
                    severity: "warning"
                });
                this.loading.continue = false;
            }
        },
        submitForm(boost,edit){
            let url = edit ? `?edit=${this.$page.props?.advert?.id}` : '';
            router.post(`/postad${url}`, this.form,
            {
                onSuccess: (res) => {
                    this.clearForm();
                    if(boost){
                        this.store.snackbar.add({
                            message: "Redirecting to Plans page!",
                            severity: "success"
                        });
                        setTimeout(() => {
                            window.location = "/subscriptions";
                        },2000);
                    }
                    this.processing = false;
                    this.currentTimeline += 2;
                    this.loading.continue = false;
                },
                onError: (err) => {
                    this.store.snackbar.add({
                        message: err.message,
                        severity: "warning"
                    });
                    this.processing = false;
                    this.loading.continue = false;
                },
            },
            );
        },
        uploadPhoto(file,input){
            this.store.snackbar.add({
                message: "Uploading photos!",
                severity: "info"
            });
            const url = "https://api.cloudinary.com/v1_1/daye98q4y/image/upload";
            const formData = new FormData();
            formData.append("file", file);
            formData.append("upload_preset", "ybqvdxtk");
            axios.post(url, formData)
            .then((res)=>{
                this.form.photos.push(res.data.secure_url);
            })
            .catch((err)=>{
                this.store.snackbar.add({
                    message: "Could not upload photos!",
                    severity: "warning"
                });
            });
        },
        gallery(boost=false,edit=false){
            this.loading.continue = true;
            this.processing = true;
            if (this.checkForRequiredFields('gallery')) {
                if(this.form.photos.length < 3){
                    this.loading.continue = false;
                    this.processing = false;
                    this.store.snackbar.add({
                        message: "Please upload up to three photos!",
                        severity: "warning"
                    });
                }
                else{
                    // Submit the form
                    this.submitForm(boost,edit);
                }
            }
            else{
                this.store.snackbar.add({
                    message: "Please images for your advert!",
                    severity: "info"
                });
                this.processing = false;
                this.loading.continue = false;
            }
        },
        updateFields(){
            this.form = {
                title: this.advert.title,
                category: this.advert.category.id,
                subcategory: this.advert.subcategory.id,
                state: this.advert.state,
                lga: this.advert.lga,
                price: this.advert.price,
                negotiable: this.advert.negotiable,
                description: this.advert.description,
                photos: this.advert.photos,
                properties: this.advert.properties
            }
            this.placeholder = {
                category: this.advert.subcategory.title,
                state: this.advert.state,
                properties: this.advert.properties
            }
        },
        status(value){
            console.log(value);
        }
    },
    mounted(){
        const body = document.body;
        var classval;
        for (let index = 0; index < body.classList.length; index++) {
            classval = body.classList[index];
            if(classval.includes('bg-')){
                body.classList.remove(classval);
            }
        }
        body.classList.add('bg-slate-100');
        this.$page.props.advert && this.updateFields();
        // console.log(this.advert);
    },
}
</script>

<template>
    <Head>
        <title>Post ad</title>
    </Head>
    <Preloader/>
    <SnackBar/>
    <Navbar/>
    <InternetChecker v-model:status="internet"/>
    <section class="w-full max-h-[calc(100vh-60px)] overflow-y-auto relative top-[60px] min-h-[calc(100vh-60px)]">
        <nav class="lg:hidden w-full h-[60px] flex items-center justify-between px-2 bg-white fixed left-0 top-0 shadow z-50">
            <button @click="back">
                <i class='bx bx-chevron-left text-4xl text-black/60 pointer-events-none'></i>
            </button>
            <h4 class="font-semibold text-lg text-black/80">Post ad</h4>
            <button @click="clearForm"
                class="text-red-500 pr-2 text-sm">
                Clear
            </button>
        </nav>
        <div class="w-full min-h-[calc(100vh-60px)] flex flex-col lg:flex-row">
            <aside class="w-full lg:w-4/12 xl:w-4/12 flex flex-col items-center gap-y-3 justify-center lg:items-end lg:justify-start lg:gap-y-10 p-4 lg:py-8 lg:pl-8 lg:pr-14 border-b lg:border-b-0 lg:border-r">
                <Timeliner
                    :timelines="timelines"
                    :current="currentTimeline"/>
                <FlatButton v-if="currentTimeline < timelines.length"
                    class="w-full md:w-fit bg-white"
                    label="Save as a draft"
                    stroke
                    :loading="loading.save"
                />
                <!-- <small class="text-xs">formErrors - {{ formErrors }}</small><br/><br/>
                <small class="text-xs">properties - {{ form.properties }}</small> -->
            </aside>
            <main class="w-full flex-1 lg:w-4/12 xl:w-3/12 bg-white p-6 lg:p-8">
                <div v-if="currentTimeline === 0">
                    <h1 class="font-semibold text-2xl text-slate-800 mb-2">Describe your product</h1>
                    <p class="text-xs text-slate-600 mb-8">Help Buyers to find your advert by providing a proper description.</p>

                    <h6 class="text-slate-700 text-sm font-semibold mb-4">Advert details</h6>
                    <div class="advert-control" :class="formErrors.includes('title') ? 'hasError' : ''">
                        <label>Title*</label>
                        <input type="text" @input="authField('title')" v-model="form.title"/>
                    </div>
                    <OptionPicker
                        :class="formErrors.includes('category') ? 'hasError' : ''"
                        label="Category"
                        required
                        :options="categories"
                        :levels="[
                            { data: 'title', output: 'id' },
                            { src: 'subcategories', data: 'title', output: 'id' }
                        ]"
                        v-model:value="placeholder.category"
                        v-model:parent="form.category"
                        v-model:child="form.subcategory"
                        @change="authField('category')"
                    />
                    <OptionPicker
                        :class="formErrors.includes('state') ? 'hasError' : ''"
                        label="Location"
                        required
                        :options="getStates()"
                        :levels="[
                            { data: 'state', output: 'state' },
                            { src: 'lgas', data: 'lga', output: 'lga' }
                        ]"
                        v-model:value="placeholder.state"
                        v-model:parent="form.state"
                        v-model:child="form.lga"
                        @change="authField('state')"
                    />

                    <div class="advert-control w-full" :class="formErrors.includes('price') ? 'hasError' : ''">
                        <label>Price*</label>
                        <div class="relative">
                            <div class="absolute left-0">
                                <span class="text-slate-600 font-mono">₦</span>
                            </div>
                            <input class="pl-4" @input="authField('price')" type="number" v-model="form.price"/>
                        </div>
                    </div>
                    <label class="flex items-center text-xs text-slate-600 gap-2 select-none mb-6" for="negotiable">
                        <input type="checkbox" id="negotiable" v-model="form.negotiable"/>
                        <span>Is the price negotiable ?</span>
                    </label>

                    <div class="advert-control mb-2" :class="formErrors.includes('description') ? 'hasError' : ''">
                        <label>Description*</label>
                        <textarea v-model="form.description" @input="authField('description')"></textarea>
                    </div>

                    <div class="flex gap-2 mb-2">
                        <FlatButton
                            label="Cancel"
                            stroke
                            :loading="loading.cancel"
                        />
                        <FlatButton @click="basicInfo"
                            class="flex-1"
                            label="Continue"
                            primary
                            :loading="loading.continue"
                        />
                    </div>
                </div>


                <div v-else-if="currentTimeline === 1">
                    <h1 class="font-semibold text-2xl text-slate-800 mb-4">Properties</h1>
                    <p class="text-xs text-slate-600 mb-8">Tell us about the properties or specific features your product have.</p>

                    <!-- Dynamic form components -->
                    <OptionPicker v-for="(property, key) in propertyList"
                        :class="formErrors.includes(property.label) ? 'hasError' : ''"
                        :key="key"
                        :label="property.label"
                        required
                        :options="property.values.map((value)=>({title: value}))"
                        :levels="[
                            { data: 'title', output: 'title' },
                        ]"
                        v-model:value="placeholder.properties[property.label]"
                        v-model:parent="form.properties[property.label]"
                        @change="authField(property.label, 'properties')"
                    />

                    <div class="flex gap-2 mb-2">
                        <FlatButton @click="prevTimeline"
                            label="Back"
                            stroke
                            :loading="loading.back"
                        />
                        <FlatButton @click="advertProperties"
                            class="flex-1"
                            label="Continue"
                            primary
                            :loading="loading.continue"
                        />
                    </div>
                </div>


                <div v-else-if="currentTimeline === 2">
                    <h1 class="font-semibold text-2xl text-slate-800 mb-4">Advert photos</h1>
                    <p class="text-xs text-slate-600">Upload some clear photos of your product. Good pictures can increase Buyers interest! First added photo will be your <strong>main photo</strong>.</p>

                    <section class="w-full my-4 lg:my-6 flex flex-col justify-start items-start">
                        <div class="w-full mb-4 lg:mb-6">
                            <div
                                class="min-h-[150px] flex flex-col justify-center gap-2 items-center border-2 border-dashed"
                                @drop.prevent="onDrop($event)"
                                @dragover.prevent
                                @dragenter="onDragEnter($event)"
                                @dragleave="onDragLeave($event)"
                                >
                                <p><i class='bx bx-upload text-2xl text-slate-500'></i></p>
                                <p
                                    class="text-xs font-medium">
                                    <span class="select-none text-slate-700">Drag & Drop or <label for="file" class="cursor-pointer text-[#1895B0]">Choose photos</label> to upload.</span>
                                    <input class="hidden" id="file" type="file" @change="onFileChange($event)" multiple accept="image/png, image/jpeg"/>
                                </p>
                                <p class="text-xs text-slate-400"><small>.jpg, .png, size limit per photo: 5MB, photos limit: 12</small></p>
                            </div>
                        </div>
                        <draggable class="w-full grid grid-cols-3 lg:grid-cols-2 gap-2 lg:gap-3" tag="div" v-model="form.photos" item-key="name">
                            <template #item="{ element: image, index: key }">
                                <div v-show="image"
                                    :style="`background-image: url(${image});`"
                                    class="h-[100px] lg:h-[130px] relative rounded-lg bg-no-repeat bg-cover bg-center flex-shrink-0 group lg:cursor-grab"
                                    >
                                    <div @click="deleteFile(key)"
                                        class="w-6 h-6 flex lg:hidden items-center justify-center bg-black/50 text-white cursor-pointer rounded-full absolute right-2 top-2 lg:group-hover:flex"
                                        >
                                        <i class='bx bx-trash text-lg pointer-events-none'></i>
                                    </div>
                                    <div v-if="key === 0"
                                        class="p-1 text-[10px] lg:text-xs bg-[#1895B0] text-white absolute bottom-0 left-0 rounded-tr-lg rounded-bl-lg"
                                        >
                                        Main photo
                                    </div>
                                    <div class="w-5 h-5 p-1 flex justify-center items-center text-[10px] lg:text-xs bg-black/50 text-white absolute bottom-1 right-1 rounded-full"
                                        >
                                        {{ key + 1 }}
                                    </div>
                                </div>
                            </template>
                        </draggable>
                    </section>

                    <div class="flex gap-2 mb-2">
                        <FlatButton @click="prevTimeline"
                            label="Back"
                            :loading="loading.back"
                        />
                        <FlatButton v-if="!$page.props?.advert" @click="gallery(false)"
                            class="flex-1"
                            label="Post Ad"
                            primary
                            :loading="loading.continue"
                        />
                        <FlatButton v-else @click="gallery(false,true)"
                            class="flex-1"
                            label="Update Ad"
                            primary
                            :loading="loading.continue"
                        />
                    </div>

                    <div class="my-8 border-b"></div>

                    <p class="text-xs text-slate-600 mb-6"><strong>OPTIONAL:</strong> Boost your Advert to allow customers find it faster! We offer affordable plans, each comes with its own perks.</p>

                    <div class="flex gap-2 mb-2">
                        <FlatButton v-if="!$page.props?.advert" @click="gallery(true)"
                            class="border-2 flex-1 text-[#1895B0]"
                            label="Boost Advert"
                            :loading="loading.continue"
                        />
                        <FlatButton v-else @click="gallery(true,true)"
                            class="border-2 flex-1 text-[#1895B0]"
                            label="Boost Advert"
                            :loading="loading.continue"
                        />
                    </div>
                </div>


                <div v-else>
                    <h1 class="font-semibold text-2xl text-slate-800 mb-4">The Advert has been created!</h1>
                    <p class="text-sm text-slate-600 leading-6 mb-4">Your Advert has been created, but it's not available to the Buyers yet. We have to make a quick verification of provided information before it's published. It could take a while.</p>
                    <Link v-if="!$page.props?.advert" href="/profile/ads/review" class="button primary w-full md:w-fit">Go to advert page</Link>
                    <Link v-else href="/profile/ads" class="button primary w-full md:w-fit">Go to advert page</Link>
                </div>
            </main>
            <section class="hidden lg:block w-4/12 xl:w-5/12 bg-white">

            </section>
        </div>
    </section>
</template>
