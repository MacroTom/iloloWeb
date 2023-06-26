<script>
import { Link } from '@inertiajs/vue3';
import DropDownList from './DropDownList.vue';
import axios from 'axios';
import { store } from '../store.js';
export default{
    props:{
        bg: {
            type: String,
            default: 'bg-white'
        },
        border: {
            type: String,
            default: 'border-b'
        },
        styles:{
            type: String
        },
        scroll: Boolean
    },
    components:{
        Link,
        DropDownList
    },
    data(){
        return{
            store,
            categories: [],
            menuOpen: false,
            showCategory: false,
            selectedSubcategory: null,
            showPopup: false,
            showMobilePopup: false,
            background: '',
        }
    },
    methods:{
        async getCategories(){
            this.categories = (await axios.get("/api/categories")).data.data;
        },
        toggleSubMenu(index){
            if(this.selectedSubcategory === null || this.selectedSubcategory !== index){
                this.selectedSubcategory = index;
            }
            else if(this.selectedSubcategory === index){
                this.selectedSubcategory = null;
            }
        },
        hidePopup(){
            this.showPopup = false;
        },
        hideMobilePopup(){
            this.showMobilePopup = false;
        },
        handleScroll(e){
            let scrollPos = document.body.scrollTop || document.documentElement.scrollTop;

            if(scrollPos === 0){
                this.background = this.bg;
            }
            else{
                this.background = "bg-white border-b";
            }
        },
    },
    mounted(){
        this.getCategories();
        if(this.scroll){
            window.addEventListener("scroll", this.handleScroll, false);
        }
        else{
            this.background = this.bg;
        }
    }
}
</script>

<style scoped>
nav *{
    @apply font-Inter
}
.nav-links{
    @apply flex lg:flex flex-col gap-2 lg:flex-row lg:gap-6
}
.nav-links > li,
.nav-links li a{
    @apply font-Inter lg:text-sm text-slate-700
}
.nav-links > li{
    @apply p-2
}
.nav-links li.divider{
    @apply my-4 w-full h-[1px] border-t !important
}
.nav-links > li:nth-child(5){
    @apply py-0
}
.nav-links > li:nth-child(6){
    @apply py-0
}
.child-links{
    @apply flex-col gap-y-2
}
.child-links li{
    @apply flex flex-col
}
.child-links li a{
    @apply font-Inter font-semibold text-sm text-[#1895B0]
}
.inner-links li a{
    @apply font-Inter font-semibold text-sm text-slate-600 gap-y-2
}
.popup{
    @apply min-w-[200px] absolute right-0 top-[60px] bg-white rounded-lg shadow
}
.popup::before{
    content: "";
    position: absolute;
    top: -10px;
    right: 10px;
    width: 0;
    height: 0;
    border-left: 10px solid transparent;
    border-right: 10px solid transparent;
    border-bottom: 10px solid white;
}
.popup *{
    @apply text-xs
}
.popup a{
    @apply text-slate-800 w-full flex flex-1
}
.popup li{
    @apply flex justify-between items-center px-3 py-2 hover:bg-slate-50
}
.popup li i{
    @apply text-sm text-slate-500
}
.menu-buttons{
    @apply w-10 h-10 rounded-lg relative z-[1] flex justify-center items-center cursor-pointer
}
.menu-buttons i{
    @apply text-xl text-slate-700
}
</style>

<template>
    <!-- For larger screens -->
    <nav :class="background +' '+ border +' '+ styles" class="hidden lg:flex w-full h-[60px] lg:px-8 xl:px-28 items-center fixed z-[500] top-0 left-0">
        <div class="mr-10">
            <Link href="/">
                <img width="80" src="/images/logo-green.png" alt="logo">
            </Link>
        </div>
        <ul class="flex-1 nav-links">
            <li><Link href="/">Home</Link></li>
            <DropDownList
                title="Categories"
                :items="categories"
                :itemsLabel="['title','adverts']"
                innerList="subcategories"/>
            <li><Link href="/profile/subscriptions">Pricing</Link></li>
            <li><Link href="#">Contact</Link></li>
        </ul>
        <div class="mr-6">
            <div class="flex items-center px-2 py-1 rounded-lg bg-slate-400/10">
                <input class="flex-1 text-sm bg-transparent outline-none text-slate-600 placeholder:text-slate-600" type="text" placeholder="Search"/>
                <div class="cursor-pointer"><i class='text-xl pointer-events-none bx bx-search-alt text-slate-600'></i></div>
            </div>
        </div>
        <div v-if="!$page.props.auth?.user" class="flex gap-4">
            <button @click="store.toggleFormTab('signin')" class="button bg-slate-50">Log in</button>
            <button @click="store.toggleFormTab('register')" class="button primary">Sign up</button>
        </div>
        <div v-else class="flex items-center gap-6">
            <div class="flex items-center gap-6">
                <div class="menu-buttons">
                    <i class='bx bx-bell'></i>
                    <div class="pulse"></div>
                </div>
                <div class="menu-buttons">
                    <i class='bx bx-message-dots'></i>
                    <div class="pulse"></div>
                </div>
            </div>
            <div class="w-10 h-10 flex justify-center items-center rounded-lg active:bg-[#e6eff1] relative" v-click-away="hidePopup">
                <img @click="showPopup = !showPopup" class="object-cover rounded-lg border-[2px] shadow cursor-pointer" :src="$page.props.auth?.user?.avatar" alt="avatar"/>
                <div :class="showPopup ? '' : 'hidden'" class="popup" @click="hidePopup">
                    <header class="flex items-center w-full gap-2 px-3 py-2">
                        <div class="flex items-center justify-center rounded-lg w-9 h-9">
                            <img class="object-cover rounded-lg border-[2px] shadow" width="36" :src="$page.props.auth?.user?.avatar" alt="avatar"/>
                        </div>
                        <div class="flex flex-col font-Inter">
                            <p class="overflow-hidden font-medium text-slate-700 whitespace-nowrap text-ellipsis">{{ $page.props.auth?.user?.firstname }} {{ $page.props.auth?.user?.lastname }}</p>
                            <small class="overflow-hidden text-slate-500 whitespace-nowrap text-ellipsis">{{ $page.props.auth?.user?.email }}</small>
                        </div>
                    </header>
                    <ul class="w-full py-2 border-y">
                        <li>
                            <Link href="/profile">View Profile</Link>
                            <i class='bx bx-chevron-right'></i>
                        </li>
                        <li>
                            <Link href="#">My ads</Link>
                            <i class='bx bx-chevron-right'></i>
                        </li>
                        <li>
                            <Link href="#">Bookmarks</Link>
                            <i class='bx bx-chevron-right'></i>
                        </li>
                    </ul>
                    <div class="w-full p-3 rounded-b-lg hover:bg-slate-50">
                        <Link method="post" as="button" href="/logout">Log out</Link>
                    </div>
                </div>
            </div>
            <Link href="/postad" class="button primary">Post ad</Link>
        </div>
    </nav>

    <!-- For small screens -->
    <nav :class="background +' '+ border +' '+ styles" class="w-full lg:hidden h-[60px] px-4 flex items-center fixed z-[500] top-0 left-0">
        <div class="relative flex items-center justify-between flex-1">
            <div @click="menuOpen = !menuOpen"><i :class="menuOpen ? 'bx-x' : 'bx-menu'" class='text-2xl bx text-slate-700'></i></div>
            <Link href="/">
                <img width="80" src="/images/logo-green.png" alt="logo"/>
            </Link>
            <div class="w-10 h-10 flex flex-shrink-0 justify-center items-center rounded-lg active:bg-[#e6eff1]">
                <div class="relative" v-if="$page.props.auth?.user" v-click-away="hideMobilePopup">
                    <img @click="showMobilePopup = !showMobilePopup" class="object-cover rounded-lg shadow" :src="$page.props.auth?.user?.avatar" alt="avatar"/>
                    <div :class="showMobilePopup ? '' : 'hidden'" class="popup">
                        <header class="flex items-center w-full gap-2 px-3 py-2">
                            <div class="flex items-center justify-center rounded-lg w-9 h-9">
                                <img class="object-cover rounded-lg border-[2px] shadow" :src="$page.props.auth?.user?.avatar" alt="avatar"/>
                            </div>
                            <div class="flex flex-col font-Inter">
                                <p class="overflow-hidden font-medium text-slate-700 whitespace-nowrap text-ellipsis">{{ $page.props.auth?.user?.firstname }} {{ $page.props.auth?.user?.lastname }}</p>
                                <small class="overflow-hidden text-slate-500 whitespace-nowrap text-ellipsis">{{ $page.props.auth?.user?.email }}</small>
                            </div>
                        </header>
                        <ul class="w-full py-2 border-y">
                            <li>
                                <Link href="/profile">View Profile</Link>
                                <i class='bx bx-chevron-right'></i>
                            </li>
                            <li>
                                <Link href="#">My ads</Link>
                                <i class='bx bx-chevron-right'></i>
                            </li>
                            <li>
                                <Link href="#">Bookmarks</Link>
                                <i class='bx bx-chevron-right'></i>
                            </li>
                        </ul>
                        <div class="w-full p-3 rounded-b-lg hover:bg-slate-50">
                            <Link method="post" as="button" href="/logout">Log out</Link>
                        </div>
                    </div>
                </div>
                <div v-else @click="store.toggleFormTab('signin')">
                    <i class='text-2xl bx bx-user text-slate-600 pointer-events-none'></i>
                </div>
            </div>
        </div>
        <ul :class="menuOpen ? 'left-0' : '-left-full'" class="nav-links w-full min-h-[calc(100vh-60px)] max-h-[calc(100vh-60px)] px-4 pt-4 bg-white absolute top-[60px] transition-[left] duration-200 ease-in">
            <li><Link class="font-semibold" href="/">Home</Link></li>
            <li>
                <div class="flex items-center w-full">
                    <Link class="flex-1 font-semibold" href="#">Categories</Link>
                    <div @click="showCategory = !showCategory"><i :class="showCategory ? 'bx-chevron-up' : 'bx-chevron-down'" class='text-2xl bx text-slate-600'></i></div>
                </div>
                <ul :class="showCategory ? 'flex' : 'hidden'" class="child-links">
                    <li v-for="(category,index) in categories" :key="index">
                        <div class="flex justify-between w-full">
                            <div class="flex flex-col mb-1">
                                <Link href="#">{{ category.title }}</Link>
                                <small>{{ category.adverts }}</small>
                            </div>
                            <div @click="toggleSubMenu(index)"><i :class="selectedSubcategory === index ? 'bx-chevron-up' : 'bx-chevron-down'" class='bx text-2xl text-[#1895B0]'></i></div>
                        </div>
                        <ul :class="selectedSubcategory === index ? 'block' : 'hidden'" class="inner-links">
                            <li v-for="(category,index) in category.subcategories" :key="index">
                                <div class="flex justify-between w-full">
                                    <div class="flex flex-col">
                                        <Link href="#">{{ category.title }}</Link>
                                        <small>{{ category.adverts }}</small>
                                    </div>
                                    <div><i class='text-xl bx bx-chevron-right text-slate-500'></i></div>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li><Link class="font-semibold" href="/profile/subscriptions">Pricing</Link></li>
            <li><Link class="font-semibold" href="#">Contact</Link></li>
        </ul>
    </nav>
</template>
