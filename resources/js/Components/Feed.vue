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
    <section class="p-4 flex gap-x-2 items-center border-b last:border-b-0">
        <div class="flex flex-shrink-0">
            <img v-if="details?.avatar" class="rounded-full w-[45px] h-[45px] lg:w-[60px] lg:h-[60px]"
                :src="details?.avatar"
                alt="avatar"/>
            <div v-else class="w-[45px] h-[45px] lg:w-[60px] lg:h-[60px] flex items-center justify-center rounded-full bg-[#D9D9D9]">
                <i class='bx bx-user text-3xl lg:text-4xl text-[#4E4B4A]'></i>
            </div>
        </div>
        <div class="">
            <div class="flex items-center gap-x-2">
                <p class="font-medium">{{details.user}}</p>
                <span class="w-2 h-2 rounded bg-black/40"></span>
                <p class="text-black/40 text-xs font-semibold">{{details.date}}</p>
            </div>
            <div class="flex items-center">
                <span class="mr-1" v-html="`${details.reaction}`"></span>
                <p class="text-xs">
                    {{details.text}}
                </p>
            </div>
        </div>
    </section>
</template>
