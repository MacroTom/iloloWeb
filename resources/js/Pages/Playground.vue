<script>
export default{
    data(){
        return{
            menu: [
                { label: 'Chicken & Chips', price: 10 },
                { label: 'Burger & Chips', price: 12 },
                { label: 'Fish & Chips', price: 15 },
                { label: 'Pizza & Chips', price: 20 },
                { label: 'Pasta & Chips', price: 18 },
            ],
            newItem: {
                label: '',
                price: 0
            }
        }
    },
    methods:{
        deleteItem(){
            this.menu.pop();
        },
        addItem(){
            // added the item here
            this.menu.push(this.newItem);
            // reset the newItem
            this.newItem = {
                label: '',
                price: 0
            }
        }
    }
}
</script>

<!-- Variables, numbers, arrays, Objects, true false -->

<style scoped>
.heading{
    @apply py-2 text-3xl font-bold bg-slate-50 text-center text-slate-700
}
</style>

<template>
    <h2 class="heading">Horbit Restaurant</h2>
    <ul>
        <li v-for="(item, index) in menu" :key="index">
            {{ item.label }} - N{{ item.price }}
        </li>
    </ul>
    <div class="flex flex-col items-start gap-2 mt-4">
        <input class="border p-2 rounded-lg" v-model="newItem.label" type="text" placeholder="menu item" />
        <input class="border p-2 rounded-lg" v-model="newItem.price" type="number" placeholder="item price" />
        <button class="button text-slate-600" @click="addItem">Save</button>
    </div>
</template>
