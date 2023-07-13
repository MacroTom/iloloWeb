<script>
import { store } from '../store';
export default{
    data(){
        return{
            store
        }
    },
    methods:{

    },
    mounted(){
    }
}
</script>

<style scoped>
.container{
    @apply w-full h-full px-3 py-1 md:px-4
}
.alert{
    @apply w-full h-[50px] flex border-b last:border-0 p-3 font-Inter gap-2
}
.bullet{
    @apply w-[8px] h-[8px] bg-[#18849B] rounded-full flex-shrink-0 mt-1
}
</style>

<template>
    <section class="container">
        <!-- Mark as all read -->
        <div class="text-right">
            <button :disabled="store.notifications.length <= 0" class="text-xs text-slate-500 font-Inter p-2 font-medium disabled:text-slate-400">Mark all as read</button>
        </div>
        <div class="border rounded-lg">
            <div class="alert" v-for="(alert, index) in store.notifications">
                <span class="bullet"></span>
                <div class="text-xs text-slate-600 flex items-center">
                    <span>You have a new message from</span> <span class="text-[#18849B]">John Doe</span>
                </div>
                <button class="flex justify-center items-center w-7 h-7 rounded-lg border">
                    <i class='bx bx-dots-vertical-rounded text-lg text-slate-500 pointer-events-none'></i>
                </button>
            </div>
            <div v-show="store.notifications.length <= 0" class="alert">
                <div class="w-full text-xs text-slate-600 flex items-center justify-center">
                    <span>No Alerts yet...</span>
                </div>
            </div>
        </div>
    </section>
</template>
