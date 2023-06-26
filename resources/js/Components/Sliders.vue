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
                    title: 'Post ads Online',
                    body: 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Nobis excepturi nostrum vitae sed at enim quia repudiandae maiores doloribus! Iste.',
                    link: '',
                    src: '/images/banner_1.png'
                },
                {
                    title: 'Sales Made Easy',
                    body: 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Nobis excepturi nostrum vitae sed at enim quia repudiandae maiores doloribus! Iste.',
                    link: '',
                    src: '/images/banner_3.png'
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
                <div class="w-2/3 lg:w-1/2 absolute left-[16px] lg:left-[60px]">
                    <div class="flex flex-col gap-y-4 items-start">
                        <h1 class="text-lg md:text-2xl lg:text-4xl font-bold text-slate-50 text-left font-Inter">{{ image?.title }}</h1>
                        <p class="hidden lg:block font-medium text-left font-Inter text-slate-800">{{ image?.body }}</p>
                        <Link :href="image?.link ? image?.link : '#'" class="button primary">Get Started</Link>
                    </div>
                </div>
            </Link>
        </slide>

        <template #addons>
          <!-- <navigation /> -->
          <pagination />
        </template>
      </Carousel>
    </section>
</template>
