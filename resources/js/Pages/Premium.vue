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
        plancategories: Array,
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
            plans: [],
            form: {
                duration: 1
            }
        }
    },
    methods:{
        back(){
            window.history.back();
        },
        buyPlan(id,evt){
            let button = evt.target;
            button.disabled = true;
            router.post(`/plan/${id}/buy`, this.form,
            {
                onSuccess: (res) => {
                    let url = res.props.flash.data.checkout_url;
                    window.location = url;
                    this.store.snackbar.add({
                        message: "Redirecting to Paystack!",
                        severity: "success"
                    });
                    button.disabled = false;
                },
                onError: (err) => {
                    this.store.snackbar.add({
                        message: err.message,
                        severity: "warning"
                    });
                    button.disabled = false;
                },
            },
            );
        }
    },
    mounted(){
        // console.log(this.plancategories);
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
    <SnackBar/>
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
                            :id="plan?.id"
                            :icon="plan?.icon"
                            :title="plan?.title"
                            :price="plan?.price"
                            :discount="plan?.discount"
                            :properties="plan?.properties"
                            :tag="plan?.tag"
                            :action="buyPlan"
                            :active="!plan?.price ? true : false"
                            :loading="plan?.id"/>
                    </section>
                </section>
            </main>
        </section>
        <Bottomnavigationbar/>
        <Footer/>
    </div>
</template>
