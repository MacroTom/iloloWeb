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
        subscriptions: Object
    },
    components:{
        Head,
        Preloader,
        Link,
        SnackBar,
    },
    data(){
        return{
            store,
            categories: {
                O: 'Others',
                C: 'Cars',
                L: 'Land & Property'
            }
        }
    },
    mounted(){
        // console.log(this.subscriptions);
    },
    methods:{
        formatCurrency(value){
            return currency(value, {separator: ',', symbol: '₦', precision: 0}).format();
        },
        formatDate(value){
            return moment(value).fromNow();
        },
        now(value){
            return moment(value).format('HH:mm DD/MM/yy');
        }
    }
}
</script>

<style scoped>
.empty{
    @apply min-h-[50px] flex items-center p-4 border-b last:border-b-0 even:bg-slate-50
}
.list{
    @apply border rounded-lg gap-y-2 lg:gap-0
}
.list *{
    @apply font-Inter
}
.tbl{
    @apply w-full
}
.tbl thead{
    @apply border-b
}
.tbl thead th{
    @apply p-3 text-left text-sm font-medium text-slate-600
}
.tbl tbody{
    @apply divide-y
}
.tbl tbody tr{
    @apply odd:bg-slate-50
}
.tbl tbody td{
    @apply p-3 text-sm text-slate-600 text-left whitespace-nowrap font-Inter
}
.tbl tbody td span.badge{
    @apply px-2 py-1 rounded-lg text-xs tracking-wide
}
</style>

<template>
    <Head>
        <title>Subscriptions</title>
    </Head>
    <Preloader/>
    <SnackBar/>
    <main class="w-full lg:w-7/12 xl:w-6/12 pt-2 lg:pt-4 lg:pl-12 pb-6">
        <div class="mb-6">
            <h3 class="text-lg lg:text-2xl text-slate-700 font-Inter font-semibold mb-4">Subscriptions</h3>
        </div>

        <div v-if="subscriptions.length === 0" class="list">
            <!-- No subscriptions -->
            <section class="empty justify-center flex-col">
                <i class='bx bx-box text-4xl text-slate-500'></i>
                <p class="text-slate-600 text-sm">No subscriptions yet...</p>
            </section>
        </div>

        <!-- Table -->
        <div class="overflow-auto rounded-lg border">
            <table class="tbl">
                <thead>
                    <tr>
                        <th>Plan</th>
                        <th>Amount</th>
                        <th>Category</th>
                        <th>Duration</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(subscription,index) in subscriptions" :key="index">
                        <td>{{ subscription?.plan.title }}</td>
                        <td>{{ categories[subscription?.plan?.category_type] }}</td>
                        <td>{{ formatCurrency(subscription?.plan?.price) }}</td>
                        <td>{{ subscription?.plan?.duration }} {{ subscription?.plan?.duration > 1 ? ' months' : ' month' }}</td>
                        <td>
                            <span class="badge border bg-white">{{ subscription?.status }}</span>
                        </td>
                        <td>{{ now(subscription?.created_at) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>
</template>
