<script>
import { Link, router } from '@inertiajs/vue3';
import { store } from '../store.js';
import Formtab from './Form.vue';
export default {
    props: {
        auth: Object
    },
    components:{
        Link,
        Formtab
    },
    data(){
        return {
            store
        }
    },
    methods:{
        goTo(page){
            router.get(page);
        }
    },
    mounted(){
    }
}
</script>

<template>
    <div
        class="w-full fixed top-0 left-0 z-10 h-[60px] bg-[#1895B0] hidden lg:flex justify-between items-center px-8"
        >
        <div class="flex items-center">
            <Link href="/">
                <img width="80" src="/images/logo.png" alt="logo"/>
            </Link>
        </div>
        <div class="flex items-center gap-4">
            <slot/>
            <button @click="$page.props.auth?.user ? goTo('/postad') : store.toggleFormTab('signin')"
                class="h-[35px] flex items-center bg-[#C92125]/80 text-white font-medium text-sm uppercase px-4 rounded-2xl shadow-md shadow-[#134854] hover:bg-[#C92125]/90"
                >
                Sell
            </button>
        </div>
        <Formtab />
    </div>
</template>
