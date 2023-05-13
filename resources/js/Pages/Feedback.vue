<script>
import Layout from '../Layouts/Layout.vue';
import Tabmanager from '../Components/Tabmanager.vue';
import {store} from '../store.js';
import { Head } from '@inertiajs/vue3';
import Feed from '../Components/Feed.vue';
export default{
    layout: Layout,
    props:{
        auth: Object
    },
    components:{
        Tabmanager,
        Head,
        Feed
    },
    data(){
        return{
            store,
        }
    },
    mounted(){
    },
    methods:{
    }
}
</script>

<template>
    <Head>
        <title>Feedback</title>
    </Head>
    <Tabmanager
        heading="Feedback"
        :tabs="store.feedbacktabs"
        >
        <div>
            <div v-if="store.feeds.sent.length > 0">
                <div class="pl-4 pt-4">
                    <p class="text-sm font-medium">My Comments</p>
                </div>
                <Feed v-for="(feed, key) in store.feeds.sent" :key="key" :details="feed"/>
            </div>
            <div class="p-4 flex flex-col gap-y-2 items-center text-center" v-else>
                <img class="w-10/12 md:w-7/12 lg:w-5/12" src="/images/feedback.png" alt="nofeedback">
                <p class="text-lg">There is no feedback yet.</p>
                <p class="text-xs">
                    Request that your customers share feedback about you. Copy the link and send it to them.
                </p>
                <button
                    class="py-2 px-4 text-white bg-[#B92727] text-xs rounded"
                    >
                    Copy link
                </button>
            </div>
        </div>
    </Tabmanager>
</template>
