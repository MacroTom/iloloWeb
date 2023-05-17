<script>
// import '@/assets/styles.scss';
import Passwordinput from '../Components/Passwordinput.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import Toast from 'primevue/toast';
export default{
    components:{
        Head,
        Passwordinput,
        Link,
        Toast
    },
    data(){
        return{
            form: {
                email: null,
                password: null,
                new_password: null,
                password_confirm: null,
                otp: null
            },
            processing: false,
            formScreen: 'signin',
            otpSent: false
        }
    },
    methods:{
        signin(){
            this.processing = true;
            router.post('/admin/signin', this.form,
            {
                onSuccess: (res) => {
                    this.processing = false;
                },
                onError: (err) => {
                    this.processing = false;
                },
            },
            );
        },
        sendotp(){
            this.processing = true;
            router.post('/sendotp', this.form,
            {
                onSuccess: (res) => {
                    this.processing = false;
                    this.otpSent = true;
                },
                onError: (err) => {
                    this.processing = false;
                },
            },
            );
        },
        resetPassword(){
            this.processing = true;
            router.post('/resetpassword', this.form,
            {
                onSuccess: (res) => {
                    this.processing = false;
                    this.formScreen = 'signin';
                },
                onError: (err) => {
                    this.processing = false;
                },
            },

            );
        }
    },
}
</script>

<template>
    <Head>
        <title>Login</title>
    </Head>
    <main class="w-full h-screen flex items-center justify-center bg-[#eff3f8]">
        <Toast/>
        <section v-if="formScreen === 'signin'" class="w-11/12 px-4 py-6 bg-white rounded-lg shadow md:w-6/12 lg:w-4/12 xl:w-3/12">
            <div class="flex justify-center mb-6">
                <Link href="/">
                    <img src="/images/logo-green.png" width="80" alt="logo">
                </Link>
            </div>
            <div class="mt-4 text-center">
                <p class="text-sm font-semibold lg:text-lg text-black/70">Sign in to continue</p>
            </div>
            <div v-if="$page.props?.message"
                class="mt-1 text-center">
                <span
                    class="text-xs text-[#1895B0] flex items-center justify-center">
                    <i class='mr-1 text-xl bx bxs-info-circle'></i>
                    <span class="text-sm">{{$page.props?.message}}</span>
                </span>
            </div>
            <div v-if="$page.props.errors?.message"
                class="mt-1 text-center">
                <span
                    class="flex items-center justify-center text-xs text-red-500">
                    <i class='mr-1 text-xl bx bxs-info-circle'></i>
                    <span class="text-sm">{{$page.props.errors?.message}}</span>
                </span>
            </div>
            <section class="p-4">
                <div class="p-2 mb-4 border rounded-lg">
                    <input v-model="form.email" class="w-full h-full pl-1 text-sm outline-none" type="text" placeholder="Email"/>
                </div>
                <Passwordinput @keyup.enter="signin" v-model="form.password" placeholder="Password"/>
                <div class="flex justify-between my-4 text-right">
                    <label for="remember" class="flex items-center text-xs font-medium">
                        <input type="checkbox" id="remember">
                        <span class="ml-1 text-black/70 lg:cursor-pointer">Remember me</span>
                    </label>
                    <button @click="formScreen = 'forgot'"
                        href="#"
                        class="text-[#1895B0] text-xs font-medium"
                        >
                        Forgot Password?
                    </button>
                </div>
                <div class="mb-2">
                    <button @click="signin"
                        :disabled="processing"
                        class="w-full lg:w-full rounded-lg border py-3 bg-[#1895B0] hover:bg-[#1895B0]/70 disabled:bg-[#1895B0]/50 outline-none text-white font-medium text-sm"
                        >
                        Sign in
                    </button>
                </div>
            </section>
        </section>

        <section v-else class="w-11/12 px-4 py-6 bg-white rounded-lg shadow md:w-6/12 lg:w-4/12 xl:w-3/12">
            <div class="flex justify-center mb-6">
                <Link href="/">
                    <img src="/images/logo-green.png" width="80" alt="logo">
                </Link>
            </div>
            <div class="mt-2 text-center">
                <p class="self-center text-sm font-medium text-black/70 lg:text-lg">Password Reset</p>
            </div>
            <div v-if="$page.props?.message"
                class="mt-1 text-center">
                <span
                    class="text-xs text-[#1895B0] flex items-center justify-center">
                    <i class='mr-1 text-xl bx bxs-info-circle'></i>
                    <span class="text-sm">{{$page.props?.message}}</span>
                </span>
            </div>
            <div v-if="$page.props.errors?.message"
                class="mt-1 text-center">
                <span
                    class="flex items-center justify-center text-xs text-red-500">
                    <i class='mr-1 text-xl bx bxs-info-circle'></i>
                    <span class="text-sm">{{$page.props.errors?.message}}</span>
                </span>
            </div>
            <section v-if="!otpSent" class="p-4">
                <div class="p-2 mb-2 border rounded-lg">
                    <input class="w-full h-full pl-1 text-sm outline-none" v-model="form.email" type="email" placeholder="Email"/>
                </div>
                <div class="mb-2">
                    <button :disabled="!form.email || processing"
                        @click="sendotp"
                        class="w-full lg:w-full rounded-lg border py-3 bg-[#1895B0] disabled:bg-[#1895B0]/50 text-white font-medium text-sm"
                        >
                        Submit
                    </button>
                </div>
            </section>


            <section v-else class="p-4">
                <div class="mb-2 text-center">
                    <p class="text-xs font-medium text-black/60">An OTP has been sent to your email!</p>
                </div>
                <div v-if="$page.props?.message"
                    class="mt-1 text-center">
                    <span
                        class="text-xs text-[#1895B0] flex items-center justify-center">
                        <i class='mr-1 text-xl bx bxs-info-circle'></i>
                        <span class="text-sm">{{$page.props?.message}}</span>
                    </span>
                </div>
                <div v-if="$page.props.errors?.message"
                    class="mt-1 text-center">
                    <span
                        class="flex items-center justify-center text-xs text-red-500">
                        <i class='mr-1 text-xl bx bxs-info-circle'></i>
                        <span class="text-sm">{{$page.props.errors?.message}}</span>
                    </span>
                </div>
                <div class="p-2 mb-2 border rounded-lg">
                    <input class="w-full h-full pl-1 text-sm outline-none" v-model="form.otp" type="text" placeholder="OTP"/>
                </div>
                <Passwordinput v-model="form.new_password" placeholder="New password"/>
                <Passwordinput v-model="form.password_confirm" placeholder="Confirm password"/>
                <div class="mb-2">
                    <button :disabled="!form.otp || processing"
                        @click="resetPassword"
                        class="w-full lg:w-full rounded-lg border py-3 bg-[#1895B0] disabled:bg-[#1895B0]/50 text-white font-medium text-sm"
                        >
                        Submit
                    </button>
                </div>
            </section>
        </section>
    </main>
</template>
