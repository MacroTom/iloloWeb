<script>
export default {
    props:{
        orientation: {
            type: String,
            default: "horizontal"
        },
        timelines: {
            type: Array,
            required: true
        },
        current: {
            type: Number,
            default: 0
        }
    },
    data(){
        return {}
    }
}
</script>

<template>
    <div class="flex lg:flex-col">
        <section v-for="(timeline, key) in timelines" :key="key"
            class="flex items-end">
            <div class="flex lg:flex-col items-center">
                <div v-if="key !== 0"
                    :class="current === key ? 'border-slate-500' : key < current ? 'border-[#1895B0]' : 'border-slate-400'"
                    class="w-5 h-[0px] lg:w-[0px] lg:h-5 border border-dashed m-1"
                    >
                </div>
                <div :class="current === key ? 'border-slate-600 text-slate-600' : key < current ? 'border-[#1895B0] text-[#1895B0]' : 'border-slate-400 text-slate-400'"
                    class="w-10 h-10 flex items-center justify-center relative lg:w-10 lg:h-10 border-[2px] rounded-full z-0">
                    <span v-if="timeline?.label" class="text-sm">{{ timeline?.label }}</span>
                    <span v-else class="text-sm"><i class='bx bx-check text-xl'></i></span>
                    <i v-if="current > key && timeline?.label" class='bx bxs-check-circle text-xl text-[#1895B0] absolute -right-3 -bottom-2 z-10'></i>
                </div>
            </div>
            <span :class="current === key ? 'text-slate-700' : key < current ? 'text-[#1895B0]' : 'text-slate-400'"
                class="hidden lg:block mb-3 ml-4 text-sm">
                {{ timeline?.description }}
            </span>
        </section>
    </div>
</template>
