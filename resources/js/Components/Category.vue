<script>
export default {
    props:{
        category: Object
    },
    data(){
        return{}
    }
}
</script>

<template>
    <div class="bg-white/75 cursor-pointer hover:bg-slate-50 lg:bg-transparent flex items-center justify-between p-2 rounded-lg">
        <div class="flex flex-col">
            <span class="font-medium text-[#0e1416] lg:text-[#1895B0]">{{ category.title }}</span>
            <span class="text-xs">{{ category.adverts + (category.adverts > 1 ? ' ads' : ' ad') }}</span>
        </div>
        <i class='bx bx-chevron-right text-xl'></i>
    </div>
</template>
