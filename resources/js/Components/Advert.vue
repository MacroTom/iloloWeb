<script>
import { Link } from '@inertiajs/vue3';
export default {
    props:{
        advert: {
            type: Object,
        }
    },
    components:{
        Link
    },
    data(){
        return{
            bookmarked: false
        }
    },
    methods:{
        formatCurrency(value){
            let currency = new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'NGN',
            });
            return "₦" + currency.format(value).replace("NGN","");
        }
    }
}
</script>

<style scoped>
.card{
    @apply w-1/2 md:w-1/3 lg:w-1/4 bg-white rounded-2xl shadow p-2 lg:p-3
}
</style>

<template>
    <div class="card">
        <Link href="#">
            <div class="w-full h-[130px] relative">
                <div class="absolute flex items-center justify-center w-8 h-8 bg-white rounded-full shadow right-1 bottom-1 lg:right-2 lg:bottom-2"><i :class="bookmarked ? 'bxs-bookmark' : 'bx-bookmark'" class='text-[#1895B0] bx pointer-events-none'></i></div>
                <img class="object-cover w-full h-full rounded-2xl" src="/images/product.png" alt="image">
            </div>
            <div class="py-2 lg:py-3">
                <p class="overflow-hidden text-sm font-medium text-slate-700 whitespace-nowrap text-ellipsis">Samsung Galaxy S7 Green Silver</p>
                <small class="font-medium text-slate-600">{{formatCurrency(68000)}}</small>
            </div>
            <div class="flex items-center gap-2">
                <img class="w-8 h-8 rounded-full shadow-lg" src="/images/product.png" alt="image"/>
                <Link href="#" class="text-sm text-slate-500">John Doe</Link>
            </div>
        </Link>
    </div>
</template>
