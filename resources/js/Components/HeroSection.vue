<script>
import '../particlesjs/particles.js';
import VueWriter from "vue-writer";
export default{
    components:{
        VueWriter
    },
    data(){
        return{
        }
    },
    mounted(){
        particlesJS.load('hero', 'particles.json', function() {
            // console.log('callback - particles.js config loaded');
        });
    }
}
</script>

<style scoped>
#hero{
    background: linear-gradient(257.51deg,#f2fcfe 44.07%,#deeff3);
    @apply h-[calc(50vh-60px)] lg:h-[calc(70vh-60px)] pt-[60px] relative
    /* lg:px-8 xl:px-24 */
}
#banner{
    @apply w-full flex h-full pt-[60px] absolute left-0 top-0 px-3 lg:px-8 xl:px-28 overflow-hidden
}
.image{
    background-position: 20% 0%;
    background-size: 300px;
    position: relative;
    display: flex;
    align-items: center;
    background-color: transparent;
    z-index: 1;
}
.image::before{
    position: absolute;
    content: "";
    z-index: -1;
    @apply w-[250px] h-[380px] lg:w-[360px] xl:w-[300px] lg:h-[400px] rounded-full bg-[#66a9b8]/40 backdrop-blur
}
.image img{
    @apply object-cover object-top h-full
}
</style>

<template>
    <section id="hero">
        <div id="banner">
            <div class="w-8/12 lg:w-7/12 flex flex-col items-start justify-center z-10 gap-y-2 lg:gap-y-6">
                <p class="font-Inter text-sm lg:text-lg lg:text-normal">Promote your products for free.</p>
                <h1 class="font-bold text-2xl lg:text-7xl">
                    Help your business grow
                </h1>
                <div class="flex gap-x-2 lg:gap-x-3">
                    <button class="button primary">Advertise now</button>
                </div>
            </div>
            <div class="image w-4/12 lg:w-4/12 relative right-[-65px] lg:initial md:w-4/12 lg:w-5/12 flex justify-center">
                <img width="250" src="/images/hero_banner_img_2.png" alt="image">
            </div>
        </div>
    </section>
</template>
