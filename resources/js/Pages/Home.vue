<script>
import { Head, Link } from '@inertiajs/vue3';
import Categorysidebar from '../Components/Categorysidebar.vue';
import Bottomnavigationbar from '../Components/Bottomnavigationbar.vue';
import Banner from '../Components/Banner.vue';
import Product from '../Components/Product.vue';
import Category from '../Components/Category.vue';
import Footer from '../Components/Footer.vue';
import Heading from '../Components/Heading.vue';
import { store } from '../store.js';
import FormTab from '../Components/Form.vue';
import Navbar from '../Components/Navbar.vue';
import Preloader from '../Components/Preloader.vue';
import Advert from '../Components/Advert.vue';
import HeroSection from '../Components/HeroSection.vue';
import Sliders from '../Components/Sliders.vue';
export default {
    props:{
        adverts: Array,
        special: Array,
        categories: Array,
        location: Object
    },
    components:{
        Heading,
        Head,
        Link,
        Categorysidebar,
        Bottomnavigationbar,
        Banner,
        Product,
        Category,
        Footer,
        FormTab,
        Navbar,
        Preloader,
        Advert,
        HeroSection,
        Sliders
    },
    data(){
        return {
            store
        }
    },
    mounted(){
        // console.log(this.categories);
    }
}
</script>

<template>
    <Head>
        <title>iLoLo</title>
    </Head>
    <!-- <Heading/> -->
    <Preloader/>
    <Navbar bg="bg-transparent" scroll border="border-0"/>
    <section class="w-full relative left-0 top-0">
        <HeroSection/>
        <!-- <div class="hidden lg:flex bg-[#1895B0] lg:bg-[#A2BDC3] w-full h-[60px] lg:h-[230px] border-transparent justify-center items-center">
            <img width="300" class="hidden lg:block" src="/images/person1.png" alt="person">
            <div class="flex items-center justify-between w-full h-full gap-2 px-2 lg:w-fit lg:flex-col lg:justify-center">
                <div class="flex items-center justify-center w-4/12 lg:w-full">
                    <span class="hidden text-xs font-semibold lg:block lg:text-xl">Explore ilolo in</span>
                    <button class="min-w-full lg:min-w-0 bg-[#0B0B0C]/75 hover:bg-[#0B0B0C]/90 min-h-[30px] font-semibold flex items-center mx-3 gap-1 px-2 rounded-2xl justify-center text-white">
                        <i class='text-xs pointer-events-none bx bx-map'></i>
                        <span class="text-[10px] pointer-events-none">Location</span>
                        <i class='pointer-events-none bx bx-chevron-down'></i>
                    </button>
                </div>
                <div class="w-8/12 bg-white/80 lg:min-w-[400px] min-h-[40px] flex items-center px-2 py-1 rounded-3xl">
                    <input
                        class="flex-1 w-full h-full text-xs bg-transparent outline-none lg:pl-2"
                        type="text" placeholder="Looking for..."/>
                    <i class='bx bx-search text-lg text-[#1895B0] pointer-events-none'></i>
                </div>
            </div>
            <div class="flex items-baseline">
                <img width="150" class="hidden lg:block" src="/images/person2.png" alt="person">
                <img width="100" class="hidden lg:block" src="/images/person3.png" alt="person">
            </div>
        </div> -->
        <main class="flex w-full h-full gap-3 lg:px-8 xl:px-28 bg-slate-50">
            <FormTab/>
            <!-- <Categorysidebar>
                <Category v-for="(category,index) in categories"
                :key="index"
                :category="category"
                />
            </Categorysidebar> -->
            <section class="p-3 lg:py-3 lg:px-0 relative bg-slate-50">
                <div class="w-full grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 lg:grid-rows-2 gap-4">
                    <!-- <div class="w-1/3 py-10 rounded-lg flex flex-col items-center justify-center gap-4 font-medium text-white bg-[#4074FB]/60 hover:bg-[#4074FB]/70 cursor-pointer shadow-lg">
                        <span>Want to sell</span>
                        <i class='text-5xl pointer-events-none select-none bx bx-plus'></i>
                        <span>Post advert for free</span>
                    </div>
                    <Banner class="w-2/3"/> -->
                    <Sliders/>
                    <section class="lg:col-start-3 lg:col-end-4 shadow-md rounded-lg">
                        <img class="object-cover w-full h-full rounded-lg" src="/images/banner_4.png" alt="banner_4"/>
                    </section>
                    <section class="lg:col-start-3 lg:col-end-4 lg:row-start-2 lg:row-end-3 shadow-md rounded-lg">
                        <img class="object-cover w-full h-full rounded-lg" src="/images/banner_2.png" alt="banner_2"/>
                    </section>
                </div>
                <div class="py-3 mb-3 text-xl font-semibold lg:mt-4">
                    Special offers
                </div>
                <div class="flex w-full gap-2 p-2 overflow-x-auto scrollbar-hide">
                    <Product v-for="(advert,index) in special"
                    :advert="advert"
                    :key="index"/>
                    <!-- <Product :advert="{}"/>
                    <Product :advert="{}"/>
                    <Product :advert="{}"/>
                    <Product :advert="{}"/>
                    <Product :advert="{}"/>
                    <Product :advert="{}"/> -->
                </div>
                <div class="py-3 mb-3 text-xl font-semibold">
                    Trending ads
                </div>
                <div class="w-full flex flex-wrap pb-[16px] lg:pb-0">
                    <Product v-for="(advert,index) in adverts"
                    :advert="advert"
                    :key="index"/>
                </div>
            </section>
        </main>
        <Footer/>
    </section>
    <Bottomnavigationbar/>
</template>
