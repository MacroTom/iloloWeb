<script>
import { Link } from '@inertiajs/vue3';
export default {
    components:{
        Link
    },
    data(){
        return{}
    }
}
</script>

<template>
    <footer class="min-h-[300px] bg-[#1895B0]/80 bg-no-repeat bg-[url('/images/dots.svg')] flex flex-col gap-3 justify-between">
        <section class="grid grid-cols-2 gap-x-2 gap-y-4 lg:gap-4 lg:grid-cols-4 px-4 py-8 lg:p-8 xl:px-28">
            <div>
                <p class="mb-2 text-sm font-semibold text-slate-300">About us</p>
                <div class="flex flex-col items-start gap-2 text-sm text-slate-50">
                    <Link href="#">About ilolo</Link>
                    <Link href="#">Privacy Policy</Link>
                    <Link href="#">Terms & Conditions</Link>
                </div>
            </div>
            <div>
                <p class="mb-2 text-sm font-semibold text-slate-300">Contact</p>
                <div class="flex flex-col items-start gap-2 mb-2 text-sm text-slate-50">
                    <Link href="#">Contact Us</Link>
                    <Link href="#">FAQ</Link>
                </div>
                <div class="flex gap-x-4">
                    <Link href="#"><i class='text-xl bx bxl-instagram text-slate-100'></i></Link>
                    <Link href="#"><i class='text-xl bx bxl-twitter text-slate-100'></i></Link>
                    <Link href="#"><i class='text-xl bx bxl-facebook-circle text-slate-100'></i></Link>
                </div>
            </div>
            <div>
                <p class="mb-2 text-sm font-semibold text-slate-300">Our Apps</p>
                <div class="flex flex-col gap-2">
                    <Link href="#" class="flex items-center gap-1 px-3 py-2 text-white rounded-lg w-fit bg-black/60 hover:bg-black/70">
                        <div>
                            <i class='text-2xl pointer-events-none bx bxl-apple'></i>
                        </div>
                        <div>
                            <p class="text-xs"><small>Available on the</small></p>
                            <p class="text-sm font-semibold">Apple Store</p>
                        </div>
                    </Link>
                    <Link href="#" class="flex items-center gap-1 px-3 py-2 text-white rounded-lg w-fit bg-black/60 hover:bg-black/70">
                        <div>
                            <i class='text-2xl pointer-events-none bx bxl-play-store'></i>
                        </div>
                        <div>
                            <p class="text-xs"><small>Available on the</small></p>
                            <p class="text-sm font-semibold">Google Play</p>
                        </div>
                    </Link>
                </div>
            </div>
            <div>
                <p class="mb-2 text-sm font-semibold text-slate-300">Subscribe</p>
                <div class="flex flex-col gap-4 w-fit">
                    <p class="text-xs text-slate-50">Join our newsletter. Let’s keep in touch.</p>
                    <div class="border-[2px] p-1 rounded-lg border-slate-50 flex items-center">
                        <input class="w-full h-full p-1 text-sm bg-transparent outline-none text-slate-50 placeholder:text-slate-50" type="email" placeholder="Email"/>
                        <button><i class='text-xl pointer-events-none bx bx-send text-slate-50'></i></button>
                    </div>
                </div>
            </div>
        </section>
        <div class="h-[60px] bg-[#1895B0]/90 flex items-center justify-center text-sm text-slate-100 lg:justify-between px-4 lg:px-8 xl:px-28">
            <p><i class='bx bx-copyright'></i> 2023 ilolo marketplace. All Rights Reserved</p>
            <p class="items-center hidden lg:flex"><i class='mr-2 text-xl bx bx-code-alt'></i> Powered by <a class="ml-2" href="mailto:info@enastech.com">ETS</a>.</p>
        </div>
    </footer>
</template>
