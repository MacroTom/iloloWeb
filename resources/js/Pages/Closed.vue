<script>
import Layout from '../Layouts/Layout.vue';
import {store} from '../store.js';
import { Head, Link } from '@inertiajs/vue3';
import Preloader from '../Components/Preloader.vue';
import ProfileLinks from '../Components/ProfileLinks.vue';
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
        ProfileLinks
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
            <section class="ad" v-for="(advert, index) in adverts" :key="index">
                <div class="w-12 h-12 mr-3">
                    <img class="object-cover w-full h-full rounded-lg" :src="advert.images[0].source" alt="image">
                </div>
                <div class="flex flex-col gap-1 flex-1">
                    <p class="text-slate-700 text-sm font-semibold overflow-hidden whitespace-nowrap text-ellipsis">{{ advert.title }}</p>
                    <small class="text-xs text-slate-600">{{ formatCurrency(advert.price) }}</small>
                </div>
                <div class="ml-4 flex flex-col items-end gap-2 lg:gap-4">
                    <small class="text-[10px] text-slate-600 border px-2 py-1 rounded-lg">closed</small>
                    <small class="text-[10px] text-slate-600 text-right">{{ formatDate(advert.created_at) }}</small>
                </div>
            </section>

            <section v-if="adverts.length === 0" class="ad justify-center flex-col">
                <i class='bx bx-box text-4xl text-slate-500'></i>
                <p class="text-slate-600 text-sm">No adverts yet...</p>
            </section>
        </div>
    </main>
</template>
