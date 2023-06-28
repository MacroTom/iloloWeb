<script>
import { Link, router } from '@inertiajs/vue3';
import currency from 'currency.js';
import moment from 'moment';
export default{
    props: {
        advert: Object
    },
    components:{
        Link
    },
    data(){
        return{}
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
</style>

<template>
    <section class="ad">
        <div class="w-12 h-12 mr-3">
            <img class="object-cover w-full h-full rounded-lg" :src="advert.images[0].source" alt="image">
        </div>
        <div class="flex flex-col gap-1 flex-1">
            <p class="text-slate-700 text-sm font-semibold overflow-hidden whitespace-nowrap text-ellipsis">{{ advert.title }}</p>
            <small class="text-xs text-slate-600">{{ formatCurrency(advert.price) }}</small>
        </div>
        <div class="ml-4 flex flex-col items-end gap-2 lg:gap-4">
            <Link :href="`/postad?edit=${advert.id}`" class="w-fit h-fit block px-2 py-1 text-slate-600 hover:bg-[#1895B0] hover:text-white hover:border-transparent rounded-lg border cursor-pointer">
                <i class='bx bx-pencil pointer-events-none'></i>
            </Link>
            <small class="text-[10px] text-slate-600 text-right">{{ formatDate(advert.updated_at) }}</small>
        </div>
    </section>
</template>
