<script>
import { store } from '../store.js';
import Chat from './Chat.vue';
import Alerts from './Alerts.vue';
export default{
    components:{
        Chat,
        Alerts
    },
    data(){
        return{
            store,
        }
    },
    computed:{
        currentProps(){
            if(store.chatWindowPage === 'Chat'){
                return { auth: this.$page.props.auth }
            }
        }
    }
}
</script>

<style scoped>
.chatwindow{
    @apply w-[280px] md:w-[340px] h-screen bg-white shadow-lg fixed top-0 z-[501] transition-[right] duration-[500ms]
}
.chatwindow-close{
    @apply h-screen absolute top-0 right-[280px] md:right-[340px] bg-black/20 cursor-pointer transition-[width] duration-100
}
.container{
    @apply w-full md:w-[340px] h-full
}
.nav{
    @apply w-full h-[50px] md:h-[60px] flex items-center justify-center p-3 md:p-4
}
.content{
    @apply w-full h-[calc(100%-50px)] md:h-[calc(100%-60px)]
}
</style>

<template>
    <!-- chatwindow -->
    <aside :class="store.chatWindow ? 'right-0' : 'right-[-500px]'" class="chatwindow">
        <div @click="store.toggleChatWindow()" :class="store.chatWindow ? 'w-screen' : 'w-0'" class="chatwindow-close"></div>
        <section class="container">
            <nav class="nav">
                <button @click="store.gotoWindow('Chat')" :class="store.chatWindowPage === 'Chat' ? 'text-[#18849B]' : 'text-slate-600 bg-slate-50'"
                    class="flex flex-col items-center justify-center flex-1 text-[#18849B] font-Inter border py-2 rounded-l-lg">
                    <span class="text-xs font-light select-none relative">
                        Chat
                    </span>
                </button>
                <button @click="store.gotoWindow('Alerts')" :class="store.chatWindowPage === 'Alerts' ? 'text-[#18849B]' : 'text-slate-600 bg-slate-50'"
                    class="flex flex-col items-center justify-center flex-1 text-[#18849B] font-Inter border-y border-r py-2 rounded-r-lg text-medium">
                    <span class="text-xs font-light select-none">Alerts</span>
                </button>
            </nav>
            <div class="content">
                <component :is="store.chatWindowPage" v-bind="currentProps"/>
            </div>
        </section>
    </aside>
    <!-- chatwindow ends here -->
</template>
