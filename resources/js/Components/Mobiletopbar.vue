<script>
import { Link } from '@inertiajs/vue3';
import { store } from '../store.js';
export default {
    components:{
        Link
    },
    data(){
        return {
            store
        }
    }
}
</script>

<template>
    <div
        class="w-full min-h-[40px] fixed top-0 left-0 z-10 bg-[#1895B0] flex lg:hidden justify-between items-center px-3"
        >
        <div @click="store.toggleDrawer()"
            class="flex justify-center items-center text-[#d9d9d9] select-none">
            <i class='bx bx-menu text-3xl font-normal'></i>
        </div>
        <div class="flex items-center">
            <img width="80" src="/images/logo.png" alt="logo"/>
        </div>
        <div class="rounded-full flex justify-center items-center gap-4 w-8 h-8 bg-[#d9d9d9] text-slate-600">
            <i class='bx bx-user text-xl'></i>
        </div>
    </div>
</template>
