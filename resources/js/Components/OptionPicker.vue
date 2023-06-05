<script>
export default{
    props:{
        first: {
            type: String,
        },
        second: {
            type: String,
        },
        options: {
            type: Object,
            required: true
        },
        label: String,
        required: Boolean
    },
    emits: ['update:first', 'update:second'],
    data(){
        return{
            selectedOption: '',
            open: false,
            level: 1,
        }
    },
    methods:{
        capitalise(str){
            return str.charAt(0).toUpperCase() + str.slice(1);
        },
        handleClick(option){
            switch (this.level) {
                case 1:
                    this.$emit('update:first', option);
                    if(this.options?.second){
                        this.level++;
                        this.$refs.dropdown.scrollTop = 0;
                    }
                    else{
                        this.selectedOption = option;
                        this.open = !this.open;
                    }
                break;
                case 2:
                    this.$emit('update:second', option);
                    this.selectedOption = option;
                    this.open = !this.open;
                    this.level = 1;
                break;
            }
        },
        handleClickAway(event){
            if(this.open && event.target !== this.$refs.toggler && !event.target.classList.contains('dropdownitem')){
                this.open = !this.open;
            }
        }
    },
}
</script>

<template>
    <div class="advert-control w-full relative">
        <label v-if="label">{{capitalise(label)}}{{ required ? '*' : '' }}</label>
        <div class="relative">
            <input type="text" class="lg:read-only:cursor-pointer" @click="open = !open" :value="options?.second ? second : first" readonly/>
            <div class="absolute right-0 lg:cursor-pointer" @click="open = !open" ref="toggler">
                <i class='bx bx-chevron-down text-2xl text-slate-500 pointer-events-none'></i>
            </div>
        </div>

        <ul v-if="open" ref="dropdown" v-click-away="handleClickAway">
            <template v-if="level === 1">
                <li v-for="(option, key) in options?.first"
                    :key="key"
                    @click="handleClick(option)"
                    class="dropdownitem">
                    {{capitalise(option)}}
                </li>
            </template>
            <template v-else>
                <li v-for="(option, key) in options?.second"
                    :key="key"
                    @click="handleClick(option)"
                    class="dropdownitem"
                    >
                    {{capitalise(option)}}
                </li>
            </template>
        </ul>
    </div>
</template>
