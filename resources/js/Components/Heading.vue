<script>
import { Link } from '@inertiajs/vue3';
import Topbar from '../Components/Topbar.vue';
import Mobiletopbar from '../Components/Mobiletopbar.vue';
import Statusbutton from '../Components/Statusbutton.vue';
import { store } from '../store.js';

export default {
    props: {
        back: String
    },
    components:{
        Topbar, Mobiletopbar, Statusbutton, Link
    },
    data(){
        return {
            store,
        }
    }
}
</script>

<template>
    <Topbar>
        <div v-if="!$page.props.auth?.user"
            class="text-white">
            <button @click="store.toggleFormTab('signin')"
                class="hover:text-white/80">Sign in</button>
            <span> | </span>
            <button @click="store.toggleFormTab('register')"
                class="hover:text-white/80">Register</button>
        </div>
        <div v-else
            class="flex gap-4">
            <Statusbutton
                counter="1"
                icon="bxs-bell" title="Notifications"/>
            <Statusbutton
                icon="bxs-bookmark" title="Saved"/>
            <Statusbutton
                to="/profile/subscriptions"
                icon="bxs-diamond" title="Subscriptions"/>
            <Statusbutton
                to="/profile"
                icon="bxs-bar-chart-alt-2" title="My ads"/>
            <Statusbutton
                counter="8"
                to="/profile/messages"
                icon="bxs-message-dots" title="My messages"/>
            <Statusbutton
                icon="bxs-user"
                title="User"
                :menu="store.menu"
                />
        </div>
    </Topbar>
    <Mobiletopbar :back="back ? back : ''"/>
</template>
