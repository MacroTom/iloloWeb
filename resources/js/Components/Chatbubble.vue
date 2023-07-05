<script>
import moment from 'moment';
import currency from 'currency.js';
export default{
    props:{
        chat: Object
    },
    data(){
        return {}
    },
    methods:{
        format(value){
            return moment(value).format('HH:mm');
        },
        formatDate(value){
            return moment(value).fromNow();
        },
        formatCurrency(value){
            return currency(value, {separator: ',', symbol: '₦', precision: 0}).format();
        },
    }
}
</script>

<style scoped>
.left{
    @apply font-Inter p-3 flex flex-col ml-[10px] gap-y-2 relative flex-shrink-0 rounded-b-lg rounded-tr-lg bg-slate-100 text-slate-700
}
.left::before{
    content: "";
    position: absolute;
    left: -10px;
    border-right: 10px solid #f1f5f9;
    border-bottom: 10px solid transparent;
    border-top: 0px solid;
    top: 0;
}
.right{
    @apply font-Inter p-3 flex flex-col mr-[10px] gap-y-2 relative flex-shrink-0 rounded-b-lg rounded-tl-lg bg-[#1895B0] text-white items-end
}
.right::before{
    content: "";
    position: absolute;
    right: -10px;
    border-left: 10px solid #1895B0;
    border-bottom: 10px solid transparent;
    border-top: 0px solid;
    top: 0;
}
</style>

<template>
    <section v-if="$page.props.auth?.user.id !== chat?.from.id" class="flex mb-4 justify-start">
        <div class="w-8 h-8 relative flex-shrink-0">
            <img class="object-cover w-full h-full rounded-lg" :src="chat?.from.avatar" alt="avatar">
        </div>
        <div class="left"
            >
            <div v-if="chat?.advert">
                <div class="flex justify-between mb-2">
                    <small class="max-w-[90px] text-xs overflow-hidden whitespace-nowrap text-ellipsis bg-[#1895B0] text-white px-2 rounded-lg">{{ chat?.advert?.title }}</small>
                    <small class="text-xs overflow-hidden whitespace-nowrap text-ellipsis bg-[#1895B0] text-white px-2 rounded-lg">{{ formatCurrency(chat?.advert?.price) }}</small>
                </div>
                <div class="w-full flex flex-col h-[200px]">
                    <img class="object-cover w-full h-full rounded-lg" :src="chat?.advert?.images[0].source" alt="attachment">
                </div>
            </div>
            <div class="w-full text-xs">
                {{ chat?.message }}
            </div>
            <small class="text-[10px]">
                {{ formatDate(chat?.created_at) }}
            </small>
        </div>
    </section>

    <section v-else class="flex mb-4 justify-end">
        <div class="right"
            >
            <div v-if="chat?.advert">
                <div class="flex justify-between mb-2">
                    <small class="max-w-[90px] text-xs overflow-hidden whitespace-nowrap text-ellipsis bg-slate-50 text-[#1895B0] px-2 rounded-lg">{{ chat?.advert?.title }}</small>
                    <small class="text-xs overflow-hidden whitespace-nowrap text-ellipsis bg-slate-50 text-[#1895B0] px-2 rounded-lg">{{ formatCurrency(chat?.advert?.price) }}</small>
                </div>
                <div class="w-full flex flex-col h-[200px]">
                    <img class="object-cover w-full h-full rounded-lg" :src="chat?.advert?.images[0].source" alt="attachment">
                </div>
            </div>
            <div class="w-full text-xs">
                {{ chat?.message }}
            </div>
            <small class="text-[10px]">
                {{ formatDate(chat?.created_at) }}
            </small>
        </div>
        <div class="w-8 h-8 relative flex-shrink-0">
            <img class="object-cover w-full h-full rounded-lg" :src="chat?.from.avatar" alt="avatar">
        </div>
    </section>
</template>
