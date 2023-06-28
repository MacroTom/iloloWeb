<script>
import { Head, Link } from '@inertiajs/vue3';
import Bottomnavigationbar from '../Components/Bottomnavigationbar.vue';
import { store } from '../store.js';
import Navbar from '../Components/Navbar.vue';
import Preloader from '../Components/Preloader.vue';
export default{
    props:{
        auth: Object
    },
    components:{
        Head,
        Link,
        Bottomnavigationbar,
        Navbar,
        Preloader
    },
    data(){
        return{
            store,
        }
    },
    mounted(){
    }
}
</script>

<template>
    <Navbar/>
    <section class="w-full min-h-[calc(100vh-60px)] overflow-auto scrollbar-hide lg:scrollbar-default pt-[60px] left-0 flex flex-col lg:flex-row px-4 pb-4 lg:pb-8 lg:px-8 xl:px-28 bg-white">
        <aside class="w-3/12 py-8 border-r hidden lg:block">
            <Link href="/profile" :class="$page.url === '/profile' ? 'bg-slate-50' : ''" class="w-[250px] flex items-center gap-4 p-3 hover:bg-slate-50 rounded-lg mb-1">
                <i class='bx bx-user text-xl text-slate-600'></i>
                <span class="text-sm">Profile</span>
            </Link>
            <Link href="/profile/ads" :class="$page.url.startsWith('/profile/ads') ? 'bg-slate-50' : ''" class="w-[250px] flex items-center gap-4 p-3 hover:bg-slate-50 rounded-lg mb-1">
                <i class='bx bx-bar-chart-alt-2 text-xl text-slate-600'></i>
                <span class="text-sm">My adverts</span>
            </Link>
            <Link href="/profile/bookmarks" :class="$page.url === '/profile/bookmarks' ? 'bg-slate-50' : ''" class="w-[250px] flex items-center gap-4 p-3 hover:bg-slate-50 rounded-lg mb-1">
            <i class='bx bx-bookmark text-xl text-slate-600'></i>
                <span class="text-sm">Bookmarks</span>
            </Link>
            <Link href="/logout" method="post" as="button" class="w-[250px] flex items-center gap-4 p-3 hover:bg-slate-50 rounded-lg mb-1">
                <i class='bx bx-log-out text-xl text-slate-600'></i>
                <span class="text-sm">Logout</span>
            </Link>
        </aside>

        <aside class="lg:hidden mt-2">
            <div class="flex pb-2">
                <Link href="/profile" :class="$page.url === '/profile' ? 'text-[#1895B0] font-semibold border-[#1895B0]' : 'text-slate-500'" class="text-sm font-Inter font-medium border-b-2 flex items-center gap-1 py-3 px-2 flex-1">
                    <span>Profile</span>
                </Link>
                <Link href="/profile/ads" :class="$page.url.startsWith('/profile/ads') ? 'text-[#1895B0] font-semibold border-[#1895B0]' : 'text-slate-500'" class="text-sm font-Inter text-slate-600 font-medium border-b-2 flex items-center gap-1 py-3 px-2 flex-1">
                    <span>My adverts</span>
                </Link>
                <Link href="/profile/bookmarks" :class="$page.url === '/profile/bookmarks' ? 'text-[#1895B0] font-semibold border-[#1895B0]' : 'text-slate-500'" class="text-sm font-Inter text-slate-600 font-medium border-b-2 flex items-center gap-1 py-3 px-2 flex-1">
                    <span>Bookmarks</span>
                </Link>
            </div>
        </aside>
        <slot/>
    </section>
    <Bottomnavigationbar/>
</template>
