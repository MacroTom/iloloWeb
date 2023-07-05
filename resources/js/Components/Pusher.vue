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
            channel: null,
            user_id: null
        }
    },
    watch: {
        auth(){
            if(this.auth?.user){
                this.user_id = this.auth?.user?.id;
                this.pusherInit();
                this.pusherSubscribe();
            }
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
        pusherInit(){
            if(window.Env.debug === 'true'){
                Pusher.logToConsole = true;
            }
            this.pusher = new Pusher(window.Env.pusher.key, {
                encrypted: window.Env.pusher.options.encrypted,
                cluster: window.Env.pusher.options.cluster,
                authEndpoint: window.Env.pusherAuthEndpoint,
                auth: {
                    headers: {
                        "X-CSRF-TOKEN": this.csrfToken,
                    },
                },
            });
        },
        pusherSubscribe(){
            if(this.user_id){
                this.channel = this.pusher.subscribe("chat." + this.user_id);
                this.channel.bind('new-message', (data) => {
                    // handle new-message event
                    store.messages.push(data.payload.message);
                    store.scrollToBottom();
                });
            }
        },
    },
    beforeMount(){
        this.csrfToken = this.getCookie("XSRF-TOKEN");
    },
    mounted(){
        if(this.auth?.user){
            this.user_id = this.auth?.user?.id;
            this.pusherInit();
            this.pusherSubscribe();
        }
    }
}
</script>

<template></template>
