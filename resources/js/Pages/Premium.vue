<script>
import { Head, Link } from '@inertiajs/vue3';
import Heading from '../Components/Heading.vue';
import { store } from '../store.js';
import Plan from '../Components/Plan.vue';
import Footer from '../Components/Footer.vue';
import CategoryTab from '../Components/CategoryTab.vue';
import Navbar from '../Components/Navbar.vue';
import Preloader from '../Components/Preloader.vue';
import Bottomnavigationbar from '../Components/Bottomnavigationbar.vue';
export default {
    props:{
        categories: Array,
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
        Bottomnavigationbar
    },
    data(){
        return {
            store,
            plancategories:[
                {
                    title: 'Cars',
                    icon: 'bx-car',
                    plans: [
                        {
                            tag: 'Most Popular',
                            icon: 'bx-trending-up',
                            title: 'Regular',
                            price: 3999,
                            discount: 0,
                            properties: {
                                count: 5,
                                autorenew: 24,
                                sms: false,
                                badge: null,
                                links: null
                            }
                        },
                        {
                            tag: 'Recommended',
                            icon: 'bx-badge-check',
                            title: 'Premium',
                            price: 5999,
                            discount: 0,
                            properties: {
                                count: 20,
                                autorenew: 12,
                                sms: true,
                                badge: 'TOP',
                                links: null
                            }
                        },
                        {
                            tag: 'Best value',
                            icon: 'bx-diamond',
                            title: 'Diamond',
                            price: 9999,
                            discount: 0,
                            properties: {
                                count: 100,
                                autorenew: 3,
                                sms: true,
                                badge: 'VIP',
                                links: true
                            }
                        }
                    ]
                },
                {
                    title: 'Land & Properties',
                    icon: 'bx-home',
                    plans: [
                        {
                            active: true,
                            icon: 'bx-shopping-bag',
                            title: 'Basic',
                            price: null,
                            discount: 0,
                            properties: {
                                count: 1,
                                autorenew: null,
                                sms: false,
                                badge: null,
                                links: null
                            }
                        },
                        {
                            tag: 'Most Popular',
                            icon: 'bx-trending-up',
                            title: 'Regular',
                            price: 3999,
                            discount: 0,
                            properties: {
                                count: 5,
                                autorenew: 24,
                                sms: false,
                                badge: null,
                                links: null
                            }
                        },
                        {
                            tag: 'Recommended',
                            icon: 'bx-badge-check',
                            title: 'Premium',
                            price: 5999,
                            discount: 0,
                            properties: {
                                count: 20,
                                autorenew: 12,
                                sms: true,
                                badge: 'TOP',
                                links: null
                            }
                        },
                        {
                            tag: 'Best value',
                            icon: 'bx-diamond',
                            title: 'Diamond',
                            price: 9999,
                            discount: 0,
                            properties: {
                                count: 100,
                                autorenew: 3,
                                sms: true,
                                badge: 'VIP',
                                links: true
                            }
                        }
                    ]
                },
                {
                    title: 'Others items',
                    icon: 'bx-category',
                    plans: [
                        {
                            active: true,
                            icon: 'bx-shopping-bag',
                            title: 'Basic',
                            price: null,
                            discount: 0,
                            properties: {
                                count: 1,
                                autorenew: null,
                                sms: false,
                                badge: null,
                                links: null
                            }
                        },
                        {
                            tag: 'Most Popular',
                            icon: 'bx-trending-up',
                            title: 'Regular',
                            price: 3999,
                            discount: 0,
                            properties: {
                                count: 5,
                                autorenew: 24,
                                sms: false,
                                badge: null,
                                links: null
                            }
                        },
                        {
                            tag: 'Recommended',
                            icon: 'bx-badge-check',
                            title: 'Premium',
                            price: 5999,
                            discount: 0,
                            properties: {
                                count: 20,
                                autorenew: 12,
                                sms: true,
                                badge: 'TOP',
                                links: null
                            }
                        },
                        {
                            tag: 'Best value',
                            icon: 'bx-diamond',
                            title: 'Diamond',
                            price: 9999,
                            discount: 0,
                            properties: {
                                count: 100,
                                autorenew: 3,
                                sms: true,
                                badge: 'VIP',
                                links: true
                            }
                        }
                    ]
                }
            ],
            plans: [],
        }
    },
    methods:{
        back(){
            window.history.back();
        }
    },
    mounted(){
    }
}
</script>

<template>
    <Head>
        <title>Plans</title>
    </Head>
    <!-- <div class="hidden lg:block">
        <Heading/>
    </div> -->
    <Preloader/>
    <div class="relative top-[60px]">
        <section class="w-full flex flex-col items-center min-h-[calc(100vh-60px)] bg-slate-50">
            <Navbar/>
            <!-- <nav class="lg:hidden w-full h-[60px] flex items-center gap-x-4 px-2 bg-white fixed left-0 top-0 shadow z-50">
                <button @click="back">
                    <i class='text-4xl pointer-events-none bx bx-chevron-left text-black/60'></i>
                </button>
                <h4 class="text-lg font-semibold text-black/80">Plans</h4>
            </nav> -->
            <main class="w-full xl:w-5/6 min-h-[calc(100vh-60px)] p-4 lg:p-8">
                <header class="mb-6 text-center">
                    <h3 class="mb-2 text-xl lg:text-3xl font-semibold">Simple, transparent pricing</h3>
                    <p class="text-slate-700">Choose a suitable plan for your ad.</p>
                    <small class="text-slate-500 text-xs">No contracts, No hidden charges.</small>
                </header>
                <section class="w-full flex flex-col md:flex-row gap-2 lg:gap-4">
                    <section class="w-full md:w-3/12 lg:w-2/12 mb-4 rounded-lg">
                        <CategoryTab
                            :categories="plancategories"
                            v-model="plans"/>
                    </section>
                    <section class="grid w-full md:w-9/12 lg:w-10/12 grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
                        <Plan
                            v-for="(plan,index) in plans"
                            :key="index"
                            :icon="plan?.icon"
                            :title="plan?.title"
                            :price="plan?.price"
                            :discount="plan?.discount"
                            :active="plan?.active"
                            :properties="plan?.properties"
                            :tag="plan?.tag"/>
                    </section>
                </section>
            </main>
        </section>
        <Bottomnavigationbar/>
        <Footer/>
    </div>
</template>
