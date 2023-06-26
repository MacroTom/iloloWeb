<script>
export default{
    props:{
        items:{
            type: Array,
            default: [],
        },
        itemsLabel:{
            type: Array,
            required: true
        },
        innerList: String,
        title: String
    },
    data(){
        return{
            open: false,
            innerOpen: false,
            selectedItem: 0
        }
    },
    methods:{
        handleClickAway(){
            if(this.open){
                this.open = false;
            }
            if(this.innerOpen){
                this.innerOpen = false;
            }
        }
    }
}
</script>

<style scoped>
.nav-dropdown *{
    @apply font-Inter
}
.nav-dropdown{
    @apply relative flex items-center
}
.nav-dropdown span {
    @apply lg:cursor-pointer
}
.nav-dropdown::before{
    content: "\ea4a";
    position: absolute;
    right: -8px;
    font-size: 16px;
}
.nav-dropdown .child-links{
    @apply w-[300px] py-2 max-h-[250px] h-fit scrollbar-hide flex-col absolute top-[55px] shadow bg-white min-h-[100px]
}
.nav-dropdown .child-links li{
    @apply px-4 py-2
}
.nav-dropdown .child-links::before{
    content: "";
    position: absolute;
    top: -12px;
    left: 20px;
    width: 0;
    height: 0;
    border-left: 12px solid transparent;
    border-right: 12px solid transparent;
    border-bottom: 12px solid white;
}
.child-links .inner-links{
    @apply w-[300px] h-fit max-h-[250px] overflow-y-scroll scrollbar-hide flex-col rounded-tr-lg rounded-br-lg absolute top-0 right-[-300px] shadow bg-white
}
</style>

<template>
    <li class="nav-dropdown bx" v-click-away="handleClickAway">
        <span @click="open = !open">{{ title }}</span>
        <ul :class="open ? 'flex' : 'hidden', innerOpen ? 'rounded-tl-lg rounded-bl-lg' : 'rounded-lg'" class="child-links">
            <li @mouseenter="innerOpen = true" @mouseleave="innerOpen = false;" class="lg:cursor-pointer flex gap-x-2 items-center justify-between hover:bg-slate-50 group" v-for="(item,index) in items" :key="index">
                <div class="group">
                    <p class="font-semibold" v-if="itemsLabel?.length > 1">
                        {{ item[itemsLabel[0]] }}
                    </p>
                    <small class="text-slate-500">
                        {{ item[itemsLabel[1]] }}
                    </small>
                </div>
                <div><i class='bx bx-chevron-right text-slate-400'></i></div>
                <ul class="inner-links hidden group-hover:flex">
                    <li class="p-2 lg:cursor-pointer flex gap-x-2 items-center justify-between hover:bg-slate-50" v-for="(inner,index) in item[innerList]" :key="index">
                        <div>
                            <p class="font-semibold" v-if="itemsLabel?.length > 1">
                                {{ inner[itemsLabel[0]] }}
                            </p>
                            <small class="text-slate-500">
                                {{ inner[itemsLabel[1]] }}
                            </small>
                        </div>
                        <div><i class='bx bx-chevron-right text-slate-400'></i></div>
                    </li>
                </ul>
            </li>
        </ul>
    </li>
</template>
