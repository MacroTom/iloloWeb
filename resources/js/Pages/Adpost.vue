<script>
import { Head } from '@inertiajs/vue3';
import Heading from '../Components/Heading.vue';
import Bottomnavigationbar from '../Components/Bottomnavigationbar.vue';
export default{
    components:{
        Head,
        Heading,
        Bottomnavigationbar
    },
    data(){
        return{
            currentStep: 1,
            form: {
                photos: [],
                category: null,
                location: null,
                title: '',
                type: '',
                condition: '',
                brand: '',
                color: '',
                description: '',
                price: '',
                negotiable: false,
            },
            preview: [],
            processing: false,
        }
    },
    methods:{
        onFileChange(e) {
            const file = e.target.files[0];
            if((file.type === 'image/png' || file.type === 'image/jpeg') && file.size < 5242880){
                this.form.photos.push(file);
                this.preview.push(URL.createObjectURL(file));
            }
        },
        deleteFile(pos){
            (pos < this.form.photos.length && pos > -1) && this.form.photos.splice(pos,1);
            (pos < this.preview.length && pos > -1) && this.preview.splice(pos,1);
        }
    },
    mounted(){
        const body = document.body;
        var classval;
        for (let index = 0; index < body.classList.length; index++) {
            classval = body.classList[index];
            if(classval.includes('bg-')){
                body.classList.remove(classval);
            }
        }
        body.classList.add('bg-slate-100');
    },
}
</script>

<template>
    <Head>
        <title>Post ad</title>
    </Head>
    <div class="hidden lg:block">
        <Heading/>
    </div>
    <section class="w-full max-h-[calc(100vh-60px)] overflow-y-auto relative flex md:items-center justify-center lg:top-[60px] min-h-[calc(100vh-40px-60px)] lg:min-h-[calc(100vh-60px)] px-2 pt-2 lg:pt-6 lg:p-8">
        <main class="w-full h-fit md:w-8/12 lg:w-6/12 xl:w-5/12 bg-white lg:min-h-[200px] p-4 rounded shadow">
            <div class="lg:text-right mb-2">
                <button class="text-sm font-medium border-0 text-slate-500 lg:text-[#B92727]/70">
                    <span class="block lg:hidden">
                        <i class='bx bx-chevron-left text-3xl'></i>
                    </span>
                    <span class="hidden lg:block">
                        Back
                    </span>
                </button>
            </div>
            <div class="text-center mb-2 lg:mb-6">
                <h3 class="text-lg lg:text-2xl font-semibold text-slate-800">Post ads</h3>
            </div>
            <div class="flex select-none"
                >
                <div @click="currentStep = 1"
                    :class="currentStep === 1 ? 'border-b-[2px] border-[#1895B0]' : 'border-b border-slate-300'"
                    class="h-[40px] text-black/80 flex items-center pl-4 flex-1 lg:cursor-pointer">
                    <span :class="currentStep === 1 ? 'text-[#1895B0]' : 'text-slate-500'"
                        class="text-xs lg:text-sm">About Ad</span>
                </div>
                <div @click="currentStep = 2"
                    :class="currentStep === 2 ? 'border-b-[2px] border-[#1895B0]' : 'border-b border-slate-300'"
                    class="h-[40px] text-black/80 flex items-center pl-4 flex-1 lg:cursor-pointer">
                    <span :class="currentStep === 2 ? 'text-[#1895B0]' : 'text-slate-500'"
                        class="text-xs lg:text-sm">Ad Details</span>
                </div>
            </div>
            <div class="w-full">
                <form :class="currentStep === 1 ? 'block' : 'hidden'"
                    class="w-full px-2 pt-6 pb-4"
                    >
                    <div class="flex flex-col lg:flex-row gap-4 mb-4">
                        <div class="border p-2 rounded-lg flex-1">
                            <select class="w-full h-full text-sm text-slate-500 outline-none bg-transparent"
                                >
                                <option value="">Category</option>
                            </select>
                        </div>
                        <div class="border p-2 rounded-lg flex-1">
                            <select class="w-full h-full text-sm text-slate-500 outline-none bg-transparent"
                                >
                                <option value="">Location</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-2 text-slate-500">
                        <p class="font-medium">Add photos</p>
                        <small class="text-xs">First image should be the <span class="font-semibold">Title</span> image.</small>
                    </div>
                    <div class="w-full max-w-full p-2 mb-2 overflow-x-auto flex items-center gap-x-2">
                        <input class="hidden" accept="image/png, image/jpeg" id="file" type="file" @change="onFileChange">
                        <label for="file"
                            class="w-[60px] h-[60px] lg:w-[70px] lg:h-[70px] rounded-full bg-slate-100 hover:bg-slate-200 flex items-center justify-center lg:cursor-pointer flex-shrink-0"
                            >
                            <i class='bx bx-plus text-3xl text-slate-400'></i>
                        </label>

                        <div v-for="(photo, key) in preview" :key="key"
                            :style="`background-image: url('${photo}');`"
                            class="w-[70px] h-[70px] lg:w-[80px] lg:h-[80px] bg-no-repeat bg-cover bg-center rounded-lg flex justify-end flex-shrink-0 group"
                            >
                            <div @click="deleteFile(key)"
                                class="w-4 h-4 m-1 flex lg:hidden items-center justify-center rounded-full bg-black/30 hover:bg-black/40 lg:cursor-pointer group-hover:lg:flex">
                                <i class='bx bx-x text-slate-200 pointer-events-none'></i>
                            </div>
                        </div>
                    </div>
                    <div class="mb-4 text-slate-500">
                        <p><small class="text-xs">Each pictures should not exceed 5mb</small></p>
                        <p><small class="text-xs">Supported formats are *.jpg and *.png</small></p>
                    </div>
                    <div class="w-full text-center mt-4">
                        <button
                            class="w-full md:w-8/12 lg:w-6/12 bg-[#1895B0] hover:bg-[#1895B0]/90 disabled:bg-[#1895B0]/60 text-white rounded p-2">
                            Next
                        </button>
                    </div>
                </form>
                <form :class="currentStep === 2 ? 'block' : 'hidden'"
                    class="w-full px-2 pt-6 pb-4"
                    >
                    <div class="flex flex-col lg:flex-row gap-4 mb-4">
                        <div class="border p-2 rounded-lg flex-1">
                            <input v-model="form.title" class="w-full h-full outline-none pl-1 text-sm" type="text" placeholder="Title*"/>
                        </div>
                        <div class="border p-2 rounded-lg flex-1">
                            <input v-model="form.type" class="w-full h-full outline-none pl-1 text-sm" type="text" placeholder="Type*"/>
                        </div>
                    </div>
                    <div class="flex flex-col lg:flex-row gap-4 mb-4">
                        <div class="border p-2 rounded-lg flex-1">
                            <input v-model="form.condition" class="w-full h-full outline-none pl-1 text-sm" type="text" placeholder="Condition*"/>
                        </div>
                        <div class="border p-2 rounded-lg flex-1">
                            <input v-model="form.brand" class="w-full h-full outline-none pl-1 text-sm" type="text" placeholder="Brand*"/>
                        </div>
                    </div>
                    <div class="full mb-4 max-h-[100px]">
                        <div class="border p-2 rounded-lg flex-1">
                            <textarea class="w-full h-full outline-none bg-transparent resize-none text-sm p-1"
                                placeholder="Description*"
                                ></textarea>
                        </div>
                    </div>
                    <div class="flex flex-col-reverse lg:flex-row gap-4 mb-4">
                        <div class="border p-2 rounded-lg flex-1 flex items-center">
                            <div class="h-full w-4 flex items-center justify-center text-sm text-slate-800">₦</div>
                            <input v-model="form.price" class="w-full h-full outline-none pl-1 text-sm" type="number" placeholder="Price*"/>
                        </div>
                        <div class="border p-2 rounded-lg flex-1">
                            <input v-model="form.color" class="w-full h-full outline-none pl-1 text-sm" type="text" placeholder="Color*"/>
                        </div>
                    </div>
                    <div class="flex flex-col lg:flex-row gap-4 mb-4">
                        <div class="p-2 flex-1 flex items-center gap-1">
                            <input v-model="form.negotiable" id="negotiable" class="outline-none text-sm border border-slate-200" type="checkbox"/>
                            <label for="negotiable" class="text-slate-400 text-xs">Negotiable</label>
                        </div>
                    </div>
                    <div class="w-full text-center mt-4">
                        <button :disabled="processing"
                            class="w-full md:w-8/12 lg:w-6/12 bg-[#1895B0] hover:bg-[#1895B0]/90 disabled:bg-[#1895B0]/60 text-white rounded p-2">
                            Post Ad
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </section>
    <Bottomnavigationbar/>
</template>
