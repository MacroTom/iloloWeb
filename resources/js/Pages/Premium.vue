<script>
import Layout from '../Layouts/Layout.vue';
import Tabmanager from '../Components/Tabmanager.vue';
import {store} from '../store.js';
import { Head } from '@inertiajs/vue3';
export default{
    layout: Layout,
    props:{
        auth: Object
    },
    components:{
        Tabmanager,
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
        <title>Premium service</title>
    </Head>
    <Tabmanager
        heading="Premium service"
        >
        <div class="p-4 pb-8">
            <div class="text-center">
                <p class="mb-4 text-lg lg:text-xl font-medium ">iLOLO Premium Services can help you increase sales!</p>
                <p class="text-sm lg:text-sm">Select the appropriate category for your advertisements to increase sales.</p>
            </div>
            <div class="w-full mt-4 flex items-center gap-4 flex-wrap justify-center text-white">
                <button
                    class="w-full md:w-4/12 p-4 rounded-lg text-xs font-medium bg-[#26B94F]"
                    >
                    Cars</button>
                <button
                    class="w-full md:w-4/12 p-4 rounded-lg text-xs font-medium bg-[#FFB800]"
                    >
                    Land & properties</button>
                <button
                    class="w-full md:w-4/12 p-4 rounded-lg text-xs font-medium bg-[#F01010]"
                    >
                    Other items</button>
                <button
                    class="w-full md:w-4/12 p-4 rounded-lg text-xs font-medium bg-[#000000]/60"
                    >
                    Special promotion for selected ads</button>
            </div>
        </div>
    </Tabmanager>
</template>
