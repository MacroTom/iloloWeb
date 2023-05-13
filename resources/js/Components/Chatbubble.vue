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
    <div :class="chat?.position?.toLowerCase() === 'left' ? 'rounded-br-lg bg-slate-50' : 'rounded-bl-lg bg-[#1895B0]/70 text-white self-end'"
        class="max-w-xs p-3 rounded-t-lg"
        >
        <div class="text-xs">
            {{ chat?.text }}
        </div>
        <small class="text-[10px]">
            {{ chat?.date }}
        </small>
    </div>
</template>
