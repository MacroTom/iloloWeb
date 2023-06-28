<script>
import Layout from '../Layouts/Layout.vue';
import Tabmanager from '../Components/Tabmanager.vue';
import {store} from '../store.js';
import Ad from '../Components/Ad.vue';
import { Head } from '@inertiajs/vue3';
import Preloader from '../Components/Preloader.vue';
import Bottomnavigationbar from '../Components/Bottomnavigationbar.vue';
import OptionPicker from '../Components/OptionPicker.vue';
import FlatButton from '../Components/FlatButton.vue';
import moment from 'moment';
export default{
    layout: Layout,
    props:{
        auth: Object,
        user: Object,
        // states: Object
    },
    components:{
        Tabmanager,
        Ad,
        Head,
        Preloader,
        Bottomnavigationbar,
        OptionPicker,
        FlatButton
    },
    data(){
        return{
            store,
            placeholder: {
                state: ''
            },
            personal: {
                email: '',
                phone: '',
                facebook_link: '',
                instagram_link: '',
                twitter_link: '',
                website_link: ''
            },
            business: {
                link: 'https://ilolo.online/user/'
            },
            loading:{
                personal: false,
                business: false
            },
            joined: ''
        }
    },
    mounted(){
        this.joined = moment(this.user?.created_at).fromNow();
        this.personal = this.user;
    },
    methods:{
        // getStates(){
        //     return this.states.map(function(state){
        //         return {
        //             state: state.state,
        //             lgas: state.lgas.map(function(lga){return{lga: lga}})
        //         }
        //     });
        // },
    }
}
</script>

<template>
    <Head>
        <title>Profile</title>
    </Head>
    <Preloader/>
    <main class="w-full lg:w-7/12 xl:w-6/12 pt-2 lg:pt-4 lg:pl-12 pb-6">
        <div class="mb-4">
            <h3 class="text-lg lg:text-2xl text-slate-700 font-Inter font-semibold mb-4">Profile settings</h3>
            <p class="text-slate-700 font-Inter">Personal</p>
        </div>
        <div class="mb-6">
            <section class="min-h-[100px] border rounded-lg mb-4 flex items-center p-4">
                <div class="flex items-center gap-x-4">
                    <div class="w-16 h-16 flex justify-center items-center">
                        <img v-if="$page.props?.auth?.user?.avatar" class="object-cover object-center w-full h-full rounded-full" :src="$page.props?.auth?.user?.avatar" alt="avatar">
                        <i v-else class='bx bx-user text-3xl text-slate-600'></i>
                    </div>
                    <div class="flex flex-col items-start gap-1">
                        <p class="font-Inter font-semibold text-sm text-slate-700">{{ $page.props?.auth?.user?.firstname }} {{ $page.props?.auth?.user?.lastname }}</p>
                        <small class="text-[10px] text-slate-500 px-2 py-1 rounded-lg border"><strong>Joined:</strong> {{ joined }}</small>
                    </div>
                </div>
            </section>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-3 mb-3">
                <div class="p-2 border rounded-lg">
                    <input class="w-full h-full pl-1 text-sm outline-none read-only:text-slate-500" v-model="personal.firstname" type="text" placeholder="Firstname"/>
                </div>
                <div class="p-2 border rounded-lg">
                    <input class="w-full h-full pl-1 text-sm outline-none" v-model="personal.lastname" type="text" placeholder="Lastname"/>
                </div>
                <div class="p-2 border rounded-lg">
                    <input class="w-full h-full pl-1 text-sm outline-none read-only:text-slate-500" v-model="personal.email" type="email" placeholder="Email" readonly/>
                </div>
                <div class="p-2 border rounded-lg">
                    <input class="w-full h-full pl-1 text-sm outline-none" v-model="personal.phone" type="text" placeholder="Phone"/>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-3 mb-3">
                <div class="p-2 border rounded-lg">
                    <input class="w-full h-full pl-1 text-sm outline-none" v-model="personal.facebook_link" type="text" placeholder="Facebook Profile Link"/>
                </div>
                <div class="p-2 border rounded-lg">
                    <input class="w-full h-full pl-1 text-sm outline-none" v-model="personal.twitter_link" type="text" placeholder="Twitter Profile Link"/>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-3 mb-3">
                <div class="p-2 border rounded-lg">
                    <input class="w-full h-full pl-1 text-sm outline-none" v-model="personal.instagram_link" type="text" placeholder="Instagram Profile Link"/>
                </div>
                <div class="p-2 border rounded-lg">
                    <input class="w-full h-full pl-1 text-sm outline-none" v-model="personal.website_link" type="text" placeholder="Website Link"/>
                </div>
            </div>
            <div class="flex lg:justify-end lg:mt-2">
                <FlatButton primary label="Update" :loading="loading.personal" class="w-full lg:w-fit"/>
            </div>
        </div>

        <div class="my-6 border-b"></div>

        <div class="mb-4">
            <p class="text-slate-700 font-Inter">Business details</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-3 mb-3">
            <div class="p-2 border rounded-lg">
                <input class="w-full h-full pl-1 text-sm outline-none read-only:text-slate-500" v-model="business.name" type="text" placeholder="Business name"/>
            </div>
            <div class="p-2 border rounded-lg">
                <input class="w-full h-full pl-1 text-sm outline-none" v-model="business.description" type="text" placeholder="About Business"/>
            </div>
        </div>
        <div class="p-2 border rounded-lg mb-4">
            <input class="w-full h-full pl-1 text-sm font-Inter outline-none read-only:text-slate-500" v-model="business.link" type="text" placeholder="ilolo link" readonly/>
        </div>
        <div class="flex lg:justify-end lg:mt-2">
            <FlatButton primary label="Update" :loading="loading.business" class="w-full lg:w-fit"/>
        </div>
    </main>

    <!-- <Tabmanager
        heading="My Advert"
        :tabs="store.profiletabs"
        >
        <Ad v-for="ad in [...store.ads.active, ...store.ads.closed, ...store.ads.review]" :key="ad.id" :details="ad"/>
    </Tabmanager> -->
</template>
