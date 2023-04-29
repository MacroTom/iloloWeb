<script>
import { Link } from '@inertiajs/vue3';
export default{
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
    <nav class="w-full h-[60px] lg:hidden bg-[#18849B] fixed left-0 bottom-0 z-5 flex">
        <Link href="#"
            class="flex flex-col items-center justify-center text-white flex-1">
            <i class='bx bxs-home text-2xl pointer-events-none'></i>
            <span class="font-light text-xs select-none">Home</span>
        </Link>
        <Link href="#"
            class="flex flex-col items-center justify-center text-white flex-1">
            <i class='bx bxs-bookmark text-2xl pointer-events-none'></i>
            <span class="font-light text-xs select-none">Bookmark</span>
        </Link>
        <Link href="#"
            class="flex flex-col items-center justify-center text-white flex-1">
            <i class='bx bxs-plus-square text-2xl pointer-events-none'></i>
            <span class="font-light text-xs select-none">Sell</span>
        </Link>
        <Link href="#"
            class="flex flex-col items-center justify-center text-white flex-1">
            <i class='bx bxs-message-dots text-2xl pointer-events-none'></i>
            <span class="font-light text-xs select-none">Message</span>
        </Link>
        <Link href="#"
            class="flex flex-col items-center justify-center text-white flex-1">
            <i class='bx bxs-user-circle text-2xl pointer-events-none'></i>
            <span class="font-light text-xs select-none">Profile</span>
        </Link>
    </nav>
</template>
