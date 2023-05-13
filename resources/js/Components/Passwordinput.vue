<script>
export default{
    props:{
        placeholder: {
            type: String,
            default: ''
        },
        modelValue: {
            type: String,
        },
        error: {
            type: String,
            default: null
        }
    },
    emits: ['update:modelValue'],
    data(){
        return{
            showPassword: false,
        }
    },
    methods:{
        togglePassword(ev){
            let input = ev.target.previousElementSibling;
            input.type = input.type === 'password' ? 'text' : 'password';
            this.showPassword = !this.showPassword;
        },
    }
}
</script>

<template>
    <div class="border mb-2 p-2 rounded-lg">
        <div class="flex items-center">
            <input class="w-full h-full outline-none pl-1 text-sm" @input="$emit('update:modelValue', $event.target.value)" :value="modelValue" type="password" :placeholder="placeholder"/>
            <div @click="togglePassword($event)"
                class="w-6 h-6 flex justify-center items-center rounded-full lg:hover:bg-slate-50 lg:cursor-pointer"
                >
                <i v-if="!showPassword" class='bx bxs-show text-lg text-black/50 pointer-events-none select-none'></i>
                <i v-else class='bx bxs-hide text-lg text-black/50 pointer-events-none select-none'></i>
            </div>
        </div>
        <span v-if="error" class="text-xs text-red-400">{{ error }}</span>
    </div>
</template>
