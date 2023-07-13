<script>
export default{
    props:{
        range: {
            type: Number,
            default: 5
        },
        barWidth: {
            type: String,
            default: 'w-[6px] md:w-[8px]'
        },
        data: {
            type: Object,
            default: {
                total: 10000,
                stars: [500, 1000, 1500, 3000, 4000]
            }
        }
    },
    data(){
        return{
            colors: [
                "#f17a54",
                "#fbb851",
                "#f6d757",
                "#b7ea83",
                "#76db98"
            ]
        }
    }
}
</script>

<template>
    <ul class="flex gap-2 md:gap-4 justify-center">
        <li class="h-fit flex flex-col items-center justify-center" v-for="value in range">
            <i class="bx bx-star text-slate-400 text-[10px]"></i>
            <div :class="barWidth" class="h-[35px] bg-slate-200 rounded flex items-end">
                <div :style="`height:${((data.stars[value-1]/data.total)*35)}px; background-color: ${colors[value-1]};`" class="w-full rounded"></div>
            </div>
            <span class="text-slate-500 text-[10px]">{{ value }}</span>
        </li>
    </ul>
</template>
