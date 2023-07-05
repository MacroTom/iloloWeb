<script>
import { Link } from '@inertiajs/vue3';
import { Carousel, Slide, Pagination, Navigation } from 'vue3-carousel';
import 'vue3-carousel/dist/carousel.css';
export default{
    components:{
        Carousel, Slide, Pagination, Navigation, Link
    },
    data(){
        return{
            images: [
                {
                    title: 'Post Adverts',
                    body: 'Share your product with a large audience.',
                    link: '/postad',
                    src: '/images/banners/Banners-2.png'
                },
                {
                    title: 'Sales Made Easy',
                    body: 'Increase your sales by posting adverts.',
                    link: '/postad',
                    src: '/images/banners/Banners-3.png'
                }
            ],
        }
    }
}
</script>

<style>
.carousel__pagination{
    @apply absolute bottom-2 w-full
}
.carousel__track, .carousel__viewport {
    height: 100%;
}
</style>

<template>
    <section class="md:col-span-2 lg:row-span-2 shadow-md rounded-lg">
        <Carousel class="w-full h-full overflow-hidden" :itemsToShow="1" :autoplay="4000" wrapAround>
        <slide v-for="(image,index) in images" :key="index">
            <Link :href="image?.link ? image?.link : '#'" class="w-full h-full relative flex items-center">
                <img class="object-cover w-full h-full rounded-lg lg:rounded-none" :src="image?.src" :alt="`banner_${index+1}`"/>
                <!-- <div class="w-full h-full absolute left-0 top-0 bg-[#1895B0]/40 lg:bg-blue-600/10 rounded-lg">
                    <div class="w-full h-full flex flex-col justify-center gap-y-2 lg:gap-y-4 items-start px-4 lg:px-12 lg:y-6">
                        <h1 class="text-lg md:text-2xl lg:text-3xl font-bold text-slate-50 text-left font-Inter">{{ image?.title }}</h1>
                        <p class="font-medium text-sm lg:text-lg text-left font-Inter text-slate-800">{{ image?.body }}</p>
                        <Link :href="image?.link ? image?.link : '#'" class="button primary">Get Started</Link>
                    </div>
                </div> -->
            </Link>
        </slide>

        <template #addons>
          <!-- <navigation /> -->
          <pagination />
        </template>
      </Carousel>
    </section>
</template>
