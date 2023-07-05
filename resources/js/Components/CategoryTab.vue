<script>
export default{
    props:{
        categories: Array,
        modelValue:{}
    },
    emits: ['update:modelValue'],
    data(){
        return{
            selected: null
        }
    },
    watch:{
        selected(){
            this.$emit('update:modelValue', this.categories[this.selected].key);
        }
    },
    methods:{
        selectCategory(index){
            this.selected = index;
        }
    },
    mounted(){
        this.selected = 0;
    }
}
</script>

<style scoped>
    .skeleton{
        @apply bg-slate-50
    }
</style>

<template>
    <div v-for="(category, index) in categories" :key="index"
        @click="selectCategory(index)"
        class="px-3 p-2 rounded-lg flex items-center lg:cursor-pointer"
        >
        <div class="w-9 h-9 rounded-full border flex items-center justify-center">
            <i :class="category.icon" class='bx pointer-events-none text-slate-800'></i>
        </div>
        <div class="flex-1 mx-2 text-slate-700 font-Inter select-none text-xs">{{ category.title }}</div>
        <div :class="selected === index ? 'bg-[#1895B0] text-white' : 'border text-transparent'" class="w-4 h-4 flex items-center justify-center rounded-full">
            <i class='bx bx-check text-sm pointer-events-none'></i>
        </div>
    </div>
</template>
