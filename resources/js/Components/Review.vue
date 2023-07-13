<script>
import StarRatings from "./StarRatings.vue";
import moment from "moment";
export default{
    props:{
        review: Object
    },
    components:{
        StarRatings,
    },
    data(){
        return{}
    },
    methods:{
        formatDate(value){
            return moment(value).fromNow();
        },
    }
}
</script>

<style scoped>
.review{
    @apply w-full h-full even:bg-slate-50 border rounded-lg p-2 lg:p-4 lg:mr-2
}
</style>

<template>
    <div class="review">
        <header class="flex items-center mb-2 lg:mb-3">
            <div class="w-9 h-9 relative mr-2 lg:mr-3">
                <img class="object-cover w-full h-full rounded-lg shadow" :src="review?.user?.avatar" alt="avatar">
            </div>
            <div class="flex flex-col gap-1 flex-1">
                <p class="text-slate-600 text-sm font-Inter text-left font-semibold overflow-hidden text-ellipsis whitespace-nowrap">{{ review?.user?.firstname }} {{ review?.user?.lastname }}</p>
                <StarRatings :rating="review?.rating" color="text-[#F59E0B]"/>
            </div>
            <div>
                <small class="text-[10px] px-2 py-1 border rounded-lg text-slate-600">{{ formatDate(review?.created_at) }}</small>
            </div>
        </header>
        <section class="bg-slate-50 pl-1 rounded-lg">
            <p class="w-full min-h-[60px] max-h-[120px] text-sm text-slate-600 text-left leading-5 font-Inter overflow-hidden text-ellipsis">{{ review?.review }}</p>
        </section>
    </div>
</template>
