<script>
export default{
    props: ['status'],
    emits:['update:status','status'],
    data(){
        return{
            isOnLine: navigator.onLine
        }
    },
    methods:{
        updateStatus(e){
            this.isOnLine = navigator.onLine;
            this.$emit('update:status', this.isOnLine);
            this.$emit('status', e);
        }
    },
    created(){
        window.addEventListener('online', this.updateStatus);
        window.addEventListener('offline', this.updateStatus);
    },
    beforeDestroy() {
        window.removeEventListener('online', this.updateStatus);
        window.removeEventListener('offline', this.updateStatus);
    },
}
</script>

<template></template>
