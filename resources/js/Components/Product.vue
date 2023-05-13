<script>
import { Link } from '@inertiajs/vue3';
export default {
    components:{
        Link
    },
    data(){
        return{
            bookmarked: false,
            hasLabel: true
        }
    }
}
</script>

<template>
    <div class="w-1/2 md:w-1/3 lg:w-1/4 xl:w-1/5 rounded-lg px-[4px] mb-4 shadow-lg shadow-[#e0e0e0]/80 flex-shrink-0">
        <Link href="#">
            <div class="w-full relative">
                <img class="w-full object-cover rounded-t-lg" src="/images/product.png" alt="product">
                <div v-if="hasLabel" class="w-1/3 font-light text-white text-center text-xs lg:w-[80px] p-1 bg-[#B92727]/60 absolute left-0 top-0 rounded-tl-lg">
                    SPECIAL
                </div>
            </div>
            <div class="bg-white py-2 px-4 rounded-b-lg relative">
                <p>Versace Shoe</p>
                <small class="text-[#1895B0] font-medium">₦5000.00</small>
                <button class="bg-[#d9d9d9] w-8 h-8 absolute right-1 -top-4 text-[#1895B0] flex justify-center items-center rounded-full" v-if="!bookmarked">
                    <i class='bx bx-bookmark'></i>
                </button>
                <button class="bg-[#d9d9d9] w-8 h-8 absolute right-1 -top-4 text-[#1895B0] flex justify-center items-center rounded-full" v-else>
                    <i class='bx bxs-bookmark'></i>
                </button>
            </div>
        </Link>
    </div>
</template>
