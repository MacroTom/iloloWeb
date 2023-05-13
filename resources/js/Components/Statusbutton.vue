<script>
import { Link, router } from '@inertiajs/vue3';
export default{
    props: {
        icon: {
            type: String,
            required: true
        },
        counter: {
            type: String,
        },
        menu: {
            type: Object,
        },
        to:{
            type: String,
            default: '#'
        }
    },
    components:{
        Link
    },
    data(){
        return{
            showMenu: false
        }
    },
    methods:{
        toggleMenu(){
            this.showMenu = !this.showMenu;
        },
        goTo(){
            router.get(this.to);
        }
    }
}
</script>

<template>
    <section>
        <div @click.prevent="menu ? toggleMenu() : goTo()"
            class="rounded-full relative flex justify-center items-center gap-4 w-8 h-8 bg-[#d9d9d9] hover:bg-[#d9d9d9]/90 text-slate-600 lg:cursor-pointer">
            <span v-show="counter"
                class="w-4 h-4 flex absolute -bottom-1 -right-1 bg-[#F01010]/80 justify-center items-center text-white text-xs rounded-full"
                >
                {{ counter }}
            </span>
            <i :class="icon" class='bx text-xl text-black/60'></i>
        </div>
        <div v-if="menu"
            @click="toggleMenu()"
            :class="showMenu ? 'block' : 'hidden'"
            class="bg-black/30 w-screen h-screen absolute top-0 left-0 z-50 flex justify-center items-center">
            <ul class="w-11/12 min-h-[100px] md:w-5/12 lg:w-3/12 p-4 bg-white rounded-lg">
                <li class="w-full text-black/70 mb-3 font-medium text-lg border-b pb-1">{{ menu?.title ? menu.title : 'Menu' }}</li>
                <template v-if="'menuitems' in menu">
                    <li v-for="(item, key) in menu.menuitems" :key="key"
                        class="h-[30px] lg:h-[40px] w-full mb-2"
                        >
                        <Link :href="item?.href"
                            :method="item?.method ? item.method : 'get'"
                            :as="item?.method && item.method.toLowerCase() === 'post' ? 'button' : 'a'"
                            class="w-full h-full flex items-center"
                            >
                            <div class="w-[30px] lg:w-[40px] h-full flex justify-center items-center bg-slate-100 rounded-lg">
                                <i :class="item?.icon ? item.icon : 'bx-question-mark'"
                                    class="bx text-lg text-black/90"></i>
                            </div>
                            <span class="w-[calc(100%-40px)] h-full flex items-center ml-2 px-2 rounded-lg text-sm text-black/90 hover:bg-slate-100 tracking-widest"
                                >
                                {{ item?.name ? item.name : 'Menu item' }}
                            </span>
                        </Link>
                    </li>
                </template>
                <template v-else>
                    <li
                        class="min-h-[30px] lg:min-h-[40px] w-full text-center text-sm text-slate-500 flex flex-col items-center select-none">
                        <span><i class='bx bx-sad text-3xl'></i></span>
                        <span>No menu items added yet..</span>.
                    </li>
                </template>
            </ul>
        </div>
    </section>
</template>
