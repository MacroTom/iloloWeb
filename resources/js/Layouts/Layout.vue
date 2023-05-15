<script>
import { Head, Link } from '@inertiajs/vue3';
import Heading from '../Components/Heading.vue';
import Bottomnavigationbar from '../Components/Bottomnavigationbar.vue';
import { store } from '../store.js';
import Tabmanager from '../Components/Tabmanager.vue';
export default{
    props:{
        auth: Object
    },
    components:{
    Head,
    Link,
    Heading,
    Bottomnavigationbar,
    Tabmanager,
},
    data(){
        return{
            store,
        }
    },
    mounted(){
        const body = document.body;
        var classval;
        for (let index = 0; index < body.classList.length; index++) {
            classval = body.classList[index];
            if(classval.includes('bg-')){
                body.classList.remove(classval);
            }
        }
        body.classList.add('bg-[#C7D1D3]');
    },
    methods:{
    }
}
</script>

<template>
    <Heading/>
    <section class="relative top-[40px] lg:top-[60px] flex items-start justify-center gap-x-6 lg:gap-x-9 px-2 pt-6 pb-16 lg:p-8">
        <aside @click="store.device.screen === 'mobile' && store.toggleDrawer()"
            :class="!store.isDrawerOpen ? '-left-full' : 'left-0'"
            class="w-full lg:w-4/12 xl:w-3/12 h-full lg:h-full fixed top-0 z-10 lg:z-0 lg:static bg-black/10 lg:bg-transparent transition-[left] ease-out duration-300"
            >
            <div class="w-10/12 lg:w-full bg-[#1895B0]/90 lg:bg-white h-full lg:rounded-lg lg:shadow lg:shadow-black/50">
                <div class="w-full bg-slate-50 pb-6 lg:bg-transparent lg:border-b-2 lg:border-[#D9D9D9]">
                    <div class="text-right p-4">
                        <Link
                            href="#">
                            <i class='bx bx-cog text-2xl text-[#4E4B4A]'></i>
                        </Link>
                    </div>
                    <div>
                        <div class="flex justify-center mb-2">
                            <img v-if="auth?.user.avatar" class="rounded-full w-[70px] h-[70px] lg:w-[90px] lg:h-[90px]"
                                :src="auth?.user.avatar"
                                alt="avatar"/>
                            <div v-else class="w-[70px] h-[70px] lg:w-[90px] lg:h-[90px] flex items-center justify-center rounded-full bg-[#D9D9D9]">
                                <i class='bx bx-user text-5xl text-[#4E4B4A]'></i>
                            </div>
                        </div>
                        <div class="flex flex-col items-center">
                            <span class="font-semibold text-lg">John Doe</span>
                            <span class="text-xs font-medium text-black/50">johndoe@gmail.com</span>
                        </div>
                    </div>
                </div>
                <div class="w-full h-full overflow-y-auto pb-6">
                    <div v-for="(option, key) in store.profileoptions" :key="key"
                        class="p-4 flex items-center select-none text-white/70 lg:text-black/70 border-b last:border-b-0"
                        >
                        <div class="w-2/12 flex justify-center items-center lg:text-black/50">
                            <i :class="option.icon"
                                class='bx text-xl pointer-events-none'></i>
                        </div>
                        <Link :class="$page.url === option.href && 'text-slate-100 lg:text-[#1895B0]'"
                            :href="option.href"
                            :as="option.method && option.method.toLowerCase() === 'get' ? 'a' : 'button'"
                            :method="option.method ? option.method : 'get'"
                            class="w-8/12 font-semibold pl-4 text-left"
                            >
                            {{ option.title }}
                        </Link>
                        <div class="w-2/12 text-sm text-center lg:text-[#1895B0] font-medium">
                            {{ option.counter !== null ? `+${option.counter}` : '' }}
                        </div>
                    </div>
                </div>
            </div>
        </aside>

        <main class="w-full lg:w-8/12 xl:w-7/12 rounded-lg bg-white shadow shadow-black/50 overflow-y-auto">
            <slot/>
        </main>
    </section>
    <Bottomnavigationbar/>
</template>
