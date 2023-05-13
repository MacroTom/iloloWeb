<script>
import Layout from '../Layouts/Layout.vue';
import Tabmanager from '../Components/Tabmanager.vue';
import {store} from '../store.js';
import Ad from '../Components/Ad.vue';
import { Head } from '@inertiajs/vue3';
export default{
    layout: Layout,
    props:{
        auth: Object
    },
    components:{
        Tabmanager,
        Ad,
        Head
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
        <title>My Advert</title>
    </Head>
    <Tabmanager
        heading="My Advert"
        :tabs="store.profiletabs"
        >
        <Ad v-for="ad in store.ads.active" :key="ad.id" :details="ad"/>
    </Tabmanager>
</template>
