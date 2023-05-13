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
        return{}
    }
}
</script>

<template>
    <Head>
        <title>Post ad</title>
    </Head>
    <div class="hidden lg:block">
        <Heading/>
    </div>
    <section class="h-[calc(100vh-40px)] lg:h-[calc(100vh-60px)] flex items-start px-2 pt-6 pb-16 lg:p-8">

    </section>
    <Bottomnavigationbar/>
</template>
