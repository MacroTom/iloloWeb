<script>
import { router } from '@inertiajs/vue3';
import { store } from '../store';
import FlatButton from './FlatButton.vue';
export default {
    components:{
        FlatButton
    },
    props:{
        id: Number,
        icon: String,
        title: String,
        price: Number,
        discount: Number,
        properties: Object,
        tag: String,
        active: Boolean,
        action: Function,
    },
    data(){
        return{
            store
        }
    },
    methods:{

    }
}
</script>

<style scoped>
.plan{
    @apply min-h-[200px] shadow bg-white rounded-xl p-4 relative
}
.plan header{
    @apply flex justify-between items-start mb-5
}
.plan .subheader{
    @apply mb-2
}
.plan .subheader .plan-name{
    @apply text-slate-700 font-Inter
}
.plan .icon{
    @apply w-10 h-10 bg-white rounded-full shadow flex justify-center items-center flex-shrink-0
}
.plan .icon i{
    @apply text-slate-700 text-lg font-light
}
.plan .tag{
    @apply text-xs text-slate-700 font-Inter px-2 py-1 border border-slate-100 rounded-xl
}
.plan .pricing{
    @apply mb-2 text-3xl
}
.plan .price{
    @apply tracking-tight font-semibold font-Inter
}
.plan .discount{
    @apply tracking-tight text-lg font-Inter line-through
}
.plan .currency{
    @apply font-Inter font-medium
}
.plan .divider{
    @apply w-full h-[1px] bg-slate-100 my-4
}
.plan .properties{
    @apply flex flex-col gap-y-3
}
.plan .properties .property{
    @apply w-full flex gap-x-3
}
.plan .properties .property.unavailable *{
    @apply text-black/40 !important
}
.plan .properties .property.unavailable .icon{
    @apply shadow-sm
}
.plan .properties .property .title{
    @apply text-slate-700 font-Inter text-sm font-semibold
}
.plan .properties .property .subtitle{
    @apply text-xs text-slate-500 font-Inter
}
.plan .discount-off{
    @apply w-fit tracking-tight text-white flex flex-col gap-0 justify-end items-center py-2 px-3 h-[60px] rounded-b-3xl bg-red-500
}
</style>

<template>
    <section class="plan self-stretch">
        <div v-if="discount" class="absolute top-0 left-0 flex justify-center w-full">
            <span class="discount-off">
                <p><strong>{{discount}}%</strong></p>
                <p class="text-xs">off</p>
            </span>
        </div>
        <header>
            <span class="icon"><i :class="icon ? icon : 'bx-shopping-bag'" class='bx'></i></span>
            <span v-if="tag" class="tag">{{tag}}</span>
        </header>

        <div class="subheader">
            <span class="plan-name">{{ title }}</span>
        </div>

        <div class="pricing">
            <span class="text-slate-700">
                <span v-if="price" class="currency">₦</span>
                <span v-if="price && !discount" class="price">{{ price }}</span>
                <span v-if="!price && !discount" class="price">Free</span>
                <span v-if="discount" class="price">{{ Math.floor(price - (price * (discount/100))) }}</span>
                <span v-if="discount" class="discount">{{ price }}</span>
            </span>
            <span v-if="price" class="text-xs font-Inter text-slate-600">/month</span>
        </div>

        <div class="divider"></div>
        <main class="properties">
            <div class="property">
                <span class="icon"><i class='bx bx-package'></i></span>
                <div>
                    <p class="title">Up to {{ properties.count }}{{ properties.count && properties.count > 1 ? ' ads' : ' ad'  }} </p>
                    <small class="subtitle">Easily post ads in category.</small>
                </div>
            </div>
            <div :class="properties?.autorenew ? '' : 'unavailable'" class="property">
                <span class="icon"><i class='text-2xl bx bx-refresh'></i></span>
                <div>
                    <p class="title">Auto Renewal</p>
                    <small class="subtitle">Auto renews every {{ properties.autorenew }} hours.</small>
                </div>
            </div>
            <div :class="properties?.sms ? '' : 'unavailable'" class="property">
                <span class="icon"><i class='bx bx-bell'></i></span>
                <div>
                    <p class="title">New message notification</p>
                    <small class="subtitle">Get an SMS when you get a message.</small>
                </div>
            </div>
            <div :class="properties?.badge ? '' : 'unavailable'" class="property">
                <span class="icon"><i class='bx bx-badge'></i></span>
                <div>
                    <p class="title">Ad Badge</p>
                    <small class="subtitle">Badge set you apart from other sellers.</small>
                </div>
            </div>
            <div :class="properties?.links ? '' : 'unavailable'" class="property">
                <span class="icon"><i class='bx bx-link'></i></span>
                <div>
                    <p class="title">Website & Social media links</p>
                    <small class="subtitle">Add link to your website and social media pages.</small>
                </div>
            </div>
        </main>
        <div class="divider"></div>
        <button v-if="active" class="w-full button stroke font-Inter">Active</button>
        <FlatButton class="w-full" @click="$page.props.auth?.user ? action(id,$event) : store.toggleFormTab('signin')" v-else="active" label="Get started" primary/>
    </section>
</template>
