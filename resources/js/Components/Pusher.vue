<script>
import { store } from '../store.js';
export default{
    props: {
        auth: Object
    },
    data(){
        return{
            store,
            csrfToken: null,
            pusher: null,
            chatChannel: null,
            presenceChannel: null,
            alertsChannel: null,
            user_id: null,
            message_data: null
        }
    },
    watch: {
        auth(){
            if(this.auth?.user){
                this.user_id = this.auth?.user?.id;
                this.pusherSubscribe();
            }
            else{
                this.pusherUnsubscribe();
            }
        },
        message_data(){
            setTimeout(() => {
                store.messages.push(this.message_data.message);
                store.scrollToBottom();
                store.getUsers();
                if(store.selectedUser && store.selectedUser.id === this.message_data.message.from.id){
                    store.markMessagesAsSeen();
                }
            }, 1000);
        }
    },
    methods:{
        getCookie(name) {
            var cookieArr = document.cookie.split(";");

            for(var i = 0; i < cookieArr.length; i++) {
                var cookiePair = cookieArr[i].split("=");

                if(name == cookiePair[0].trim()) {
                    return decodeURIComponent(cookiePair[1]);
                }
            }

            return null;
        },
        getCsrfToken(){
            return this.getCookie("XSRF-TOKEN");
        },
        pusherInit(){
            if(this.$page.props.env.pusherDebug === true || this.$page.props.env.pusherDebug === 'true'){
                Pusher.logToConsole = true;
            }
            store.pusher = new Pusher(window.Env.pusher.key, {
                encrypted: window.Env.pusher.options.encrypted,
                cluster: window.Env.pusher.options.cluster,
                authEndpoint: this.$page.props.env.pusherAuthEndpoint,
                auth: {
                    headers: {
                        "Accept": "application/json"
                    },
                },
            });
        },
        pusherSubscribe(){
            if(this.user_id){
                let env = this.$page.props.env;
                this.chatChannel = store.pusher.subscribe(env.chatChannel + "." + this.user_id);
                this.alertsChannel = store.pusher.subscribe(env.alertsChannel + "." + this.user_id);
                this.presenceChannel = store.pusher.subscribe(env.presenceChannel);
                this.pusherListener();
            }
        },
        pusherUnsubscribe(){
            this.chatChannel?.unsubscribe();
            this.alertsChannel?.unsubscribe();
            this.presenceChannel?.unsubscribe();
        },
        pusherListener(){
            let timeout = 3000;
            this.chatChannel.bind('new-message', (data) => {
                // handle new-message event
                this.message_data = data;
            });

            this.chatChannel.bind('new-alert', (data) => {
                // handle new-alert event
                // store.notifications.push(data.notification);
            });

            this.presenceChannel.bind('pusher:member_added', (member) => {
                // handle member_added event
                setTimeout(() => {
                    store.getUsers();
                }, timeout);
                if(store.selectedUser && store.selectedUser.id === parseInt(member.id)){
                    store.selectedUser.presence = "online";
                }
            });

            this.presenceChannel.bind('pusher:member_removed', (member) => {
                // handle member_removed event
                setTimeout(() => {
                    store.getUsers();
                }, timeout);
                if(store.selectedUser && store.selectedUser.id === parseInt(member.id)){
                    store.selectedUser.presence = "offline";
                }
            });
        }
    },
    beforeMount(){
        this.pusherInit();
        if(this.auth?.user){
            this.user_id = this.auth?.user?.id;
            this.pusherSubscribe();
        }
        else{
            this.pusherUnsubscribe();
        }
    },
    beforeDestroy() {
        this.chatChannel?.unsubscribe();
        this.alertsChannel?.unsubscribe();
        this.presenceChannel?.unsubscribe();
        store.pusher?.disconnect();
        store.pusher = null;
    }
}
</script>

<template></template>
