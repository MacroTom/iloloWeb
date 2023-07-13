<script>
export default{
    props: {
        range: {
            type: Number,
            default: 5
        },
        color: {
            type: String,
            default: 'text-[#475569]'
        },
        size: {
            type: String,
            default: 'text-sm'
        },
        rating: {
            type: Number,
            default: 1
        }
    },
    emits: ['update:rating'],
    data(){
        return{
        }
    },
    methods:{
        rate(value){
            this.$emit('update:rating', value);
        }
    }
}
</script>

<template>
    <section :class="color, size" class="w-fit h-fit flex items-center">
        <i v-if="rating" @click="rate(number)" :class="rating >= number ? 'bxs-star' : 'bx-star'" class='bx cursor-pointer' v-for="(number,index) in range" :key="index"></i>
        <small v-else class="text-xs font-Inter text-slate-500">(No reviews found)</small>
    </section>
</template>
