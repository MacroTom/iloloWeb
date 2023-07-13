<script>
import { store } from '../store.js';
export default{
    props:{
        auth: Object
    },
    data(){
        return{
            store
        }
    },
    watch:{
        'store.notifications'(){
            this.unSeenNotificationCount();
        },
        auth(){
            this.auth?.user && this.getNotifications();
        },
    },
    methods:{
        unSeenNotificationCount(){
            store.unseen_notifications = store.notifications.filter(notification => (notification.read_at === null)).length;
        },
        getNotifications(){
            axios.get('/profile/getnotifications')
            .then(res => {
                store.notifications = res.data?.notifications;
            })
            .catch(error => {
                console.log(error);
                this.store.snackbar.add({
                    message: "Notifications not loaded!",
                    severity: "warning"
                });
            });
        },
    },
    mounted(){
        this.auth?.user && this.getNotifications();
    }
}
</script>

<template></template>
