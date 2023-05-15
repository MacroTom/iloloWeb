<script>
export default{
    props:{
        chat: Object
    },
    data(){
        return {}
    }
}
</script>

<template>
    <div :class="chat?.position?.toLowerCase() === 'left' ? 'rounded-br-lg bg-slate-50' : 'rounded-bl-lg bg-[#1895B0]/70 text-white self-end items-end'"
        class="max-w-xs p-3 rounded-t-lg flex flex-col gap-y-2"
        >
        <div class="w-full text-xs">
            {{ chat?.text }}
        </div>
        <small class="text-[10px]">
            {{ chat?.date }}
        </small>
    </div>
</template>
