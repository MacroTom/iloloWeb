<script>
export default{
    props:{
        label: String,
        levels: {
            type: Array,
            required: true,
            default: [
                {
                    data: 'title', output: 'id'
                },
                {
                    src: 'subcategories', data: 'title', output: 'id'
                }
            ]
        },
        required: {
            type: Boolean,
            default: true
        },
        value: String,
        options: {
            type: Array,
            required: true
        },
        parent: {},
        child: {}
    },
    emits: ['update:value','update:parent','update:child','change'],
    data(){
        return{
            open: false,
            level: 0,
            selectedPos: null
        }
    },
    methods:{
        capitalise(str){
            return str.charAt(0).toUpperCase() + str.slice(1);
        },
        handleClick(option,index){
            this.selectedPos = index;
            this.$emit('change');
            switch (this.level) {
                // Parent level
                case 0:
                    this.$emit('update:parent', option[this.levels[0]?.output]);
                    if(this.levels.length > 1){
                        this.$emit('update:value', '');
                        this.level++;
                    }
                    else{
                        this.$emit('update:value', option[this.levels[0]?.src ? this.levels[0]?.src : this.levels[0]?.data]);
                        this.open = !this.open;
                    }
                break;

                // Child level
                case 1:
                    this.$emit('update:child', option[this.levels[1]?.output]);
                    this.$emit('update:value', option[this.levels[1]?.data]);
                    this.open = !this.open;
                    this.level = 0;
                break;
            }
        },
        handleClickAway(event){
            if(this.open && event.target !== this.$refs.toggler && !event.target.classList.contains('dropdownitem')){
                this.open = !this.open;
                this.level = 0;
            }
        }
    },
    mounted(){
        this.list = this.options;
    }
}
</script>

<template>
    <div class="advert-control w-full relative">
        <label v-if="label">{{capitalise(label)}}{{ required ? '*' : '' }}</label>
        <div class="relative">
            <input type="text" class="lg:read-only:cursor-pointer" @click="open = !open" :value="value" readonly/>
            <div class="absolute right-0 lg:cursor-pointer" @click="open = !open" ref="toggler">
                <i class='bx bx-chevron-down text-2xl text-slate-500 pointer-events-none'></i>
            </div>
        </div>

        <ul v-if="open" ref="dropdown" v-click-away="handleClickAway">
            <template v-if="level === 0">
                <li v-for="(option, key) in options"
                    :key="key"
                    @click="handleClick(option, key)"
                    class="dropdownitem">
                    {{option[levels[0]?.src ? levels[0]?.src : levels[0]?.data]}}
                </li>
            </template>
            <template v-else>
                <li v-for="(option, key) in options[selectedPos][levels[1].src]"
                    :key="key"
                    @click="handleClick(option, key)"
                    class="dropdownitem">
                    {{option[levels[1]?.data]}}
                </li>
            </template>
        </ul>
    </div>
</template>
