import { reactive } from 'vue'

export const store = reactive({
    location: {
        state: null,
        lga: null,
    },
    isDrawerOpen: false,
    toggleDrawer(){
        this.isDrawerOpen = !this.isDrawerOpen
    },
})
