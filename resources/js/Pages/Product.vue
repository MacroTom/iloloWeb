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
import Bottomnavigationbar from '../Components/Bottomnavigationbar.vue';
import { Carousel, Slide, Pagination, Navigation } from 'vue3-carousel';
import 'vue3-carousel/dist/carousel.css';
import currency from 'currency.js';
import moment from 'moment';
export default{
    props: {
        advert: Object,
        user: Object
    },
    components:{
        Head,
        Link,
        Heading,
        Timeliner,
        OptionPicker,
        FlatButton,
        draggable,
        SnackBar,
        Navbar,
        Preloader,
        Carousel, Slide, Pagination, Navigation,
        Bottomnavigationbar
    },
    data(){
        return{
            store,
            currentSlide: 0,
            showContact: false,
            hasLabel: false,
            posted_at: null,
            joined_at: null,
            price: null
        }
    },
    watch: {
    },
    methods:{
        capitalise(str){
            return str.charAt(0).toUpperCase() + str.slice(1);
        },
        censorText(link="") {
            // Censor links (URLs) with or without "http://" and "https://"
            const linkRegex = /(\bhttps?:\/\/[^\s]+|\bwww\.[^\s]+\.\S+)/gi;
            link = link.replace(linkRegex, '[LINK]');

            return link;
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
        this.posted_at = moment(this.advert?.created_at).fromNow();
        this.joined_at = moment(this.user?.created_at).fromNow();
        this.price = currency(this.advert?.price, {separator: ',', symbol: '₦', precision: 0}).format();
        // console.log(this.advert, this.user);
    },
}
</script>

<style>
.carousel__icon{
    @apply text-[#1895B0]
}
.carousel__pagination{
    @apply absolute bottom-2 w-full
}
.carousel__track, .carousel__viewport {
    height: 100%;
}
</style>

<template>
    <Head>
        <title>{{ advert?.title }}</title>
    </Head>
    <Navbar/>
    <section class="w-full h-full max-h-full overflow-y-auto relative pt-[60px] min-h-full">
        <Preloader/>
        <SnackBar/>
        <div class="w-full min-h-[calc(100vh-60px)] flex flex-col gap-4 lg:flex-row lg:px-8 lg:pt-8 xl:px-28">
            <main class="w-full h-fit flex-1 lg:w-8/12 bg-white p-4 lg:p-4">
                <div class="w-full lg:h-[400px] overflow-hidden mb-2 relative rounded-lg">
                    <Carousel class="w-full h-full overflow-hidden relative" v-model="currentSlide" :itemsToShow="1" wrapAround>
                        <slide v-for="(image,index) in advert?.images" :key="index">
                            <img class="object-contain w-full h-full rounded-lg" :src="image.source" alt="image"/>
                        </slide>
                        <template #addons>
                            <navigation />
                            <pagination />
                        </template>
                    </Carousel>
                    <span v-if="hasLabel" class="min-w-[70px] absolute text-center text-sm font-Inter bg-[#1895B0]/70 left-0 top-0 text-white px-3 py-1 rounded-tl-lg">VIP</span>
                </div>
                <div class="max-w-full py-2 flex gap-2 overflow-x-auto scrollbar-hide mb-4">
                    <div class="w-[100px] h-[100px] lg:w-[150px] lg:h-[150px] flex-shrink-0" v-for="(image,index) in advert?.images" :key="index">
                        <img @click="currentSlide = index" class="w-full h-full object-cover object-center rounded-lg cursor-pointer" :src="image.source" alt="image">
                    </div>
                </div>
                <div class="mb-2">
                    <h2 class="lg:text-2xl font-Inter font-semibold text-slate-700 whitespace-nowrap text-overflow text-ellipsis">{{ advert?.title }}</h2>
                </div>
                <div class="mb-2 lg:hidden">
                    <p class="font-Inter font-semibold text-[#1895B0] whitespace-nowrap text-overflow text-ellipsis">{{ price }} {{ advert?.negotiable ? '- Negotiable' : '' }}</p>
                </div>
                <div class="mb-4 gap-2 lg:gap-x-4 flex flex-wrap justify-between lg:justify-start items-center">
                    <span class="w-fit text-xs border px-2 py-1 rounded-lg text-slate-600">Promoted</span>
                    <span class="text-xs text-slate-600 hidden lg:block">
                        <i class='bx bx-time-five'></i>
                        Posted {{ posted_at }}
                    </span>
                    <span class="text-xs text-slate-600 flex items-center flex-1">
                        <i class='bx bx-map text-lg mr-1'></i>
                        {{ advert?.state }}, {{ advert?.lga }}
                    </span>
                    <span class="text-xs text-slate-600 flex items-center">
                        <i class='bx bx-show text-lg mr-1'></i>
                        {{ !advert?.views ? '0' :  advert?.views }}
                    </span>
                </div>
                <div class="border-b my-6"></div>
                <div class="mb-4 grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                    <div v-for="(property, key) in advert?.properties" :key="key">
                        <p class="font-Inter text-slate-700 text-sm lg:text-lg font-medium capitalize">{{ property }}</p>
                        <small class="text-[10px] text-slate-400 font-Inter uppercase">{{ key }}</small>
                    </div>
                </div>
                <div class="border-b my-6"></div>
                <div class="mb-4 flex items-center gap-2 lg:hidden">
                    <div class="w-12 h-12">
                        <img class="object-cover w-full h-full rounded-lg" :src="user?.avatar" alt="avatar">
                    </div>
                    <div>
                        <p class="text-sm text-slate-700 font-Inter font-medium">{{ user?.firstname }} {{ user?.lastname }}</p>
                        <small class="text-xs text-slate-500 font-Inter px-2 py-1 border rounded-lg">Joined {{ joined_at }}</small>
                    </div>
                </div>
                <div class="mb-4 flex gap-2 lg:hidden">
                    <button v-if="!showContact" @click="showContact = true" class="w-1/2 button stroke"><i class='bx bx-phone-call text-lg'></i> Show contact</button>
                    <a :href="`tel:${user?.phone}`" v-else class="w-1/2 button stroke"><span class="text-[#1895B0]">{{ user?.phone }}</span></a>
                    <button class="w-1/2 button primary"><i class='bx bx-message-dots text-lg'></i> Chat now</button>
                </div>
                <div class="border-b my-3 lg:hidden"></div>
                <div class="mb-4 flex gap-2 lg:hidden">
                    <button class="button w-1/2 font-Inter"><span class="text-blue-400">Is unavailable ?</span></button>
                    <button class="button w-1/2 font-Inter"><i class='bx bx-flag text-lg text-red-500'></i> <span class="text-red-500">Report abuse</span></button>
                </div>
                <div class="mb-4 min-h-[200px] max-h-[400px] bg-slate-50 p-2">
                    <span class="text-slate-700 text-sm font-Inter">{{ censorText(advert?.description) }}</span>
                </div>
                <div v-if="user?.facbook_link" class="lg:hidden mb-4 grid grid-cols-2 gap-3">
                    <a :href="user?.facebook_link ?  user?.facebook_link: '#'" class="flex items-center gap-2 py-2 bg-slate-50 shadow px-2 justify-center rounded-lg">
                        <i class='bx bxl-facebook-circle text-xl text-slate-600'></i>
                        <span class="text-sm">Facebook</span>
                    </a>
                    <a :href="user?.instagram_link ?  user?.instagram_link: '#'" class="flex items-center gap-2 py-2 bg-slate-50 shadow px-2 justify-center rounded-lg">
                        <i class='bx bxl-instagram-alt text-xl text-slate-600'></i>
                        <span class="text-sm">Instagram</span>
                    </a>
                    <a :href="user?.twitter_link ?  user?.twitter_link: '#'" class="flex items-center gap-2 py-2 bg-slate-50 shadow px-2 justify-center rounded-lg">
                        <i class='bx bxl-twitter text-xl text-slate-600'></i>
                        <span class="text-sm">Twitter</span>
                    </a>
                    <a :href="user?.website_link ?  user?.website_link: '#'" class="flex items-center gap-2 py-2 bg-slate-50 shadow px-2 justify-center rounded-lg">
                        <i class='bx bx-globe text-xl text-slate-600'></i>
                        <span class="text-sm">Website</span>
                    </a>
                </div>
            </main>
            <aside class="w-full h-fit hidden lg:block lg:w-4/12 p-4 lg:p-8 bg-white">
                <div class="mb-4">
                    <p class="font-Inter text-2xl font-semibold text-[#1895B0] whitespace-nowrap text-overflow text-ellipsis">{{ price }} {{ advert?.negotiable ? '- Negotiable' : '' }}</p>
                </div>
                <div class="border-b my-6"></div>
                <div class="mb-4 flex items-center gap-2">
                    <div class="w-12 h-12">
                        <img class="object-cover w-full h-full rounded-lg" :src="user?.avatar" alt="avatar">
                    </div>
                    <div class="flex flex-col gap-1">
                        <p class="text-sm text-slate-700 font-Inter font-medium">{{ user?.firstname }} {{ user?.lastname }}</p>
                        <small class="text-xs text-slate-500 font-Inter px-2 py-1 border rounded-lg">Joined {{ joined_at }}</small>
                    </div>
                </div>
                <div class="mb-4 flex gap-2">
                    <button v-if="!showContact" @click="showContact = true" class="w-1/2 button stroke"><i class='bx bx-phone-call text-lg'></i> Show contact</button>
                    <a :href="`tel:${user?.phone}`" v-else class="w-1/2 button stroke"><span class="text-[#1895B0]">{{ user?.phone }}</span></a>
                    <button class="w-1/2 button primary"><i class='bx bx-message-dots text-lg'></i> Chat now</button>
                </div>
                <div v-if="user?.facbook_link" class="mb-4 grid grid-cols-2 gap-3">
                    <a :href="user?.facebook_link ?  user?.facebook_link: '#'" class="flex items-center gap-2 py-2 bg-slate-50 shadow px-2 justify-center rounded-lg">
                        <i class='bx bxl-facebook-circle text-xl text-slate-600'></i>
                        <span class="text-sm">Facebook</span>
                    </a>
                    <a :href="user?.instagram_link ?  user?.instagram_link: '#'" class="flex items-center gap-2 py-2 bg-slate-50 shadow px-2 justify-center rounded-lg">
                        <i class='bx bxl-instagram-alt text-xl text-slate-600'></i>
                        <span class="text-sm">Instagram</span>
                    </a>
                    <a :href="user?.twitter_link ?  user?.twitter_link: '#'" class="flex items-center gap-2 py-2 bg-slate-50 shadow px-2 justify-center rounded-lg">
                        <i class='bx bxl-twitter text-xl text-slate-600'></i>
                        <span class="text-sm">Twitter</span>
                    </a>
                    <a :href="user?.website_link ?  user?.website_link: '#'" class="flex items-center gap-2 py-2 bg-slate-50 shadow px-2 justify-center rounded-lg">
                        <i class='bx bx-globe text-xl text-slate-600'></i>
                        <span class="text-sm">Website</span>
                    </a>
                </div>
                <div class="border-b my-6"></div>
                <div class="mb-4 flex gap-2">
                    <button class="button w-1/2 font-Inter"><span class="text-blue-400">Is unavailable ?</span></button>
                    <button class="button w-1/2 font-Inter"><i class='bx bx-flag text-lg text-red-500'></i> <span class="text-red-500">Report abuse</span></button>
                </div>
            </aside>
        </div>
    </section>
    <Bottomnavigationbar/>
</template>
