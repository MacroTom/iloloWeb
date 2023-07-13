<script>
import StarRatings from "./StarRatings.vue";
import BarRatings from "./BarRatings.vue";
import Review from "./Review.vue";
import { Carousel, Slide, Pagination, Navigation } from 'vue3-carousel';
export default{
    props:{
        reviews: Array
    },
    components:{
        StarRatings,
        BarRatings,
        Review,
        Carousel, Slide, Pagination, Navigation,
    },
    data(){
        return{
            breakpoints: {
                // 768px and up
                768: {
                    itemsToShow: 1,
                    wrapAround: false
                },
                // 1024 and up
                1024: {
                    itemsToShow: 2,
                    wrapAround: false
                },
            },
        }
    },
    methods:{
        // function that shortens numbers equal to or greater than 1000 using suffixes like 'K','M','B'
        shortenNumber(number){
            if(number >= 1000000000){
                return (number/1000000000).toFixed(1).replace(/\.0$/,'') + 'B';
            }
            if(number >= 1000000){
                return (number/1000000).toFixed(1).replace(/\.0$/,'') + 'M';
            }
            if(number >= 1000){
                return (number/1000).toFixed(1).replace(/\.0$/,'') + 'K';
            }
            return number;
        },
        arrangeData(){
            let $payload = {
                total: this.reviews.length,
                stars: []
            }
            for(let i=1; i<=5; i++){
                $payload.stars.push(this.reviews.filter(review => review.rating === i).length);
            }
            return $payload;
        },
        findAverageRatingFromReviews(){
            let $total = 0;
            this.reviews.forEach(review => {
                $total += review.rating;
            });
            return this.reviews.length ? ($total/this.reviews.length).toFixed(1) : this.reviews.length;
        }
    }
}
</script>

<style scoped>
.v-divider{
    @apply bg-slate-200 w-[1px] mx-1 md:mx-4
}
.h-divider{
    @apply bg-slate-200 w-full h-[1px] my-4
}
.carousel__icon{
    @apply text-[#1895B0]
}
.carousel__track, .carousel__viewport {
    height: 100%;
}
</style>

<template>
    <section class="mt-6 flex bg-slate-50 py-4 rounded-lg mb-4">
        <div class="flex-1 flex flex-col gap-2 justify-center items-center">
            <h4 class="text-slate-700 text-xl md:text-2xl font-Inter font-semibold">{{ shortenNumber(reviews.length) }}</h4>
            <small class="text-slate-400 text-[10px] font-Inter">Total reviews</small>
        </div>
        <div class="v-divider"></div>
        <div class="flex-1 flex flex-col gap-2 justify-center items-center">
            <h4 class="text-slate-700 text-xl md:text-2xl font-Inter font-semibold">{{ findAverageRatingFromReviews() }}</h4>
            <small class="text-slate-400 text-[10px] font-Inter">Average ratings</small>
        </div>
        <div class="v-divider"></div>
        <div class="flex-1 flex justify-center">
            <BarRatings :data="arrangeData()"/>
        </div>
    </section>
    <section class="w-full h-fit overflow-hidden">
        <Carousel class="w-full h-full overflow-hidden relative" wrapAround :itemsToShow="1" :breakpoints="breakpoints">
            <slide v-for="(review,index) in reviews" :key="index">
                <Review :review="review"/>
            </slide>
            <template #addons>
                <navigation />
                <pagination />
            </template>
        </Carousel>
    </section>
</template>
