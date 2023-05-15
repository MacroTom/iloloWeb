<script setup>
import { useLayout } from '@/layout/composables/layout';
import { computed } from 'vue';

const { layoutConfig } = useLayout();

const logoUrl = computed(() => {
    return `/images/${layoutConfig.darkTheme.value ? 'logo-white' : 'logo-green'}.png`;
});
</script>

<template>
    <div class="layout-footer">
        <span class="font-medium ml-2 flex items-center"><i class='bx bx-code-alt text-xl mr-2'></i> Developed by <a class="ml-1" href="mailto:info@enastech.com"> ETS</a></span>
    </div>
</template>
<style lang="scss" scoped></style>
