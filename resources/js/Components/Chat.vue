<script>
import { Link, router } from '@inertiajs/vue3';
import Chatbubble from './Chatbubble.vue';
import moment from 'moment';
import { store } from '../store.js';
import axios from 'axios';
export default{
    props:{
        selectedSection: {
            type: String,
            default: 'user-list'
        }
    },
    components:{
        Link,
        Chatbubble
    },
    data(){
        return{
            store,
            q: '',
            section: 'user-list',
            users: [],
            messages: [],
            message: '',
            chats:[
                {
                    id: 1,
                    from_user: 101,
                    to_user: 102,
                    message: 'Hello, what\'s the last price?',
                    date: '2021-08-01 12:00'
                },
                {
                    id: 2,
                    from_user: 102,
                    to_user: 101,
                    message: 'Hello, what\'s the last price?',
                    date: '2021-08-01 12:00'
                },
                {
                    id: 3,
                    from_user: 101,
                    to_user: 102,
                    message: 'Hello, what\'s the last price?',
                    date: '2021-08-01 12:00'
                },
                {
                    id: 4,
                    from_user: 102,
                    to_user: 101,
                    message: 'Hello, what\'s the last price?',
                    date: '2021-08-01 12:00'
                },
                {
                    id: 5,
                    from_user: 101,
                    to_user: 102,
                    message: 'Hello, what\'s the last price?',
                    date: '2021-08-01 12:00'
                },
                {
                    id: 6,
                    from_user: 102,
                    to_user: 101,
                    message: 'Hello, what\'s the last price?',
                    date: '2021-08-01 12:00'
                },
                {
                    id: 7,
                    from_user: 101,
                    to_user: 102,
                    message: 'Hello, what\'s the last price?',
                    date: '2021-08-01 12:00'
                },
                {
                    id: 8,
                    from_user: 102,
                    to_user: 101,
                    message: 'Hello, what\'s the last price?',
                    date: '2021-08-01 12:00'
                },
                {
                    id: 9,
                    from_user: 101,
                    to_user: 102,
                    message: 'Hello, what\'s the last price?',
                    date: '2021-08-01 12:00'
                },
            ],
            sending: false,
            selectedUser: null,
            timer: null
        }
    },
    methods:{
        formatDate(value){
            return moment(value).fromNow();
        },
        now(){
            return moment().format('HH:mm');
        },
        openChat(){
            store.messages = [];
            this.section = 'chat-area';
        },
        closeChat(){
            this.section = 'user-list';
            this.getUsers();
        },
        getUsers(){
            axios.get('/profile/getusers')
            .then(res => {
                this.users = res.data.users;
            })
            .catch(err => {
                this.store.snackbar.add({
                    message: "Could not retrieved users!",
                    severity: "warning"
                });
            })
        },
        sendMessage(){
            if(this.message === '') return;
            this.sending = true;
            const payload = {
                message: this.message,
                to_id: this.selectedUser.id,
                advert_id: null
            }
            axios.post('/profile/sendmessage', payload)
            .then(res => {
                this.store.snackbar.add({
                    message: "Message sent!",
                    severity: "success"
                });
                store.messages.push(res.data.message);
                setTimeout(() => {
                    this.$refs.chathistory.scrollTop = this.$refs.chathistory.scrollHeight;
                }, 0);
                this.sending = false;
                this.message = '';
                this.getUsers();
            })
            .catch(err => {
                this.store.snackbar.add({
                    message: "Could not send message!",
                    severity: "warning"
                });
                this.sending = false;
            })
            // router.post('/profile/sendmessage', payload, {
            //     onSuccess: (res) => {
            //         this.store.snackbar.add({
            //             message: "Message sent!",
            //             severity: "success"
            //         });
            //         this.messages.push(res.props.flash.data.message);
            //         setTimeout(() => {
            //             this.$refs.chathistory.scrollTop = this.$refs.chathistory.scrollHeight;
            //         }, 0);
            //         this.sending = false;
            //         this.message = '';
            //         this.getUsers();
            //     },
            //     onError: (err) => {
            //         this.store.snackbar.add({
            //             message: "Could not send message!",
            //             severity: "warning"
            //         });
            //         this.sending = false;
            //     }
            // });
        },
        getMessages(user){
            this.selectedUser = user;
            this.openChat();
            axios.get('/profile/getmessages?user_id='+this.selectedUser.id)
            .then(res => {
                store.messages = res.data.messages;
                setTimeout(() => {
                    this.$refs.chathistory.scrollTop = this.$refs.chathistory.scrollHeight;
                }, 0);
            })
            .catch(err => {
                this.store.snackbar.add({
                    message: "Could not retrieved messages!",
                    severity: "warning"
                });
            })
        }
    },
    mounted(){
        store.history = this.$refs.chathistory;
    },
    beforeMount(){
        this.$page.props.auth?.user && this.getUsers();
    }
}
</script>

<style scoped>
.container{
    @apply w-full h-full px-3 py-2 md:px-4
}
.search{
    @apply w-full flex items-center border rounded-lg px-2 py-1 mb-4
}
.user-list{
    @apply w-full h-full
}
.users{
    @apply w-full h-fit max-h-[calc(100%-200px)] border rounded-lg overflow-y-auto
}
.user{
    @apply w-full border-b last:border-b-0 flex items-center p-2 md:p-3 cursor-pointer hover:bg-slate-50
}
.status{
    @apply w-3 h-3 rounded-full absolute bottom-0 right-0 border-2 border-white
}
.status.online{
    @apply bg-green-500
}
.status.offline{
    @apply bg-slate-500
}
.message-indicator{
    @apply w-4 h-4 rounded-full bg-[#1895B0] text-white text-[10px] flex justify-center items-center
}
.chat-area{
    @apply w-full h-full relative
}
.topbar{
    @apply w-full h-[60px] flex items-center justify-between border-b
}
.chat-messages{
    @apply w-full min-h-[calc(100%-60px)] max-h-[calc(100%-60px)] overflow-y-auto scrollbar-hide pt-4 pb-12
}
.preloader {
    width: 100%;
    height: 100%;
    padding-block: 8px;
    background-color: white;
}

.sk-three-bounce {
    margin: 0;
    width: 100%;
    height: 100%;
    text-align: center;
    background-color: white;
}

.sk-three-bounce .sk-child {
    position: relative;
    top: 50%;
    transform: translateY(-50%);
    width: 10px;
    height: 10px;
    background-color: #1895B0;
    border-radius: 100%;
    display: inline-block;
    -webkit-animation: sk-three-bounce 1.4s ease-in-out 0s infinite both;
    animation: sk-three-bounce 1.4s ease-in-out 0s infinite both;
}

.sk-three-bounce .sk-bounce1 {
    -webkit-animation-delay: -0.32s;
    animation-delay: -0.32s;
}

.sk-three-bounce .sk-bounce2 {
    -webkit-animation-delay: -0.16s;
    animation-delay: -0.16s;
}

@-webkit-keyframes sk-three-bounce {
    0%,
    80%,
    100% {
        -webkit-transform: scale(0);
        transform: scale(0);
    }
    40% {
        -webkit-transform: scale(1);
        transform: scale(1);
    }
}

@keyframes sk-three-bounce {
    0%,
    80%,
    100% {
        -webkit-transform: scale(0);
        transform: scale(0);
    }
    40% {
        -webkit-transform: scale(1);
        transform: scale(1);
    }
}
</style>

<template>
    <section class="container">
        <section v-if="section === 'user-list'" class="user-list">
            <div class="search">
                <input class="w-full h-full font-Inter bg-transparent p-2 outline-none text-sm text-slate-700 placeholder:text-xs placeholder:text-slate-500 placeholder:font-Inter" placeholder="Search" type="text" v-model="q"/>
                <i class="bx bx-search-alt text-slate-500 pointer-events-none text-lg"></i>
            </div>
            <div class="users">
                <div v-if="users?.length > 0" @click="getMessages(user)" class="user" v-for="(user, index) in users" :key="index">
                    <div class="w-10 h-10 mr-3 relative">
                        <img class="object-cover w-full h-full rounded-lg" :src="user?.avatar" alt="avatar">
                        <div :class="user?.presence" class="status"></div>
                    </div>
                    <div class="flex-1 flex flex-col gap-y-1 font-Inter">
                        <div class="flex justify-between items-center">
                            <p class="text-slate-600 text-sm font-medium overflow-hidden whitespace-nowrap text-ellipsis">{{ user?.firstname }} {{ user?.lastname }}</p>
                            <small class="text-[10px] text-slate-600 text-right">{{ formatDate(user?.last_message?.created_at) }}</small>
                        </div>
                        <div class="flex justify-between flex-1">
                            <small class="text-xs text-slate-600 overflow-hidden whitespace-nowrap text-ellipsis">{{ user?.last_message?.message }}</small>
                            <div v-if="user?.unseen_messages" class="message-indicator">{{ user?.unseen_messages }}</div>
                        </div>
                    </div>
                </div>
                <div v-else class="user flex-col">
                    <i class='bx bx-message-dots text-2xl text-slate-500'></i>
                    <p class="text-xs text-slate-600">No chats yet...</p>
                </div>
            </div>
        </section>
        <section v-show="section === 'chat-area'" class="chat-area">
            <!-- chat topbar -->
            <div class="topbar">
                <div class="flex items-center gap-2">
                    <button @click="closeChat" class="flex justify-center items-center w-9 h-9 rounded-lg bg-slate-100">
                        <i class='bx bx-chevron-left text-2xl text-slate-500'></i>
                    </button>
                </div>
                <div class="flex flex-col items-center">
                    <small class="text-sm text-slate-700">{{ selectedUser?.firstname }} {{ selectedUser?.lastname }}</small>
                    <small class="text-xs text-slate-500">{{ selectedUser?.presence }}</small>
                </div>
                <div>
                    <!-- options button -->
                    <button class="flex justify-center items-center w-9 h-9 rounded-lg bg-slate-100">
                        <i class='bx bx-dots-vertical-rounded text-2xl text-slate-500 pointer-events-none'></i>
                    </button>
                </div>
            </div>
            <div ref="chathistory" class="chat-messages">
                <!-- chat messages -->
                <Chatbubble v-if="store.messages.length > 0" v-for="(chat, index) in store.messages" :key="index" :chat="chat"/>
                <div v-else class="preloader">
                    <div class="sk-three-bounce">
                        <div class="sk-child sk-bounce1"></div>
                        <div class="sk-child sk-bounce2"></div>
                        <div class="sk-child sk-bounce3"></div>
                    </div>
                </div>
            </div>
            <div class="w-full py-2 flex items-center absolute bottom-0 left-0 border-t bg-white">
                <!-- chat input -->
                <textarea rows="2" class="flex-1 h-full px-2 outline-none text-slate-700 text-xs bg-transparent resize-none" v-model="message" placeholder="Type your message"/>
                <button @click="sendMessage" :disabled="sending" class="flex justify-center items-center w-9 h-9 rounded-lg text-[#1895B0] disabled:text-slate-500">
                    <i class="bx bx-send text-xl pointer-events-none"></i>
                </button>
            </div>
        </section>
    </section>
</template>
