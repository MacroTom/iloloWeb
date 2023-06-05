<script>
import { Head } from '@inertiajs/vue3';
import Heading from '../Components/Heading.vue';
import Timeliner from '../Components/Timeliner.vue';
import OptionPicker from '../Components/OptionPicker.vue';
import FlatButton from '../Components/FlatButton.vue';
export default{
    props: {
        properties: Object,
        categories: Object,
        states: Object,
    },
    components:{
        Head,
        Heading,
        Timeliner,
        OptionPicker,
        FlatButton
    },
    data(){
        return{
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
            preview: [],
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
            currentTimeline: 0,
        }
    },
    methods:{
        onFileChange(e) {
            const file = e.target.files[0];
            if((file.type === 'image/png' || file.type === 'image/jpeg') && file.size < 5242880){
                this.form.photos.push(file);
                this.preview.push(URL.createObjectURL(file));
            }
        },
        deleteFile(pos){
            (pos < this.form.photos.length && pos > -1) && this.form.photos.splice(pos,1);
            (pos < this.preview.length && pos > -1) && this.preview.splice(pos,1);
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
    },
}
</script>

<template>
    <Head>
        <title>Post ad</title>
    </Head>
    <div class="hidden lg:block">
        <Heading/>
    </div>
    <section class="w-full max-h-[calc(100vh-60px)] overflow-y-auto relative top-[60px] min-h-[calc(100vh-60px)]">
        <nav class="lg:hidden w-full h-[60px] flex items-center justify-between px-2 bg-white fixed left-0 top-0 shadow z-50">
            <button @click="back">
                <i class='bx bx-chevron-left text-4xl text-black/60 pointer-events-none'></i>
            </button>
            <h4 class="font-semibold text-lg text-black/80">Post ad</h4>
            <button class="text-red-500 pr-2 text-sm">
                Clear
            </button>
        </nav>
        <div class="w-full min-h-[calc(100vh-60px)] flex flex-col lg:flex-row">
            <aside class="w-full lg:w-4/12 xl:w-3/12 flex lg:flex-col justify-center lg:items-end lg:justify-start lg:gap-y-10 py-4 lg:py-8 lg:pl-8 lg:pr-14">
                <Timeliner
                    :timelines="timelines"
                    :current="currentTimeline"/>
                <FlatButton v-if="currentTimeline < timelines.length"
                    class="hidden lg:block bg-white"
                    label="Save as a draft"
                    stroke
                    :loading="loading.save"
                />
            </aside>
            <main class="w-full flex-1 lg:w-4/12 xl:w-5/12 bg-white p-6 lg:p-8">
                <div v-if="currentTimeline === 0">
                    <h1 class="font-semibold text-2xl text-slate-800 mb-2">Describe your product</h1>
                    <p class="text-xs text-slate-600 mb-8">Help Buyers to find your advert by providing a proper description.</p>

                    <h6 class="text-slate-700 text-sm font-semibold mb-4">Advert details</h6>
                    <div class="advert-control">
                        <label>Title*</label>
                        <input type="text" v-model="form.title"/>
                    </div>
                    <OptionPicker
                        label="Category"
                        required
                        :options="{ first: categories }"
                        v-model:first="form.category"
                        v-model:second="form.subcategory"
                    />
                    <OptionPicker
                        label="Location"
                        required
                        :options="{ first: states.map((state)=>{
                            return state.state
                        }), second: states[getPosition(states.map((state)=>state.state), form.state)]?.lgas ? states[getPosition(states.map((state)=>state.state), form.state)]?.lgas : [] }"
                        v-model:first="form.state"
                        v-model:second="form.lga"
                    />

                    <div class="advert-control w-full">
                        <label>Price*</label>
                        <div class="relative">
                            <div class="absolute left-0">
                                <span class="text-slate-600 font-mono">₦</span>
                            </div>
                            <input class="pl-4" type="number" v-model="form.price"/>
                        </div>
                    </div>
                    <label class="flex items-center text-xs text-slate-600 gap-2 select-none" for="negotiable">
                        <input type="checkbox" id="negotiable" v-model="form.negotiable"/>
                        <span>Is the price negotiable ?</span>
                    </label>

                    <h6 class="text-slate-700 text-sm font-semibold mt-6 mb-4">Describe your product</h6>
                    <div class="advert-control mb-2">
                        <label>Description*</label>
                        <textarea v-model="form.description"></textarea>
                    </div>

                    <div class="flex gap-2 mb-2">
                        <FlatButton
                            label="Cancel"
                            stroke
                            :loading="loading.cancel"
                        />
                        <FlatButton @click="nextTimeline"
                            class="flex-1"
                            label="Continue"
                            primary
                            :loading="loading.continue"
                        />
                    </div>
                    <FlatButton
                        class="w-full lg:hidden"
                        label="Save as a draft"
                        stroke
                        :loading="loading.save"
                    />
                </div>


                <div v-else-if="currentTimeline === 1">
                    <h1 class="font-semibold text-2xl text-slate-800 mb-4">Properties</h1>
                    <p class="text-xs text-slate-600 mb-8">Tell us about the properties or specific features your product have.</p>

                    <!-- Dynamic form components -->
                    <OptionPicker v-for="(property, key) in properties" :key="key"
                        :label="property.label"
                        required
                        :options="{ first: property.values }"
                        v-model:first="form.properties[property.label]"
                    />

                    <div class="flex gap-2 mb-2">
                        <FlatButton @click="prevTimeline"
                            label="Back"
                            stroke
                            :loading="loading.back"
                        />
                        <FlatButton @click="nextTimeline"
                            class="flex-1"
                            label="Continue"
                            primary
                            :loading="loading.continue"
                        />
                    </div>
                    <FlatButton
                        class="w-full lg:hidden"
                        label="Save as a draft"
                        stroke
                        :loading="loading.save"
                    />
                </div>


                <div v-else-if="currentTimeline === 2">
                    <h1 class="font-semibold text-2xl text-slate-800 mb-4">Advert photos</h1>
                    <p class="text-sm text-slate-600 mb-4">Upload some clear photos of your product. Good pictures can increase Buyers interest! <br/><br/>First added photo will be your main photo.</p>

                    <div class="flex gap-2 mb-2">
                        <FlatButton @click="prevTimeline"
                            label="Back"
                            stroke
                            :loading="loading.back"
                        />
                        <FlatButton @click="nextTimeline($event, 2)"
                            class="flex-1"
                            label="Continue"
                            primary
                            :loading="loading.continue"
                        />
                    </div>
                    <FlatButton
                        class="w-full lg:hidden"
                        label="Save as a draft"
                        stroke
                        :loading="loading.save"
                    />
                </div>


                <div v-else>
                    <h1 class="font-semibold text-2xl text-slate-800 mb-4">The Advert has been created!</h1>
                    <p class="text-sm text-slate-600 leading-6 mb-4">Your Advert has been created, but it's not available to the Buyers yet. We have to make a quick verification of provided information before it's published. It could take a while.</p>
                    <FlatButton @click=""
                        class="flex-1"
                        label="Go to advert page"
                        primary
                    />
                </div>
            </main>
            <section class="hidden lg:block w-4/12 xl:w-4/12 bg-white">

            </section>
        </div>
    </section>
</template>
