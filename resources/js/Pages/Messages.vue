<script>
import Tabmanager from '../Components/Tabmanager.vue';
import {store} from '../store.js';
import { Head } from '@inertiajs/vue3';
import Heading from '../Components/Heading.vue';
import Bottomnavigationbar from '../Components/Bottomnavigationbar.vue';
import Chat from '../Components/Chat.vue';
import Chatpill from '../Components/Chatpill.vue';
import Chatbubble from '../Components/Chatbubble.vue';
export default{
    props:{
        auth: Object
    },
    components:{
    Tabmanager,
    Head,
    Heading,
    Bottomnavigationbar,
    Chat,
    Chatpill,
    Chatbubble
},
    data(){
        return{
            store,
            currentChat: {}
        }
    },
    mounted(){
        document.body.classList.add('bg-[#C7D1D3]');
    },
    methods:{
        setCurrentChat(pos){
            store.setChat(true);
            this.currentChat = store.feeds.received[pos];
        },
        closeChat(){
            store.setChat(false);
        }
    }
}
</script>

<template>
    <Head>
        <title>Messages</title>
    </Head>
    <Heading back="/"/>
    <section class="h-[calc(100vh-40px)] lg:h-[calc(100vh-60px)] relative top-[40px] lg:top-[60px] flex items-start px-2 pt-6 pb-16 lg:p-8">
        <aside
            :class="(store.chatOpen && store.device.screen === 'mobile') ? 'hidden' : 'block'"
            class="rounded-lg md:rounded-br-none md:rounded-tr-none md:rounded-tl-lg md:rounded-bl-lg w-full min-h-[400px] h-[600px] md:w-4/12 lg:w-4/12 xl:w-3/12 bg-white shadow"
            >
            <div class="w-full h-[50px] lg:h-[60px] flex items-center pl-4 shadow">
                <p
                    class="font-medium text-[#1895B0]/75"
                    >
                    My messages
                </p>
            </div>
            <div class="max-h-[calc(100%-60px)] overflow-y-auto pb-4">
                <Chat @click="setCurrentChat(key)" v-for="(chat, key) in store.feeds.received"
                    :key="key" :details="chat"/>
            </div>
        </aside>
        <main
            :class="store.chatOpen && store.device.screen === 'mobile' ? 'block' : 'hidden'"
            class="h-[600px] md:block w-full min-h-[400px] md:w-8/12 lg:w-8/12 xl:w-9/12 bg-[#E9EAEA] rounded-br-lg rounded-bl-lg md:rounded-bl-none rounded-tr-lg rounded-tl-lg md:rounded-tl-none shadow"
            >
            <div
                :class="store.chatOpen || store.device.screen === 'mobile' ? 'hidden' : 'md:flex'"
                class="flex-col items-center justify-center w-full h-full gap-y-2"
                >
                <img class="opacity-70" src="/images/empty.png" alt="image">
                <p class="font-light">click a chat to view conversation</p>
            </div>
            <div
                :class="store.chatOpen ? 'block' : 'hidden'"
                class="w-full h-full"
                >
                <header
                    class="w-full h-[60px] bg-white flex items-center justify-between px-2 rounded-tr-lg rounded-tl-lg md:rounded-tl-none"
                    >
                    <div class="flex">
                        <div @click="closeChat"
                            class="flex items-center lg:cursor-pointer lg:hidden">
                            <i class='text-3xl pointer-events-none bx bx-chevron-left text-black/70'></i>
                        </div>
                        <img v-if="currentChat?.avatar" class="rounded-full w-[40px] h-[40px] lg:w-[45px] lg:h-[45px]"
                            :src="currentChat?.avatar"
                            alt="avatar"/>
                        <div v-else class="w-[40px] h-[40px] lg:w-[45px] lg:h-[45px] flex items-center justify-center rounded-full bg-[#D9D9D9]">
                            <i class='bx bx-user text-2xl lg:text-3xl text-[#4E4B4A]'></i>
                        </div>
                    </div>
                    <div class="flex flex-col items-center text-sm">
                        <span class="font-medium">{{currentChat?.user}}</span>
                        <small>last seen {{currentChat?.date}}</small>
                    </div>
                    <div>
                        <div
                            class="w-[40px] h-[40px] flex items-center justify-center lg:cursor-pointer"
                            >
                            <i class='bx bxs-flag-alt text-2xl text-[#1895B0] pointer-events-none'></i>
                        </div>
                    </div>
                </header>
                <section
                    class="w-full h-[calc(100%-60px-120px)] flex flex-col items-start gap-y-2 overflow-y-auto px-3 py-4"
                    >
                    <Chatbubble
                        v-for="(chat, key) in store.feeds.received"
                        :key="key" :chat="chat"
                        />
                </section>
                <div
                    class="w-full h-[120px] bg-white rounded-b-lg md:rounded-bl-none flex flex-col justify-center items-start px-3 gap-y-2"
                    >
                    <div class="flex w-full overflow-x-auto gap-x-1">
                        <Chatpill>Hello!</Chatpill>
                        <Chatpill>Last price?</Chatpill>
                        <Chatpill>Location?</Chatpill>
                    </div>
                    <div class="flex items-center w-full">
                        <div class="lg:cursor-pointer">
                            <i class='text-2xl pointer-events-none bx bxs-camera text-black/70'></i>
                        </div>
                        <div class="flex items-center w-full">
                            <textarea class="resize-none rounded-lg ml-2 outline-none p-2 text-sm flex-1 bg-[#E9EAEA]" rows="2"></textarea>
                            <button class="w-[30px] lg:cursor-pointer">
                                <i class='text-2xl pointer-events-none bx bxs-send text-black/70'></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </section>
    <Bottomnavigationbar/>
</template>
