<script>
import { Link, router } from '@inertiajs/vue3';
import { store } from '../store.js';
import Formtab from './Form.vue';
import Statusbutton from './Statusbutton.vue';
export default {
    props:{
        back: String
    },
    components:{
        Link,
        Formtab,
        Statusbutton
    },
    data(){
        return {
            store,
        }
    },
    methods:{
        goto(to){
            router.get(to);
        }
    },
    mounted(){
    }
}
</script>

<template>
    <div
        class="w-full min-h-[40px] fixed top-0 left-0 z-10 bg-[#1895B0] flex lg:hidden justify-between items-center px-3"
        >
        <div v-if="!back" @click="store.toggleDrawer()"
            class="flex justify-center items-center text-[#d9d9d9] select-none">
            <i class='bx bx-menu text-3xl font-normal'></i>
        </div>
        <div v-else @click="goto(back)"
            class="flex justify-center items-center text-[#d9d9d9] select-none">
            <i class='bx bx-chevron-left text-3xl font-normal'></i>
        </div>
        <div class="flex items-center">
            <Link href="/">
                <img width="80" src="/images/logo.png" alt="logo"/>
            </Link>
        </div>
        <Statusbutton @click="!$page.props.auth.user && store.toggleFormTab()"
            icon="bx-user"
            :menu="$page.props.auth.user ? store.menu : null"
            />
        <Formtab/>
    </div>
</template>
