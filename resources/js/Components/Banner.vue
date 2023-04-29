<script>
import { Link } from '@inertiajs/vue3';
export default{
    components:{
        Link
    },
    data(){
        return{
            banners: [
                {
                   image: 'banner.png',
                   link: '#'
                },
                {
                   image: 'banner.png',
                   link: '#'
                },
                {
                   image: 'banner.png',
                   link: '#'
                },
            ],
            currentSlide: 0
        }
    },
    methods:{
        prevSlide(){
            this.currentSlide = this.currentSlide === 0 ? this.banners.length - 1 : this.currentSlide - 1;
        },
        nextSlide(){
            this.currentSlide = this.currentSlide === this.banners.length - 1 ? 0 : this.currentSlide + 1;
        }
    },
    mounted(){
        setInterval(this.nextSlide,5000);
    }
}
</script>

<template>
    <section class="overflow-hidden relative">
        <div :style="`transform: translateX(-${currentSlide * 100}%);`"
            class="h-full flex transition-transform ease-out duration-1000">
            <div
                v-for="(banner, key) in banners"
                :style="`background-image: url('/images/${banner.image}');`"
                class="relative flex-shrink-0 rounded-lg inset-0 bg-cover bg-center bg-no-repeat w-full h-full text-white flex items-center justify-center text-5xl"
                >
                <Link class="text-white text-lg font-medium bg-transparent absolute bottom-4 right-6 px-5 py-1 border-[1.5px] border-[#5050F5] shadow-md shadow-[#1895B0] rounded-lg select-none"
                    :href="banner.link">
                    Buy on
                    <span class="text-[#F01010]/80">i</span>
                    <span class="text-[#1410F0]/80">l</span>
                    <span class="text-[#DEF649]">o</span>
                    <span class="text-[#26B94F]">l</span>
                    <span class="text-[#DEF649]">o</span>
                </Link>
            </div>
        </div>
        <div class="absolute bottom-3 left-5 flex gap-1">
            <div @click="currentSlide = key"
                v-for="(banner, key) in banners"
                :class="key == currentSlide ? 'bg-[#5050F5]' : ''"
                class="dot w-2 h-2 rounded-full border border-[#96969f] cursor-pointer">
            </div>
        </div>
    </section>
</template>
