<script>
import { Link, router } from '@inertiajs/vue3';
import { store } from '../store';
import currency from 'currency.js';
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
            hasLabel: false,
            store
        }
    },
    methods:{
        formatCurrency(value){
            return currency(value, {separator: ',', symbol: '₦', precision: 0}).format();
        },
        handleClick(evt){
            let button = evt.target;
            button.disabled = true;
            let url = this.$page.props.bookmarks.includes(this.advert.id) ? 'remove' : 'add';
            router.post(`/profile/bookmarks/${this.advert.id}/${url}`, {},
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

<template>
    <div class="w-1/2 md:w-1/3 lg:w-1/5 xl:w-1/6 rounded-lg px-[4px] mb-4 shadow-lg shadow-[#e0e0e0]/80 flex-shrink-0">
        <div>
            <Link :href="`/advert/${advert.id}`" class="relative w-full h-[120px] md:h-[150px] block">
                <img class="w-full h-full object-contain rounded-t-lg" :src="advert?.images[0]?.source" alt="product">
            </Link>
            <div class="relative p-4 bg-white rounded-b-lg">
                <p class="overflow-hidden text-sm whitespace-nowrap text-ellipsis">{{ advert.title }}</p>
                <div class="flex justify-between items-center">
                    <small class="text-[#1895B0] font-medium">{{formatCurrency(advert.price)}}</small>
                    <!-- badge -->
                    <span v-if="hasLabel" class="w-7 h-7 bg-slate-100 rounded-lg px-1 flex justify-center items-center">
                        <i class='bx bxs-trophy text-lg text-[#DB8505] pointer-events-none'></i>
                    </span>
                </div>
                <button @click="handleClick($event)" class="bg-white shadow w-8 h-8 absolute right-1 -top-4 text-[#1895B0] flex justify-center items-center rounded-full">
                    <i :class="$page.props.bookmarks.includes(advert.id) ? 'bxs-bookmark' : 'bx-bookmark'" class='bx'></i>
                </button>
            </div>
        </div>
    </div>
</template>
