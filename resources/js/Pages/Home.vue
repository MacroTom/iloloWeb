<script>
import { Head, Link } from '@inertiajs/vue3';
import Topbar from '../Components/Topbar.vue';
import Mobiletopbar from '../Components/Mobiletopbar.vue';
import Categorysidebar from '../Components/Categorysidebar.vue';
import Bottomnavigationbar from '../Components/Bottomnavigationbar.vue';
import Banner from '../Components/Banner.vue';
import Product from '../Components/Product.vue';
import Category from '../Components/Category.vue';
import Footer from '../Components/Footer.vue';
export default {
    components:{
    Mobiletopbar,
    Topbar,
    Head,
    Link,
    Categorysidebar,
    Bottomnavigationbar,
    Banner,
    Product,
    Category,
    Footer
},
    data(){
        return {}
    }
}
</script>

<template>
    <Head>
        <title>iLoLo</title>
    </Head>
    <Topbar>
        <div v-if="!$page.props.user"
            class="text-white">
            <Link class="hover:text-white/80" href="#">Sign in</Link>
            <span> | </span>
            <Link class="hover:text-white/80" href="#">Register</Link>
        </div>
        <div v-else>

        </div>
    </Topbar>
    <Mobiletopbar/>
    <section class="relative top-[40px] lg:top-[60px]">
        <div class="bg-[#1895B0] lg:bg-[#A2BDC3] w-full h-[60px] lg:h-[230px] border-transparent flex justify-center items-center">
            <img width="300" class="hidden lg:block" src="/images/person1.png" alt="person">
            <div class="h-full flex lg:flex-col justify-center items-center gap-2 px-3">
                <div class="flex justify-center items-center">
                    <span class="hidden lg:block text-xs lg:text-xl font-semibold">Explore ilolo in</span>
                    <button class="bg-[#0B0B0C]/75 hover:bg-[#0B0B0C]/90 min-h-[30px] font-semibold flex items-center mx-3 gap-1 px-2 rounded-2xl justify-center text-white">
                        <i class='bx bx-map text-xs pointer-events-none'></i>
                        <span class="text-[10px] pointer-events-none">Location</span>
                        <i class='bx bx-chevron-down pointer-events-none'></i>
                    </button>
                </div>
                <div class="bg-white/80 lg:min-w-[400px] min-h-[40px] flex items-center px-2 py-1 rounded-3xl">
                    <input
                        class="h-full bg-transparent outline-none text-xs flex-1 lg:pl-2"
                        type="text" placeholder="Looking for..."/>
                    <i class='bx bx-search text-lg text-[#1895B0] pointer-events-none'></i>
                </div>
            </div>
            <div class="flex items-baseline">
                <img width="150" class="hidden lg:block" src="/images/person2.png" alt="person">
                <img width="100" class="hidden lg:block" src="/images/person3.png" alt="person">
            </div>
        </div>
        <main class="w-full h-full flex xl:px-36 gap-3 bg-[#eeeeee]">
            <Categorysidebar>
                <Category/>
                <Category/>
                <Category/>
                <Category/>
                <Category/>
            </Categorysidebar>
            <section class="flex-1 p-3">
                <div class="hidden lg:flex gap-3">
                    <div class="w-1/3 py-10 rounded-lg flex flex-col items-center justify-center gap-4 font-medium text-white bg-[#4074FB]/60 hover:bg-[#4074FB]/70 cursor-pointer shadow-lg">
                        <span>Want to sell</span>
                        <i class='bx bx-plus text-5xl pointer-events-none select-none'></i>
                        <span>Post advert for free</span>
                    </div>
                    <Banner class="w-2/3"/>
                </div>
                <div class="py-3 font-semibold text-xl mb-3">
                    Trending ads
                </div>
                <div class="w-full flex flex-wrap pb-[60px] lg:pb-0">
                    <Product/>
                    <Product/>
                    <Product/>
                    <Product/>
                    <Product/>
                    <Product/>
                    <Product/>
                    <Product/>
                    <Product/>
                    <Product/>
                    <Product/>
                    <Product/>
                    <Product/>
                    <Product/>
                    <Product/>
                    <Product/>
                </div>
            </section>
        </main>
        <Footer/>
    </section>
    <Bottomnavigationbar/>
</template>
