<script>
import { Head, Link, router } from '@inertiajs/vue3';
import Heading from '../Components/Heading.vue';
import { store } from '../store.js';
import Plan from '../Components/Plan.vue';
import Footer from '../Components/Footer.vue';
import CategoryTab from '../Components/CategoryTab.vue';
import Navbar from '../Components/Navbar.vue';
import Preloader from '../Components/Preloader.vue';
import Bottomnavigationbar from '../Components/Bottomnavigationbar.vue';
import SnackBar from '../Components/SnackBar.vue';
export default {
    props:{

    },
    components:{
        Heading,
        Head,
        Link,
        Plan,
        Footer,
        CategoryTab,
        Navbar,
        Preloader,
        Bottomnavigationbar,
        SnackBar
    },
    data(){
        return {
            store,
        }
    },
    methods:{
    },
    mounted(){
    }
}
</script>

<template>
    <Head>
        <title>Transaction Cancelled</title>
    </Head>
    <Preloader/>
    <SnackBar/>
    <div class="relative top-[60px]">
        <section class="w-full flex flex-col items-center min-h-[calc(100vh-60px)] bg-slate-50">
            <Navbar/>
            <main class="w-full xl:w-5/6 min-h-[calc(100vh-60px)] p-4 lg:p-8">
                <header class="mb-6 text-center">
                    <h3 class="mb-2 text-xl lg:text-3xl font-semibold">Transaction Cancelled!</h3>
                    <p class="text-slate-700">You have cancelled the payment.</p>
                    <!-- <small class="text-slate-500 text-xs">No contracts, No hidden charges.</small> -->
                </header>
                <section class="w-full flex flex-col md:flex-row gap-2 lg:gap-4">
                </section>
            </main>
        </section>
        <Bottomnavigationbar/>
        <Footer/>
    </div>
</template>
