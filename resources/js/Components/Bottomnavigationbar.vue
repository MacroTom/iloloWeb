<script>
import { Link, router } from '@inertiajs/vue3';
import { store } from '../store.js';
export default{
    components:{
        Link
    },
    data(){
        return {
            store,
            position: 0
        }
    },
    methods:{
        handleScroll(e){
            let isScrolling;
            let navigation = this.$refs.navigation;
            let scrollPos = document.body.scrollTop || document.documentElement.scrollTop;

            // if(store.device.screen === 'mobile'){
            //     navigation?.classList.remove('bottom-0');
            //     navigation?.classList.add('-bottom-[60px]');
            // }

            if(scrollPos > this.position){
                if(store.device.screen === 'mobile'){
                    navigation?.classList.remove('bottom-0');
                    navigation?.classList.add('-bottom-[60px]');
                }
            }
            else{
                if(store.device.screen === 'mobile'){
                    navigation?.classList.remove('-bottom-[60px]');
                    navigation?.classList.add('bottom-0');
                }
            }

            this.position = scrollPos;

            // Clear our timeout throughout the scroll
            window.clearTimeout(isScrolling);

            // Set a timeout to run after scrolling ends
            isScrolling = setTimeout(function() {
                // Run the callback
                // if(store.device.screen === 'mobile'){
                //     navigation?.classList.remove('-bottom-[60px]');
                //     navigation?.classList.add('bottom-0');
                // }
            }, 66);
        },
        handleResize(){
            store.detectDevice();
        },
        goto(to){
            (this.$page.props.auth?.user || to === '/') ? router.get(to) : store.toggleFormTab();
        }
    },
    mounted(){
        store.detectDevice();
        window.addEventListener("resize", this.handleResize);
        window.addEventListener("scroll", this.handleScroll, false);
    }
}
</script>

<template>
    <nav ref="navigation" :class="store.isDrawerOpen ? 'hidden' : 'flex'"
        class="w-full h-[60px] lg:hidden bg-[#18849B] fixed left-0 bottom-0 transition-[bottom] duration-300 ease-in-out z-10">
        <button @click="goto('/')"
            class="flex flex-col items-center justify-center flex-1 text-white">
            <i class='text-2xl pointer-events-none bx bxs-home'></i>
            <span class="text-xs font-light select-none">Home</span>
        </button>
        <button @click="goto('#')"
            class="flex flex-col items-center justify-center flex-1 text-white">
            <i class='text-2xl pointer-events-none bx bxs-bookmark'></i>
            <span class="text-xs font-light select-none">Bookmark</span>
        </button>
        <button @click="goto('/postad')"
            class="flex flex-col items-center justify-center flex-1 text-white">
            <i class='text-2xl pointer-events-none bx bxs-plus-square'></i>
            <span class="text-xs font-light select-none">Sell</span>
        </button>
        <button @click="goto('/profile/messages')"
            class="flex flex-col items-center justify-center flex-1 text-white">
            <i class='text-2xl pointer-events-none bx bxs-message-dots'></i>
            <span class="text-xs font-light select-none">Message</span>
        </button>
        <button @click="goto('/profile')"
            class="flex flex-col items-center justify-center flex-1 text-white">
            <i class='text-2xl pointer-events-none bx bxs-user-circle'></i>
            <span class="text-xs font-light select-none">Profile</span>
        </button>
    </nav>
</template>
