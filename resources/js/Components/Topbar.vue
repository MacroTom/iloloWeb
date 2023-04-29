<script>
import { Link } from '@inertiajs/vue3';
export default {
    components:{
        Link
    },
    data(){
        return {}
    },
    mounted(){
    }
}
</script>

<template>
    <div
        class="w-full min-h-[60px] shadow-lg shadow-black/80 bg-[#08738A] hidden lg:flex justify-between items-center px-8"
        >
        <div class="flex items-center">
            <img width="80" src="/images/logo.png" alt="logo"/>
        </div>
        <div class="flex items-center gap-4">
            <slot/>
            <Link
                class="h-[35px] flex items-center bg-[#C92125]/80 text-white font-medium text-sm uppercase px-4 rounded-2xl shadow-md shadow-[#134854] hover:bg-[#C92125]/90"
                href="#"
                >Sell</Link>
        </div>
    </div>
</template>
