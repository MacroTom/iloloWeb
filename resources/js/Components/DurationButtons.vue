<script>
export default{
    props:[
        'durations',
        'modelValue'
    ],
    emits: ['update:modelValue'],
    data(){
        return{
            active: 0,
        }
    },
    methods:{
        handleClick(duration,index){
            this.active = index;
            this.$emit('update:modelValue',duration);
        }
    }
}
</script>

<template>
    <section class="px-4 py-2 md:p-2 border-t mt-2 flex">
        <button @click="handleClick(duration,index)" :class="active === index ? 'md:border bg-slate-100' : ''" class="min-h-[35px] flex-1 text-[10px] font-Inter font-semibold rounded-lg text-slate-600" v-for="(duration,index) in durations">
            {{ duration }} {{ duration > 1 ? 'Months' : 'Month' }}
        </button>
    </section>
</template>
