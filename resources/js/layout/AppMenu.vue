<script setup>
import { ref } from 'vue';

import AppMenuItem from './AppMenuItem.vue';

const prefix = "/admin/";

const model = ref([
    {
        label: 'Home',
        items: [{ label: 'Dashboard', icon: 'pi pi-fw pi-home', to: prefix+'dashboard' }]
    },
    {
        label: 'Pages',
        items: [
            { label: 'Plans', icon: 'pi pi-fw pi-wallet', to: prefix+'plans' },
            { label: 'Users', icon: 'pi pi-fw pi-user', to: prefix+'users' },
            { label: 'Admins', icon: 'pi pi-fw pi-verified', to: prefix+'admins' },
            { label: 'Adverts', icon: 'pi pi-fw pi-chart-bar', to: prefix+'adverts' },
            { label: 'Properties', icon: 'pi pi-fw pi-th-large', to: prefix+'properties' },
            { label: 'Categories', icon: 'pi pi-fw pi-list', to: prefix+'categories' },
            { label: 'Transactions', icon: 'pi pi-fw pi-shopping-cart', to: '#' },
            { label: 'Subcategories', icon: 'pi pi-fw pi-list', to: prefix+'subcategories' },
        ]
    }
]);
</script>

<template>
    <ul class="layout-menu">
        <template v-for="(item, i) in model" :key="item">
            <app-menu-item v-if="!item.separator" :item="item" :index="i"></app-menu-item>
            <li v-if="item.separator" class="menu-separator"></li>
        </template>
        <!-- <li>
            <a href="https://www.primefaces.org/primeblocks-vue/#/" target="_blank">
                <img src="/layout/images/banner-primeblocks.png" alt="Prime Blocks" class="w-full mt-3" />
            </a>
        </li> -->
    </ul>
</template>

<style lang="scss" scoped></style>
