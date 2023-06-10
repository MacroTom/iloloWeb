<script>
import { store } from '../store';
export default{
    data(){
        return{
            store,
            iconType: {
                info: 'bx-info-circle',
                success: 'bx-check-circle',
                warning: 'bx-error-circle',
                danger: 'bx-error'
            },
            body: {
                info: 'bg-[#e9e9ff] text-[#696cff]',
                success: 'bg-[#1895B0] text-white',
                warning: 'bg-[#fff2e2] text-[#CC8925]',
            }
        }
    },
    methods:{
        closeSnackbar(){
            this.$refs.snackbar?.classList.remove('opacity-100');
            this.$refs.snackbar?.classList.add('opacity-0');
            setTimeout(()=>{
                this.store.snackbar.close();
            }, 300);
        }
    },
    mounted(){
    }
}
</script>

<template>
    <section v-if="store.snackbars" ref="snackbar" class="w-full fixed left-0 top-0 md:top-[70px] z-[9999999] md:pr-3 md:flex md:justify-end transition-opacity duration-300 opacity-100">
        <main :class="body[store.snackbars?.severity]"
            class="w-full md:w-5/12 lg:w-3/12 xl:w-2/12 h-[70px] overflow-hidden md:h-[50px] px-4 shadow md:rounded-lg flex items-center gap-3">
            <div>
                <!-- icon -->
                <i :class="iconType[store.snackbars?.severity]" class='bx text-xl'></i>
            </div>
            <div class="flex-1 text-sm">{{ store.snackbars?.message }}</div>
            <div class="cursor-pointer" @click="closeSnackbar">
                <i class='bx bx-x text-xl'></i>
            </div>
        </main>
    </section>
</template>
