<script>
import { Link } from '@inertiajs/vue3';
export default {
    props: {
        details: Object,
        required: true,
    },
    components:{
        Link
    },
    data(){
        return{
            statusconfig: {
                active: {text: 'Active', color: '#2F9F3F'},
                review: {text: 'On Review', color: '#FFB800'},
                closed: {text: 'Closed', color: '#F01010'}
            }
        }
    }
}
</script>

<template>
    <div class="w-full py-4 px-2 lg:px-4 flex items-center gap-x-2 lg:gap-x-4 relative group border-b last:border-b-0">
        <div class="w-4/12 lg:w-2/12">
            <img class="object-cover rounded-lg" :src="details.image" alt="productimage">
        </div>
        <div class="w-8/12 lg:w-10/12 flex flex-col gap-y-[4px] lg:gap-y-2">
            <div>
                <p class="text-sm font-medium">{{ details.name }}</p>
            </div>
            <div>
                <small class="text-[#1895B0]">₦{{ details.price }}</small>
            </div>
            <div class="flex gap-x-1 items-center">
                <div :style="`background-color:${statusconfig[details.status.toLowerCase()].color};`"
                    class="w-2 h-2 rounded-full"></div>
                <span class="text-xs">{{ statusconfig[details.status.toLowerCase()].text }}</span>
            </div>
            <div v-if="details.status.toLowerCase() !== 'review'"
                class="flex text-[10px] gap-x-2 font-medium">
                <span class="lg:py-2 lg:px-1 lg:p-2 lg:bg-slate-200 rounded text-black/60">
                    <span class="font-bold">Impressions</span>
                    <span>({{ details.impression }})</span>
                </span>
                <span class="lg:py-2 lg:px-1 lg:p-2 lg:bg-slate-200 rounded text-black/60">
                    <span class="font-bold">Product views</span>
                    <span>({{ details.views }})</span>
                </span>
            </div>
            <div v-else
                class="font-medium">
                <span class="text-[10px] leading-[5px] lg:text-xs text-black/60">
                    Reviewing takes 4 hours to make sure everything is in view.
                </span>
            </div>
            <div v-if="$page.url === '/profile/ads/manage'" class="text-sm flex gap-x-2 lg:hidden">
                <Link href="#">Edit</Link>
                <Link href="#">Renew</Link>
                <Link href="#">Close</Link>
            </div>
        </div>
        <div v-if="$page.url === '/profile/ads/manage'" class="text-xs flex-col hidden lg:flex gap-y-1">
            <Link
                class="bg-[#1895B0]/60 flex p-1 text-white justify-center rounded"
                href="#">Edit</Link>
            <Link
                class="bg-[#1895B0]/60 flex p-1 text-white justify-center rounded"
                href="#">Renew</Link>
            <Link
                class="bg-[#1895B0]/60 flex p-1 text-white justify-center rounded"
                href="#">Close</Link>
        </div>
    </div>
</template>
