<script>
import { Link,router } from '@inertiajs/vue3';
import { store } from '../store.js';
import currency from 'currency.js';
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
            store,
            styles: {
                premium: { bg: 'bg-[#ebf2f7]', border: 'border-transparent' },
                gold: {bg:'bg-[#ebf2f7]', border: 'border-[#E3A600]'},
                diamond: {bg:'bg-[#DAEAED]', border: 'border-[#1895B0]/60'},
            }
        }
    },
    methods:{
        formatCurrency(value){
            return currency(value, {separator: ',', symbol: '₦', precision: 0}).format();
        },
        shortenNumber(number){
            if(number >= 1000000000){
                return (number/1000000000).toFixed(1).replace(/\.0$/,'') + 'B';
            }
            if(number >= 1000000){
                return (number/1000000).toFixed(1).replace(/\.0$/,'') + 'M';
            }
            if(number >= 1000){
                return (number/1000).toFixed(1).replace(/\.0$/,'') + 'K';
            }
            return number;
        },
        handleClick(evt){
            let button = evt.target;
            button.disabled = true;
            let url = this.$page.props.bookmarks.includes(this.advert?.id) ? 'remove' : 'add';
            router.post(`/profile/bookmarks/${this.advert?.id}/${url}`, {},
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
.card{
    @apply bg-white text-slate-600 rounded-lg shadow border-[2px] border-transparent relative flex-shrink-0
}
.card .badge{
    @apply w-8 h-8 p-1 lg:w-9 lg:h-9 lg:p-2 flex justify-center items-center rounded-tl-lg rounded-br-lg /*bg-[#DAEAED]*/ bg-[#ebf2f7] text-white absolute bottom-2 right-2 lg:bottom-4 lg:right-4
}
</style>

<template>
    <div class="card">
        <!-- Hot -->
        <span class="absolute left-2 top-2 text-xs px-2 py-1 rounded text-white bg-pink-600 font-Inter tracking-wider">HOT</span>
        <!-- bookmark button -->
        <button @click="$page.props.auth?.user ? handleClick($event) : store.toggleFormTab()" class="w-8 h-8 lg:w-9 lg:h-9 rounded-lg absolute top-2 right-2 lg:top-4 lg:right-4 bg-[#1895B0]/30 hover:bg-[#1895B0]/70 text-slate-100">
            <i :class="$page.props.bookmarks.includes(advert?.id) ? 'bxs-bookmark' : 'bx-bookmark'" class="bx text-lg"></i>
        </button>
        <Link class="rounded-t-lg" :href="`/advert/${advert?.id}`">
            <div class="h-[8rem] lg:h-44 overflow-hidden rounded-t-lg">
                <img class="w-full h-full object-cover rounded-t-lg" :src="advert?.images[0]?.source" alt="image">
            </div>
            <div class="min-h-[5rem] p-2 lg:p-4 relative rounded-b-lg">
                <p class="mb-1 text-xs lg:text-sm text-slate-700 overflow-hidden overflow-ellipsis whitespace-nowrap">{{ advert?.title }}</p>
                <span class="mb-1 flex items-center gap-1">
                    <span class="text-xs font-Inter text-slate-600">{{ advert?.state }}, {{ advert?.lga }}</span>
                </span>
                <p class="text-xl text-slate-600 font-semibold font-Inter">₦{{ shortenNumber(advert?.price) }}</p>
                <span class="badge">
                    <!-- <i class="bx bxs-crown"></i> -->
                    <img class="object-cover w-full h-full" src="/images/badges/crown.png" alt="badge">
                </span>
            </div>
        </Link>
    </div>
</template>
