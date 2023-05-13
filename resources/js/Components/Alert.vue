<script>
import { store } from '../store.js';
export default{
    emits: ['messageSeen'],
    props:{
        message: {
            type: Object,
            required: true
        },
        index: Number
    },
    data(){
        return{
            store
        }
    },
    mounted(){
        setTimeout(()=>{
            this.$refs.alert?.classList.remove('opacity-100');
            this.$refs.alert?.classList.add('opacity-0');
            setTimeout(()=>{
                store.messageSeen(this.message.id);
            },1000);
        },this.message.duration);
    }
}
</script>

<template>
    <div ref="alert"
        :style="`top: ${(index+1)*(60+4)}px;`"
        class="w-full lg:pr-10 flex justify-center lg:justify-end absolute z-[100] left-0 opacity-100 transition-opacity duration-500 ease-in-out"
        >
        <div
            :class="message.variant === 'success' ? 'bg-[#1895B0]' : 'bg-red-500/90'"
            class="flex justify-center items-center text-white px-3 py-2 min-h-[40px] min-w-[80px] max-w-sm lg:max-w-md rounded-lg text-sm font-medium">
            {{ message.text }}
        </div>
    </div>
</template>
