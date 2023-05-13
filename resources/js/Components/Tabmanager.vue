<script>
import { Link } from '@inertiajs/vue3';
export default{
    props:{
        tabs: {
            type: Array,
            default: []
        },
        heading: {
            type: String,
            default: 'Heading'
        },
    },
    components:{
        Link
    },
    data(){
        return{
        }
    },
    methods:{
    },
    mounted(){
    }
}
</script>

<template>
    <div class="w-full p-4 lg:flex border-b border-[#D9D9D9]">
        <div
            class="w-full lg:w-5/12 flex items-center"
            >
            <p class="font-medium text-lg">{{ heading }}</p>
        </div>
        <div
            class="w-full lg:w-10/12 flex items-center gap-x-2 lg:gap-x-0 lg:justify-end pt-2"
            >
            <Link v-for="(tab, key) in tabs" :key="key"
                :href="tab.href"
                :class="(tab.href !== $page.url) && 'text-[#8A8A8A]'"
                class="text-[10px] lg:text-xs font-medium mr-1 lg:mr-4 border-0"
                :data-content="tab.key"
                >
                <span>{{ tab.title }}</span>
                <span>{{ tab.counter !== null ? `(${tab.counter})` : '' }}</span>
            </Link>
        </div>
    </div>
    <div ref="tabcontent" class="w-full">
        <slot/>
    </div>
</template>
