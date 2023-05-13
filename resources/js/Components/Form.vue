<script>
import { Link, router } from '@inertiajs/vue3';
import { store } from '../store.js';
import Passwordinput from './Passwordinput.vue';
import Alert from './Alert.vue';
export default{
    components:{
        Link,
        Passwordinput,
        Alert
    },
    data(){
        return{
            store,
            checked: false,
            form: {
                emailorphone: '',
                email: '',
                firstname: '',
                lastname: '',
                phone: '',
                password: '',
                new_password: '',
                password_confirm: '',
                otp: '',
            },
            otpSent: false,
            processing: false,
            errors: {}
        }
    },
    methods:{
        register(){
            if(!this.checked){
                store.setAlertMessage('Please agreed to our terms','error');
            }
            else{
                this.processing = true;
                router.post('/register', this.form,
                {
                    onSuccess: (res) => {
                        this.form.firstname = '';
                        this.form.lastname = '';
                        this.form.email = '';
                        this.form.phone = '';
                        this.form.password = '';
                        this.form.password_confirm = '';
                        this.checked = false;
                        this.processing = false;
                        store.setAlertMessage('Account has been created!','success');
                        store.toggleFormTab();
                    },
                    onError: (err) => {
                        this.errors = err;
                        this.password = '';
                        this.password_confirm = '';
                        this.processing = false;
                    },
                });
            }
        },
        signin(){
            this.processing = true;
            router.post('/login', this.form,
            {
                onSuccess: (res) => {
                    this.form.emailorphone = '';
                    this.form.password = '';
                    this.processing = false;
                    store.setAlertMessage('Login successful!','success');
                    store.toggleFormTab();
                },
                onError: (err) => {
                    let msg;
                    this.form.password = '';
                    this.processing = false;
                    msg = err?.phone ? err?.phone : err?.email;
                    store.setAlertMessage(`${msg}!`,'error');
                },
            }
            );
        },
    },
    mounted(){
    }
}
</script>

<template>
    <Alert v-for="(message, id, index) in store.alertMessage" :key="id"
        :message="message"
        :index="index"
    />
    <section :class="store.showFormTab ? 'flex' : 'hidden'"
        class="fixed top-0 left-0 w-screen h-screen bg-black/50 z-50 flex-col justify-center items-center select-none">

        <!-- Options -->
        <div v-show="store.formscreen === 'options'"
            class="w-11/12 min-h-[300px] md:w-6/12 lg:w-4/12 xl:w-3/12 p-4 bg-white rounded-lg"
            >
            <div class="flex justify-between">
                <p class="font-medium text-sm text-black/90 lg:text-lg mx-4 mt-4 mb-6 self-center">{{ store.formaction === 'signin' ? 'Sign in' : 'Register' }}</p>
                <div @click="store.toggleFormTab()"
                    class="w-8 h-8 rounded-full flex self-start justify-center items-center lg:hover:bg-slate-50 lg:cursor-pointer">
                    <i class='bx bx-x text-2xl select-none pointer-events-none text-black/50'></i>
                </div>
            </div>
            <div class="flex justify-center gap-2">
                <button class="w-6/12 lg:w-5/12  rounded-lg border py-2 flex justify-center items-center gap-2 lg:cursor-pointer font-medium">
                    <i class='bx bxl-google text-lg'></i>
                    <span>Google</span>
                </button>
                <button class="w-6/12 lg:w-5/12 rounded-lg border py-2 flex justify-center items-center gap-2 lg:cursor-pointer font-medium bg-[#0B4294]/75 text-white">
                    <i class='bx bxl-facebook text-lg'></i>
                    <span>Facebook</span>
                </button>
            </div>
            <div class="flex justify-center my-4">
                <button @click="store.setFormScreen('signin')"
                    v-if="store.formaction === 'signin'"
                    class="w-full lg:w-[calc(84%+8px)] rounded-lg border py-3 bg-[#1895B0] text-white font-medium text-sm"
                    >
                    Email or Phone
                </button>
                <button @click="store.setFormScreen('register')"
                    v-else
                    class="w-full lg:w-[calc(84%+8px)] rounded-lg border py-3 bg-[#1895B0] text-white font-medium text-sm"
                    >
                    Register via email or phone
                </button>
            </div>
            <div class="flex justify-center items-center mb-4">
                <label>
                    <span class="text-sm">
                        {{ store.formaction === 'signin' ? 'Don\'t have an account?' : 'Already have an account?' }}
                        <Link v-if="store.formaction === 'signin'" @click="store.setFormAction('register')"
                            href="#"
                            class="font-semibold text-[#1895B0] text-sm"
                            >
                            Register
                        </Link>
                        <Link v-else @click="store.setFormAction('signin')"
                            href="#"
                            class="font-semibold text-[#1895B0] text-sm"
                            >
                            Sign in
                        </Link>
                    </span>
                </label>
            </div>
            <div class="text-xs text-center">
                <span>By continuing you agree to the
                    <Link href="#" class="font-semibold">Policy and Rules</Link>
                </span>
            </div>
        </div>

        <!-- Sign in and Register screen -->
        <div v-show="store.formscreen !== 'options'"
            class="w-11/12 min-h-[200px] md:w-6/12 lg:w-4/12 xl:w-3/12 p-4 bg-white rounded-lg"
            >
            <!-- Sign in form -->
            <section v-show="store.formscreen === 'signin'">
                <div class="flex justify-between mx-4 mt-4 mb-4">
                    <p class="font-medium text-sm lg:text-lg text-black/70 self-center">Sign in via email or phone</p>
                    <div @click="store.toggleFormTab()"
                        class="w-8 h-8 rounded-full flex self-start justify-center items-center lg:hover:bg-slate-100 lg:cursor-pointer">
                        <i class='bx bx-x text-2xl select-none pointer-events-none text-black/50'></i>
                    </div>
                </div>
                <section class="p-4">
                    <div class="border mb-4 p-2 rounded-lg">
                        <input v-model="form.emailorphone" class="w-full h-full outline-none pl-1 text-sm" type="text" placeholder="Email or phone"/>
                    </div>
                    <Passwordinput @keyup.enter="signin" v-model="form.password" placeholder="Password"/>
                    <div class="mb-2 text-right">
                        <Link @click="store.setFormScreen('forgot')"
                            href="#"
                            class="text-[#1895B0] text-xs font-medium"
                            >
                            Forgot Password?
                        </Link>
                    </div>
                    <div class="mb-2">
                        <button @click="signin"
                            :disabled="processing"
                            class="w-full lg:w-full rounded-lg border py-3 bg-[#1895B0] hover:bg-[#1895B0]/70 disabled:bg-[#1895B0]/50 outline-none text-white font-medium text-sm"
                            >
                            Sign in
                        </button>
                    </div>
                    <div class="flex justify-center items-center mb-4">
                        <label>
                            <span class="text-sm">
                                Don't have an account?
                                <button @click="store.setFormScreen('register')"
                                    class="font-semibold text-[#1895B0] text-sm"
                                    >
                                    Register
                                </button>
                            </span>
                        </label>
                    </div>
                    <div class="flex justify-center gap-2">
                        <button class="w-6/12 lg:w-5/12  rounded-lg border py-2 flex justify-center items-center gap-2 lg:cursor-pointer font-medium">
                            <i class='bx bxl-google text-lg'></i>
                            <span>Google</span>
                        </button>
                        <button class="w-6/12 lg:w-5/12 rounded-lg border py-2 flex justify-center items-center gap-2 lg:cursor-pointer font-medium bg-[#0B4294]/75 text-white">
                            <i class='bx bxl-facebook text-lg'></i>
                            <span>Facebook</span>
                        </button>
                    </div>
                </section>
            </section>

            <!-- Register form -->
            <section v-show="store.formscreen === 'register'">
                <div class="flex justify-between m-4">
                    <p class="font-medium text-sm lg:text-lg text-black/70 self-center">Register with email and phone</p>
                    <div @click="store.toggleFormTab()"
                        class="w-8 h-8 rounded-full flex self-start justify-center items-center lg:hover:bg-slate-50 lg:cursor-pointer">
                        <i class='bx bx-x text-2xl select-none pointer-events-none text-black/50'></i>
                    </div>
                </div>
                <section class="p-4">
                    <div class="border mb-2 p-2 rounded-lg">
                        <input v-model="form.email" class="w-full h-full outline-none pl-1 text-sm" type="email" placeholder="Email*"/>
                        <span v-if="errors && errors.email" class="text-xs text-red-400">{{ errors.email }}</span>
                    </div>
                    <div class="border mb-2 p-2 rounded-lg">
                        <input v-model="form.firstname" class="w-full h-full outline-none pl-1 text-sm" type="text" placeholder="First name*"/>
                        <span v-if="errors && errors.firstname" class="text-xs text-red-400">{{ errors.firstname }}</span>
                    </div>
                    <div class="border mb-2 p-2 rounded-lg">
                        <input v-model="form.lastname" class="w-full h-full outline-none pl-1 text-sm" type="text" placeholder="Last name*"/>
                        <span v-if="errors && errors.lastname" class="text-xs text-red-400">{{ errors.lastname }}</span>
                    </div>
                    <div class="border mb-2 p-2 rounded-lg">
                        <input v-model="form.phone" class="w-full h-full outline-none pl-1 text-sm" type="text" placeholder="Phone number*"/>
                        <span v-if="errors && errors.phone" class="text-xs text-red-400">{{ errors.phone }}</span>
                    </div>
                    <Passwordinput :error="errors?.password" v-model="form.password" placeholder="Password*"/>
                    <Passwordinput :error="errors?.password_confirm" v-model="form.password_confirm" placeholder="Retype password*"/>
                    <div class="my-4">
                        <label class="flex items-center" for="agreed">
                            <input class="mr-2" v-model="checked" type="checkbox" id="agreed"/>
                            <span class="text-xs">I agree with Terms and Conditions.</span>
                        </label>
                    </div>
                    <div class="mb-2">
                        <button @click="register"
                            :disabled="processing"
                            class="w-full lg:w-full rounded-lg border py-3 bg-[#1895B0] hover:bg-[#1895B0]/70 disabled:bg-[#1895B0]/50 outline-none text-white font-medium text-sm"
                            >
                            Register
                        </button>
                    </div>
                    <div class="flex justify-center items-center mb-4">
                        <label>
                            <span class="text-sm">
                                Already have an account?
                                <button @click="store.setFormScreen('signin')"
                                    class="font-semibold text-[#1895B0] text-sm"
                                    >
                                    Sign in
                                </button>
                            </span>
                        </label>
                    </div>
                    <div class="flex justify-center gap-2">
                        <button class="w-6/12 lg:w-5/12  rounded-lg border py-2 flex justify-center items-center gap-2 lg:cursor-pointer font-medium">
                            <i class='bx bxl-google text-lg'></i>
                            <span>Google</span>
                        </button>
                        <button class="w-6/12 lg:w-5/12 rounded-lg border py-2 flex justify-center items-center gap-2 lg:cursor-pointer font-medium bg-[#0B4294]/75 text-white">
                            <i class='bx bxl-facebook text-lg'></i>
                            <span>Facebook</span>
                        </button>
                    </div>
                </section>
            </section>

            <!-- Password Reset form -->
            <section v-show="store.formscreen === 'forgot'">
                <div class="flex justify-between mx-4 mt-2 mb-1">
                    <p class="font-medium text-sm text-black/70 lg:text-lg self-center">Password Reset</p>
                    <div @click="store.toggleFormTab()"
                        class="w-8 h-8 rounded-full flex self-start justify-center items-center lg:hover:bg-slate-50 lg:cursor-pointer">
                        <i class='bx bx-x text-2xl select-none pointer-events-none text-black/50'></i>
                    </div>
                </div>
                <section v-if="!otpSent" class="p-4">
                    <div class="mb-2">
                        <p class="text-sm font-medium text-black/80">Enter your email</p>
                    </div>
                    <div class="border mb-2 p-2 rounded-lg">
                        <input class="w-full h-full outline-none pl-1 text-sm" v-model="form.email" type="email" placeholder="..."/>
                    </div>
                    <div class="mb-2">
                        <button :disabled="!form.email"
                            class="w-full lg:w-full rounded-lg border py-3 bg-[#1895B0] disabled:bg-[#1895B0]/50 text-white font-medium text-sm"
                            >
                            Submit
                        </button>
                    </div>
                </section>


                <section v-else class="p-4">
                    <div class="mb-2">
                        <p class="text-xs font-medium text-black/70">An OTP has been sent to your email address</p>
                    </div>
                    <div class="border mb-2 p-2 rounded-lg">
                        <input class="w-full h-full outline-none pl-1 text-sm" type="text" placeholder="OTP"/>
                    </div>
                    <Passwordinput v-model="form.new_password" placeholder="New password"/>
                    <Passwordinput v-model="form.password_confirm" placeholder="Confirm password"/>
                    <div class="mb-2">
                        <button :disabled="!form.otp"
                            class="w-full lg:w-full rounded-lg border py-3 bg-[#1895B0] disabled:bg-[#1895B0]/50 text-white font-medium text-sm"
                            >
                            Submit
                        </button>
                    </div>
                </section>
            </section>
        </div>
    </section>
</template>
