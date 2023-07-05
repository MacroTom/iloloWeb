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
import DurationButtons from '../Components/DurationButtons.vue';
export default {
    props:{
        plans: Array,
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
    SnackBar,
    DurationButtons
},
    data(){
        return {
            store,
            selectedPlans: [],
            selectedPlan: null,
            duration: 1,
            durations: [1,3,6],
            categories: [
                {title: 'Cars', icon: 'bx-car', key: 'C'},
                {title: 'Land & Property', icon: 'bx-home', key: 'L'},
                {title: 'Others', icon: 'bx-category', key: 'O'}
            ]
        }
    },
    watch:{
        selectedPlan(){
            this.setSelectedPlans();
        },
        duration(){
            this.setSelectedPlans();
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
        },
        // removeDuplicateItems(arr){
        //     let uniqueItems = [];
        //     arr.forEach((item) => {
        //         if (!uniqueItems.includes(item)) {
        //             uniqueItems.push(item);
        //         }
        //     });
        //     return uniqueItems;
        // },
        getSelectedPlansByCategory(){
            return this.plans.filter((plan) => plan.category_type === this.selectedPlan);
        },
        setSelectedPlans(){
            this.selectedPlans = this.getSelectedPlansByCategory().filter(plan => (plan.duration === this.duration));
        },
        // setDurationButtons(){
        //     let selected = this.getSelectedPlansByCategory();
        //     this.durations = this.removeDuplicateItems(selected.map(el => el.duration)).sort((a, b) => a-b);
        // }
    },
    mounted(){
        // console.log(this.plan);
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
            <main class="w-full xl:w-5/6 min-h-[calc(100vh-60px)] p-4 lg:p-8">
                <header class="mb-6 text-center">
                    <h3 class="mb-2 text-xl lg:text-3xl font-semibold">Simple, transparent pricing</h3>
                    <p class="text-slate-700">Choose a suitable plan for your ad.</p>
                    <small class="text-slate-500 text-xs">No contracts, No hidden charges.</small>
                </header>
                <section class="w-full flex flex-col md:flex-row gap-2 lg:gap-4">
                    <section class="w-full h-fit md:w-3/12 lg:w-2/12 mb-4 rounded-lg shadow bg-white pt-1">
                        <CategoryTab
                            :categories="categories"
                            v-model="selectedPlan"/>
                        <DurationButtons v-model="duration" :durations="durations"/>
                    </section>
                    <section class="grid w-full md:w-9/12 lg:w-10/12 grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
                        <Plan
                            v-for="(subplan,index) in selectedPlans"
                            :key="index"
                            :id="subplan?.id"
                            :icon="subplan?.icon"
                            :title="subplan?.title"
                            :price="subplan?.price"
                            :discount="subplan?.discount"
                            :properties="subplan?.properties"
                            :tag="subplan?.tag"
                            :action="buyPlan"
                            :active="!subplan?.price ? true : false"
                            :loading="subplan?.id"/>
                    </section>
                </section>
            </main>
        </section>
        <Bottomnavigationbar/>
        <Footer/>
    </div>
</template>
