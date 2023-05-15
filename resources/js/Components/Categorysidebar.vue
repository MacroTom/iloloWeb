<script>
import { store } from '../store.js';
export default {
    components:{
    },
    data(){
        return {
            store
        }
    },
    methods:{
    }
}
</script>

<template>
    <aside @click="store.toggleDrawer()"
        :class="!store.isDrawerOpen ? '-left-full' : 'left-0'"
        class="w-full lg:ml-3 lg:mt-3 h-screen transition-[left] ease-out duration-300 lg:w-4/12 lg:min-h-0 fixed z-40 lg:z-0 top-0 lg:static"
        >
        <div class="bg-[#1895B0]/90 lg:bg-white lg:shadow p-3 lg:rounded-lg w-[70%] md:w-[35%] min-h-full lg:min-h-0 lg:w-full lg:bg-[#08738A]/75">
            <div class="relative left-0 top-[100px] lg:static flex flex-col gap-1">
                <slot/>
            </div>
        </div>
    </aside>
</template>
