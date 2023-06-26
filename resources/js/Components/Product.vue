<script>
import { Link } from '@inertiajs/vue3';
export default {
    props:{
        advert: {
            type: Object,
            required: true
        }
    },
    components:{
        Link
    },
    data(){
        return{
            bookmarked: false,
            hasLabel: false
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

<template>
    <div class="w-1/2 md:w-1/3 lg:w-1/5 xl:w-1/6 rounded-lg px-[4px] mb-4 shadow-lg shadow-[#e0e0e0]/80 flex-shrink-0">
        <Link :href="`/advert/${advert.id}`">
            <div class="relative w-full h-[120px] md:h-[150px]">
                <img class="w-full h-full object-cover rounded-t-lg" :src="advert?.images[0].source" alt="product">
                <div v-if="hasLabel" class="w-1/3 uppercase font-light text-white text-center text-xs lg:w-[80px] p-1 bg-[#B92727]/60 absolute left-0 top-0 rounded-tl-lg">
                    SPECIAL
                </div>
            </div>
            <div class="relative p-4 bg-white rounded-b-lg">
                <p class="overflow-hidden text-sm whitespace-nowrap text-ellipsis">{{ advert.title }}</p>
                <small class="text-[#1895B0] font-medium">{{formatCurrency(advert.price)}}</small>
                <button class="bg-white shadow w-8 h-8 absolute right-1 -top-4 text-[#1895B0] flex justify-center items-center rounded-full" v-if="!bookmarked">
                    <i class='bx bx-bookmark'></i>
                </button>
                <button class="bg-white shadow w-8 h-8 absolute right-1 -top-4 text-[#1895B0] flex justify-center items-center rounded-full" v-else>
                    <i class='bx bxs-bookmark'></i>
                </button>
            </div>
        </Link>
    </div>
</template>
