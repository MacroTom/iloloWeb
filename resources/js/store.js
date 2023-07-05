import { reactive } from 'vue'

export const store = reactive({
    menu: {
        title: 'User',
        menuitems: [
            { href: '/profile', icon: 'bx-user', name: 'Profile', method: '' },
            { href: '/subscriptions', icon: 'bx-diamond', name: 'Subscriptions', method: '' },
            { href: '/logout', icon: 'bx-exit', name: 'Logout', method: 'post' }
        ]
    },
    profilelinks: [
        {
            href: '/profile/ads',
            match: '/profile/ads',
            label: 'active'
        },
        {
            href: '/profile/ads/review',
            match: '/profile/ads/review',
            label: 'review'
        },
        {
            href: '/profile/ads/closed',
            match: '/profile/ads/closed',
            label: 'closed'
        },
    ],
    location: {
        state: null,
        lga: null,
    },
    isDrawerOpen: false,
    toggleDrawer(){
        this.isDrawerOpen = !this.isDrawerOpen
    },
    chatOpen: false,
    setChat(val){
        this.chatOpen = val
    },
    device: {
        screen: '',
        orientation: ''
    },
    detectDevice(){
        this.device = {
            screen: !!navigator.maxTouchPoints ? 'mobile' : 'computer',
            orientation: !navigator.maxTouchPoints ? 'desktop' : !window.screen.orientation.angle ? 'portrait' : 'landscape'
        }
        // console.log(this.device.screen);
    },
    showFormTab: false,
    formaction: 'signin',
    formscreen: 'options',
    alertMessage: {},
    setAlertMessage(text, variant, duration=5000){
        let id = new Date().getTime();
        this.alertMessage[id] = {
            id: id,
            text: text,
            variant: variant,
            duration: duration,
            seen: false
        }
    },
    messageSeen(id){
        if(this.alertMessage && (id in this.alertMessage)){
            delete this.alertMessage[id];
        }
    },
    snackbars:null,
    snackbar: {
        add:(properties)=>{
            let id = new Date().getTime();
            store.snackbars = {
                id: id,
                message: properties.message,
                severity: properties.severity
            }
            setTimeout(()=>{
                store.snackbars = null
            },3000);
        },
        close:()=>{
            store.snackbars = null
        }
    },
    setFormScreen(screen){
        this.formscreen = screen
    },
    setFormAction(action){
        this.formaction = action
    },
    toggleFormTab(action=null){
        this.showFormTab = !this.showFormTab
        this.setFormScreen('options')
        action && this.setFormAction(action)
    },
    messages: [],
    history: '',
    scrollToBottom(){
        setTimeout(()=>{
            this.history.scrollTop = this.history.scrollHeight
        }, 0)
    },
    chatWindow: false,
    chatWindowPage: 'Chat',
    gotoWindow(page='Chat'){
        this.chatWindow = true
        this.chatWindowPage = page
    },
    toggleChatWindow(page=null){
        this.chatWindow = !this.chatWindow
        page && (this.chatWindowPage = page)
    }
})
