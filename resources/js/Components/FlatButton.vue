<script>
export default{
    props:{
        loading: {
            type: Boolean,
            default: false
        },
        primary: {
            type: Boolean,
            default: false
        },
        stroke: {
            type: Boolean,
            default: false
        },
        label: {
            type: String,
            default: ''
        }
    },
    data(){
        return {
        }
    }
}
</script>

<template>
    <button type="button" :class="{primary: primary, stroke: stroke}" class="button" :disabled="loading">
        <span>{{ label }} </span>
        <i v-if="loading" class="bx bx-loader bx-spin text-lg"></i>
    </button>
</template>
