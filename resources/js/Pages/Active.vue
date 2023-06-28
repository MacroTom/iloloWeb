<script>
import Layout from '../Layouts/Layout.vue';
import {store} from '../store.js';
import { Head, Link } from '@inertiajs/vue3';
import Preloader from '../Components/Preloader.vue';
import ProfileLinks from '../Components/ProfileLinks.vue';
import ProfileAdvert from '../Components/ProfileAdvert.vue';
import currency from 'currency.js';
import moment from 'moment';
export default{
    layout: Layout,
    props:{
        auth: Object,
        adverts: Object
    },
    components:{
        Head,
        Preloader,
        Link,
        ProfileLinks,
        ProfileAdvert
    },
    data(){
        return{
            store,
        }
    },
    mounted(){
    },
    methods:{
        formatCurrency(value){
            return currency(value, {separator: ',', symbol: '₦', precision: 0}).format();
        },
        formatDate(value){
            return moment(value).fromNow();
        }
    }
}
</script>

<style scoped>
.ad{
    @apply min-h-[50px] flex items-center p-4 border-b last:border-b-0 even:bg-slate-50
}
.list{
    @apply border rounded-lg
}
.list *{
    @apply font-Inter
}
</style>

<template>
    <Head>
        <title>My Adverts</title>
    </Head>
    <Preloader/>
    <main class="w-full lg:w-7/12 xl:w-6/12 pt-2 lg:pt-4 lg:pl-12 pb-6">
        <div class="mb-4">
            <h3 class="text-lg lg:text-2xl text-slate-700 font-Inter font-semibold mb-4">My Adverts</h3>
        </div>

        <ProfileLinks :links="store.profilelinks"/>

        <div class="list">
            <ProfileAdvert class="ad" v-for="(advert, index) in adverts" :advert="advert" :key="index"/>

            <section v-if="adverts.length === 0" class="ad justify-center flex-col">
                <i class='bx bx-box text-4xl text-slate-500'></i>
                <p class="text-slate-600 text-sm">No adverts yet...</p>
            </section>
        </div>
    </main>
</template>
