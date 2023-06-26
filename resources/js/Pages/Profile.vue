<script>
import Layout from '../Layouts/Layout.vue';
import Tabmanager from '../Components/Tabmanager.vue';
import {store} from '../store.js';
import Ad from '../Components/Ad.vue';
import { Head } from '@inertiajs/vue3';
import Preloader from '../Components/Preloader.vue';
import Bottomnavigationbar from '../Components/Bottomnavigationbar.vue';
export default{
    layout: Layout,
    props:{
        auth: Object
    },
    components:{
        Tabmanager,
        Ad,
        Head,
        Preloader,
        Bottomnavigationbar
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
        <title>Profile</title>
    </Head>
    <Preloader/>
    <main class="w-full lg:w-7/12 xl:w-6/12 pt-2 lg:pt-4 lg:pl-12">
        <div class="mb-4 lg:mb-6">
            <h3 class="text-lg lg:text-xl text-slate-700 font-Inter font-semibold">Profile settings</h3>
        </div>
        <div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-3 mb-3">
                <div class="p-2 border rounded-lg">
                    <input class="w-full h-full pl-1 text-sm outline-none" type="text" placeholder="Firstname"/>
                </div>
                <div class="p-2 border rounded-lg">
                    <input class="w-full h-full pl-1 text-sm outline-none" type="text" placeholder="Lastname"/>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-3 mb-3">
                <div class="p-2 border rounded-lg">
                    <input class="w-full h-full pl-1 text-sm outline-none" type="email" placeholder="Email"/>
                </div>
                <div class="p-2 border rounded-lg">
                    <input class="w-full h-full pl-1 text-sm outline-none" type="text" placeholder="Phone"/>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-3 mb-3">
                <div class="p-2 border rounded-lg">
                    <input class="w-full h-full pl-1 text-sm outline-none" type="text" placeholder="Facebook Profile Link"/>
                </div>
                <div class="p-2 border rounded-lg">
                    <input class="w-full h-full pl-1 text-sm outline-none" type="text" placeholder="Twitter Profile Link"/>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-3 mb-3">
                <div class="p-2 border rounded-lg">
                    <input class="w-full h-full pl-1 text-sm outline-none" type="text" placeholder="Instagram Profile Link"/>
                </div>
                <div class="p-2 border rounded-lg">
                    <input class="w-full h-full pl-1 text-sm outline-none" type="text" placeholder="Website Link"/>
                </div>
            </div>
            <div class="flex lg:justify-end lg:mt-2">
                <button class="button primary w-full lg:w-fit">Update Profile</button>
            </div>
        </div>
    </main>

    <!-- <Tabmanager
        heading="My Advert"
        :tabs="store.profiletabs"
        >
        <Ad v-for="ad in [...store.ads.active, ...store.ads.closed, ...store.ads.review]" :key="ad.id" :details="ad"/>
    </Tabmanager> -->
</template>
