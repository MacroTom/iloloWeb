<script>
import Layout from '../Layouts/Layout.vue';
import Tabmanager from '../Components/Tabmanager.vue';
import {store} from '../store.js';
import Ad from '../Components/Ad.vue';
import { Head, router } from '@inertiajs/vue3';
import Preloader from '../Components/Preloader.vue';
import Bottomnavigationbar from '../Components/Bottomnavigationbar.vue';
import OptionPicker from '../Components/OptionPicker.vue';
import FlatButton from '../Components/FlatButton.vue';
import SnackBar from '../Components/SnackBar.vue';
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
        FlatButton,
        SnackBar
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
            form:{
                avatar: '',
                firstname: '',
                lastname: '',
                email: '',
                phone: '',
                facebook_link: '',
                instagram_link: '',
                twitter_link: '',
                website_link: '',
                business_name: '',
                about_business: '',
            },
            joined: '',
            uploadingAvatar: false,
        }
    },
    mounted(){
        this.joined = moment(this.user?.created_at).fromNow();
        this.form = this.user;
    },
    methods:{
        uploadPhoto(evt){
            this.uploadingAvatar = true;
            let file = evt.target.files[0];
            this.store.snackbar.add({
                message: "Uploading photos!",
                severity: "info"
            });
            const url = "https://api.cloudinary.com/v1_1/daye98q4y/image/upload";
            const formData = new FormData();
            formData.append("file", file);
            formData.append("upload_preset", "ybqvdxtk");
            axios.create().post(url, formData)
            .then((res)=>{
                this.form.avatar = res.data.secure_url;
                this.updateAvatar();
            })
            .catch((err)=>{
                this.uploadingAvatar = false;
                this.store.snackbar.add({
                    message: "Could not upload photo!",
                    severity: "warning"
                });
            });
        },
        updateAvatar(){
            router.post('/profile/uploadavatar', this.form,
                {
                    preserveScroll: true,
                    preserveState: true,
                    onSuccess: (res)=>{
                        this.uploadingAvatar = false;
                        this.store.snackbar.add({
                            message: "Avatar updated!",
                            severity: "success"
                        });
                    },
                    onError: (err)=>{
                        this.uploadingAvatar = false;
                        this.store.snackbar.add({
                            message: "Could not update avatar!",
                            severity: "warning"
                        });
                    }
                }
            );
        },
        updatePersonal(){
            this.loading.personal = true;
            router.post('/profile/updatepersonal', this.form,
                {
                    preserveScroll: true,
                    preserveState: true,
                    onSuccess: (res)=>{
                        this.loading.personal = false;
                        store.snackbar.add({
                            message: "Personal details updated!",
                            severity: "success"
                        });
                    },
                    onError: (err)=>{
                        this.loading.personal = false;
                        store.snackbar.add({
                            message: "Could not update personal details!",
                            severity: "warning"
                        });
                    }
                }
            );
        },
        updateBusiness(){
            this.loading.business = true;
            router.post('/profile/updatebusiness', this.form,
                {
                    preserveScroll: true,
                    preserveState: true,
                    onSuccess: (res)=>{
                        this.loading.business = false;
                        store.snackbar.add({
                            message: "Business details updated!",
                            severity: "success"
                        });
                    },
                    onError: (err)=>{
                        this.loading.business = false;
                        store.snackbar.add({
                            message: "Could not update business details!",
                            severity: "warning"
                        });
                    }
                }
            );
        },
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
                    <div class="w-16 h-16 flex justify-center items-center relative">
                        <img v-if="$page.props?.auth?.user?.avatar" class="object-cover object-center w-full h-full rounded-full" :src="$page.props?.auth?.user?.avatar" alt="avatar">
                        <i v-else class='bx bx-user text-3xl text-slate-600'></i>
                        <label v-if="!uploadingAvatar" for="file" class="w-6 h-6 flex justify-center items-center bg-[#1895B0] text-white rounded-full cursor-pointer absolute bottom-0 right-0 z-10">
                            <i class='bx bx-pencil text-sm pointer-events-none'></i>
                        </label>
                        <label v-else class="w-6 h-6 flex justify-center items-center bg-[#1895B0] text-white rounded-full cursor-pointer absolute bottom-0 right-0 z-10">
                            <i class='bx bx-loader bx-spin text-sm pointer-events-none'></i>
                        </label>
                        <input class="hidden" id="file" type="file" accept="image/*" @change="uploadPhoto($event)"/>
                    </div>
                    <div class="flex flex-col items-start gap-1">
                        <p class="font-Inter font-semibold text-sm text-slate-700">{{ $page.props?.auth?.user?.firstname }} {{ $page.props?.auth?.user?.lastname }}</p>
                        <small class="text-[10px] text-slate-500 px-2 py-1 rounded-lg border"><strong>Joined:</strong> {{ joined }}</small>
                    </div>
                </div>
            </section>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-3 mb-3">
                <div>
                    <label class="text-xs text-slate-700 font-Inter mb-1">Firstname</label>
                    <div class="p-2 border rounded-lg">
                        <input class="w-full h-full pl-1 text-sm outline-none read-only:text-slate-500" v-model="form.firstname" type="text" placeholder="Firstname"/>
                    </div>
                </div>
                <div>
                    <label class="text-xs text-slate-700 font-Inter mb-1">Lastname</label>
                    <div class="p-2 border rounded-lg">
                        <input class="w-full h-full pl-1 text-sm outline-none" v-model="form.lastname" type="text" placeholder="Lastname"/>
                    </div>
                </div>
                <div>
                    <label class="text-xs text-slate-700 font-Inter mb-1">Email</label>
                    <div class="p-2 border rounded-lg">
                        <input class="w-full h-full pl-1 text-sm outline-none read-only:text-slate-500" v-model="form.email" type="email" placeholder="Email" readonly/>
                    </div>
                </div>
                <div>
                    <label class="text-xs text-slate-700 font-Inter mb-1">Phone</label>
                    <div class="p-2 border rounded-lg">
                        <input class="w-full h-full pl-1 text-sm outline-none" v-model="form.phone" type="text" placeholder="Phone"/>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-3 mb-3">
                <div>
                    <label class="text-xs text-slate-700 font-Inter mb-1">Facebook link</label>
                    <div class="p-2 border rounded-lg">
                        <input class="w-full h-full pl-1 text-sm outline-none" v-model="form.facebook_link" type="text" placeholder="Facebook Profile Link"/>
                    </div>
                </div>
                <div>
                    <label class="text-xs text-slate-700 font-Inter mb-1">Twitter link</label>
                    <div class="p-2 border rounded-lg">
                        <input class="w-full h-full pl-1 text-sm outline-none" v-model="form.twitter_link" type="text" placeholder="Twitter Profile Link"/>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-3 mb-3">
                <div>
                    <label class="text-xs text-slate-700 font-Inter mb-1">Instagram link</label>
                    <div class="p-2 border rounded-lg">
                        <input class="w-full h-full pl-1 text-sm outline-none" v-model="form.instagram_link" type="text" placeholder="Instagram Profile Link"/>
                    </div>
                </div>
                <div>
                    <label class="text-xs text-slate-700 font-Inter mb-1">Website link</label>
                    <div class="p-2 border rounded-lg">
                        <input class="w-full h-full pl-1 text-sm outline-none" v-model="form.website_link" type="text" placeholder="Website Link"/>
                    </div>
                </div>
            </div>
            <div class="flex justify-end lg:mt-2">
                <FlatButton @click="updatePersonal" primary label="Update" :loading="loading.personal"/>
            </div>
        </div>

        <div class="my-6 border-b"></div>

        <div class="mb-4">
            <p class="text-slate-700 font-Inter">Business details</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-3 mb-3">
            <div>
                <label class="text-xs text-slate-700 font-Inter mb-1">Business name</label>
                <div class="p-2 border rounded-lg">
                    <input class="w-full h-full pl-1 text-sm outline-none read-only:text-slate-500" v-model="form.business_name" type="text" placeholder="Business name"/>
                </div>
            </div>
            <div>
                <label class="text-xs text-slate-700 font-Inter mb-1">About Business</label>
                <div class="p-2 border rounded-lg">
                    <input class="w-full h-full pl-1 text-sm outline-none" v-model="form.about_business" type="text" placeholder="About Business"/>
                </div>
            </div>
        </div>
        <div>
            <label class="text-xs text-slate-700 font-Inter mb-1">Business link</label>
            <div class="p-2 border rounded-lg mb-4">
                <input class="w-full h-full pl-1 text-sm outline-none read-only:text-slate-500" v-model="business.link" type="text" placeholder="ilolo link" readonly/>
            </div>
        </div>
        <div class="flex justify-end lg:mt-2">
            <FlatButton @click="updateBusiness" primary label="Update" :loading="loading.business"/>
        </div>
    </main>

    <!-- <Tabmanager
        heading="My Advert"
        :tabs="store.profiletabs"
        >
        <Ad v-for="ad in [...store.ads.active, ...store.ads.closed, ...store.ads.review]" :key="ad.id" :details="ad"/>
    </Tabmanager> -->
</template>
