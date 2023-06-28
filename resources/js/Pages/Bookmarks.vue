<script>
import Layout from '../Layouts/Layout.vue';
import {store} from '../store.js';
import { Head, Link, router } from '@inertiajs/vue3';
import Preloader from '../Components/Preloader.vue';
import SnackBar from '../Components/SnackBar.vue';
import currency from 'currency.js';
import moment from 'moment';
export default{
    layout: Layout,
    props:{
        auth: Object,
        bookmarks: Object
    },
    components:{
        Head,
        Preloader,
        Link,
        SnackBar
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
        },
        handleClick(evt,id){
            let button = evt.target;
            button.disabled = true;
            router.post(`/profile/bookmarks/${id}/remove`, {},
            {
                onSuccess: (res) => {
                    this.store.snackbar.add({
                        message: res.props.flash.message,
                        severity: "success"
                    });
                    button.disabled = false;
                },
                onError: (err) => {
                    this.store.snackbar.add({
                        message: err.message,
                        severity: "warning"
                    });
                    button.disabled = false;
                },
                preserveState: true, preserveScroll: true
            },
            );
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
        <title>Bookmarks</title>
    </Head>
    <Preloader/>
    <SnackBar/>
    <main class="w-full lg:w-7/12 xl:w-6/12 pt-2 lg:pt-4 lg:pl-12 pb-6">
        <div class="mb-6">
            <h3 class="text-lg lg:text-2xl text-slate-700 font-Inter font-semibold mb-4">Bookmarks</h3>
        </div>

        <div class="list">
            <section class="ad" v-for="(bookmark, index) in bookmarks" :key="index">
                <div class="w-14 h-14 mr-3">
                    <img class="object-cover w-full h-full rounded-lg" :src="bookmark.images[0].source" alt="image">
                </div>
                <div class="flex flex-col gap-1 flex-1">
                    <Link :href="`/advert/${bookmark.id}`" class="text-slate-700 text-sm font-semibold overflow-hidden whitespace-nowrap text-ellipsis">{{ bookmark.title }}</Link>
                    <small class="text-xs text-slate-600">{{ formatCurrency(bookmark.price) }}</small>
                    <small class="text-[10px] text-slate-600 flex items-center">
                        <i class='bx bx-map'></i>
                        {{ bookmark.location }}
                    </small>
                </div>
                <div class="ml-4 flex flex-col items-end gap-2 lg:gap-4">
                    <button @click="handleClick($event, bookmark.id)" class="w-fit h-fit px-2 py-1 text-slate-600 hover:bg-[#1895B0] hover:text-white hover:border-transparent rounded-lg border cursor-pointer">
                        <i class='bx bx-bookmark-minus pointer-events-none'></i>
                    </button>
                    <small class="text-[10px] text-slate-600 text-right">{{ formatDate(bookmark.created_at) }}</small>
                </div>
            </section>

            <section v-if="bookmarks.length === 0" class="ad justify-center flex-col">
                <i class='bx bx-box text-4xl text-slate-500'></i>
                <p class="text-slate-600 text-sm">No Bookmarks yet...</p>
            </section>
        </div>
    </main>
</template>
