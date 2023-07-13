<script>
import { router } from '@inertiajs/vue3';
import StarRatings from './StarRatings.vue';
import { store } from '../store.js';
export default{
    components: {
        StarRatings
    },
    data(){
        return{
            store,
            open: false,
            form: {
                advert_id: this.advertId,
                rating: 1,
                review: ''
            },
            processing: false,
        }
    },
    methods:{
        submitReview(){
            this.processing = true;
            router.post('/addreview', this.form, {
                preserveState: true,
                preserveScroll: true,
                onSuccess: (res) => {
                    this.store.snackbar.add({
                        message: "Review has been submitted!",
                        severity: "success"
                    });
                    this.form = {
                        rating: 1,
                        review: ''
                    }
                },
                onError: (err) => {
                    this.processing = false;
                    this.store.snackbar.add({
                        message: err.message,
                        severity: "warning"
                    });
                }
            });
        }
    }
}
</script>

<template>
    <div class="border rounded-lg px-3 py-2">
        <div @click="$page.props.auth?.user ? open = !open : store.toggleFormTab()" class="flex justify-between items-center cursor-pointer">
            <h4 class="text-sm text-slate-600 font-medium select-none">Leave a review</h4>
            <button class="rounded-lg">
                <i :class="open ? 'bx-chevron-up' : 'bx-chevron-down'" class="bx text-lg text-slate-600 pointer-events-none"></i>
            </button>
        </div>
        <!-- dropdown -->
        <div :class="open ? 'block' : 'hidden'">
            <div class="my-4">
                <StarRatings v-model:rating="form.rating" :range="5" color="text-[#F59E0B]" size="text-lg" />
            </div>
            <div>
                <textarea v-model="form.review" :disabled="!canReview" class="w-full h-32 p-2 text-xs text-slate-600 font-Inter font-medium outline-none bg-slate-100 rounded-lg resize-none placeholder:font-normal" placeholder="Would you like to write anything about this seller?"/>
            </div>
            <div>
                <button @click="form.review !== '' ? submitReview() : ''" :disabled="processing" class="button primary w-full">Submit Review</button>
            </div>
        </div>
    </div>
</template>
