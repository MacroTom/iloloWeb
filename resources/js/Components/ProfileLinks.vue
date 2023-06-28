<script>
import { Link } from '@inertiajs/vue3';
export default {
    components:{
        Link
    },
    props:{
        links: {
            type: Array,
            required: true
        }
    },
    data(){
        return{}
    }
}
</script>

<style scoped>
.link{
    @apply font-Inter text-sm flex justify-center flex-1 p-2 border-r last:border-r-0
}
</style>

<template>
    <div class="border mb-2 rounded-lg flex">
        <Link v-for="(link,index) in links" :key="index" :href="link.href" :class="$page.url === link.match ? 'text-[#1895B0] font-medium' : 'bg-slate-100 text-slate-600'" class="link">
            {{ link.label }}
        </Link>
    </div>
</template>
