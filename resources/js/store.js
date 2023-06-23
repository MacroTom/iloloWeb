import { reactive } from 'vue'

export const store = reactive({
    menu: {
        title: 'User',
        menuitems: [
            { href: '/profile', icon: 'bx-user', name: 'Profile', method: '' },
            { href: '/profile/subscriptions', icon: 'bx-diamond', name: 'Subscriptions', method: '' },
            { href: '/logout', icon: 'bx-exit', name: 'Logout', method: 'post' }
        ]
    },
    profiletabs: [
        { title: 'Active', counter: 3, key: 'activetab', href: '/profile/ads/active' },
        { title: 'Reviewing', counter: 1, key: 'reviewtab', href: '/profile/ads/review' },
        { title: 'Manage Ads', counter: null, key: 'managetab', href: '#' },
        { title: 'Closed Ads', counter: 3, key: 'closedtab', href: '/profile/ads/closed' }
    ],
    feedbacktabs: [
        { title: 'Sent', counter: 1, key: 'sent', href: '/profile/feedback' },
        { title: 'Received', counter: 3, key: 'received', href: '/profile/opinions' }
    ],
    profileoptions:[
        { title: 'My Advert', icon: 'bxs-bar-chart-alt-2', counter: 3, href: '/profile' },
        { title: 'My Messages', icon: 'bxs-chat', counter: null, href: '/profile/messages' },
        { title: 'Subscriptions', icon: 'bxs-gift', counter: null, href: '/profile/subscriptions' },
        { title: 'Feedback', icon: 'bxs-comment', counter: null, href: '/profile/feedback' },
        { title: 'Bookmark', icon: 'bxs-bookmark', counter: null, href: '/profile/bookmark' },
        { title: 'FAQ', icon: 'bx-question-mark', counter: null, href: '/profile/faq' },
        { title: 'Log out', icon: 'bxs-exit', counter: null, href: '/logout', method: 'post' },
    ],
    ads: {
        active: [
            {
                id: 1,
                name: 'Ferragamo shoe (Oxford)',
                image: '/images/product.png',
                price: '45,000',
                status: 'active',
                views: 100,
                impression: 201
            },
            {
                id: 2,
                name: 'Ferragamo shoe (Oxford)',
                image: '/images/product.png',
                price: '45,000',
                status: 'active',
                views: 100,
                impression: 201
            },
            {
                id: 3,
                name: 'Ferragamo shoe (Oxford)',
                image: '/images/product.png',
                price: '45,000',
                status: 'active',
                views: 100,
                impression: 201
            },
        ],
        review: [
            {
                id: 1,
                name: 'Ferragamo shoe (Oxford)',
                image: '/images/product.png',
                price: '45,000',
                status: 'review',
                views: 100,
                impression: 201
            },
        ],
        closed: [
            {
                id: 1,
                name: 'Ferragamo shoe (Oxford)',
                image: '/images/product.png',
                price: '45,000',
                status: 'closed',
                views: 100,
                impression: 201
            },
            {
                id: 2,
                name: 'Ferragamo shoe (Oxford)',
                image: '/images/product.png',
                price: '45,000',
                status: 'closed',
                views: 100,
                impression: 201
            },
            {
                id: 3,
                name: 'Ferragamo shoe (Oxford)',
                image: '/images/product.png',
                price: '45,000',
                status: 'closed',
                views: 100,
                impression: 201
            },
        ],
    },
    feeds:{
        sent:[
            {
                avatar: null, user: 'John Doe', reaction: '&#x1F60A;',
                date: '10/12/2022',
                text: 'Great customer service and good product quality'
            },
        ],
        received:[
            {
                avatar: null, user: 'John Doe', reaction: '&#x1F60A;',
                date: '10/12/2020',
                text: 'Great customer service and good product quality',
                position: 'left'
            },
            {
                avatar: null, user: 'John Doe', reaction: '&#x1F60A;',
                date: '10/12/2021',
                text: 'Great customer service and good product quality',
                position: 'right'
            },
            {
                avatar: null, user: 'John Doe', reaction: '&#x1F60A;',
                date: '10/12/2022',
                text: 'Great customer service and good product quality',
                position: 'left'
            },
            {
                avatar: null, user: 'John Doe', reaction: '&#x1F60A;',
                date: '10/12/2021',
                text: 'Great customer service and good product quality',
                position: 'right'
            },
            {
                avatar: null, user: 'John Doe', reaction: '&#x1F60A;',
                date: '10/12/2022',
                text: 'Great customer service and good product quality',
                position: 'left'
            },
            {
                avatar: null, user: 'John Doe', reaction: '&#x1F60A;',
                date: '10/12/2021',
                text: 'Great customer service and good product quality',
                position: 'right'
            },
            {
                avatar: null, user: 'John Doe', reaction: '&#x1F60A;',
                date: '10/12/2022',
                text: 'Great customer service and good product quality',
                position: 'left'
            },
            {
                avatar: null, user: 'John Doe', reaction: '&#x1F60A;',
                date: '10/12/2021',
                text: 'Great customer service and good product quality',
                position: 'right'
            },
            {
                avatar: null, user: 'John Doe', reaction: '&#x1F60A;',
                date: '10/12/2022',
                text: 'Great customer service and good product quality',
                position: 'left'
            },
            {
                avatar: null, user: 'John Doe', reaction: '&#x1F60A;',
                date: '10/12/2021',
                text: 'Great customer service and good product quality',
                position: 'right'
            },
            {
                avatar: null, user: 'John Doe', reaction: '&#x1F60A;',
                date: '10/12/2022',
                text: 'Great customer service and good product quality',
                position: 'left'
            },
            {
                avatar: null, user: 'John Doe', reaction: '&#x1F60A;',
                date: '10/12/2021',
                text: 'Great customer service and good product quality',
                position: 'right'
            },
            {
                avatar: null, user: 'John Doe', reaction: '&#x1F60A;',
                date: '10/12/2022',
                text: 'Great customer service and good product quality',
                position: 'left'
            },
            {
                avatar: null, user: 'John Doe', reaction: '&#x1F60A;',
                date: '10/12/2021',
                text: 'Great customer service and good product quality',
                position: 'right'
            },
            {
                avatar: null, user: 'John Doe', reaction: '&#x1F60A;',
                date: '10/12/2022',
                text: 'Great customer service and good product quality',
                position: 'left'
            },
        ]
    },
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
})
