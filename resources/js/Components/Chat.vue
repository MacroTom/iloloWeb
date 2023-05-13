<script>
export default{
    props:{
        details: Object
    },
    data(){
        return{}
    }
}
</script>

<template>
    <div class="p-2 lg:p-4 flex items-center border-b last:border-b-0 lg:cursor-pointer">
        <div class="mr-2">
            <img v-if="details?.avatar" class="rounded-full w-[45px] h-[45px] lg:w-[60px] lg:h-[60px]"
                :src="details?.avatar"
                alt="avatar"/>
            <div v-else class="w-[45px] h-[45px] lg:w-[60px] lg:h-[60px] flex items-center justify-center rounded-full bg-[#D9D9D9]">
                <i class='bx bx-user text-3xl lg:text-4xl text-[#4E4B4A]'></i>
            </div>
        </div>
        <div class="flex-1">
            <div class="flex items-center justify-between">
                <span class="text-sm font-semibold text-black/80">{{details?.user}}</span>
                <small class="text-xs font-medium text-black/70">{{details?.date}}</small>
            </div>
            <p class="text-xs">{{details?.text}}</p>
        </div>
    </div>
</template>
