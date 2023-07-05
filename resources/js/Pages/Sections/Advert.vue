<script>
import AppLayout from '../../layout/AppLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
export default{
    props:{
        auth: Object,
        user: Object
    },
    components:{
        Head,
        Link,
        AppLayout,
    },
    layout: AppLayout,
    data(){
        return{
            processing: false,
            loaders: {
                promote: false,
                demote: false,
                enable: false,
                disable: false
            }
        }
    },
    methods:{
        formatCurrency(value){
            return value.toLocaleString('en-US', { style: 'currency', currency: 'USD' });
        },
        formatDate(value){
            return value.toLocaleDateString('en-US', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric'
            });
        },
        promoteUser(){
            this.loaders.promote = true;
            router.post(`${this.user?.id}/promote`, {},
            {
                preserveState: true,
                onSuccess: (res) => {
                    this.$toast.add({ severity: 'success', summary: 'Successful', detail: res.props.flash.message, life: 3000 });
                    this.loaders.promote = false;
                },
                onError: (err) => {
                    this.$toast.add({ severity: 'error', summary: 'Error!', detail: err.message, life: 3000 });
                    this.loaders.promote = false;
                }
            }
            );
        },
        demoteUser(){
            this.loaders.demote = true;
            router.post(`${this.user?.id}/demote`, {},
            {
                preserveState: true,
                onSuccess: (res) => {
                    this.$toast.add({ severity: 'success', summary: 'Successful', detail: res.props.flash.message, life: 3000 });
                    this.loaders.demote = false;
                },
                onError: (err) => {
                    this.$toast.add({ severity: 'error', summary: 'Error!', detail: err.message, life: 3000 });
                    this.loaders.demote = false;
                }
            }
            );
        },
        enableUser(){
            this.loaders.enable = true;
            router.post(`${this.user?.id}/enable`, {},
            {
                preserveState: true,
                onSuccess: (res) => {
                    this.$toast.add({ severity: 'success', summary: 'Successful', detail: res.props.flash.message, life: 3000 });
                    this.loaders.enable = false;
                },
                onError: (err) => {
                    this.$toast.add({ severity: 'error', summary: 'Error!', detail: err.message, life: 3000 });
                    this.loaders.enable = false;
                }
            }
            );
        },
        disableUser(){
            this.loaders.disable = true;
            router.post(`${this.user?.id}/disable`, {},
            {
                preserveState: true,
                onSuccess: (res) => {
                    this.$toast.add({ severity: 'success', summary: 'Successful', detail: res.props.flash.message, life: 3000 });
                    this.loaders.disable = false;
                },
                onError: (err) => {
                    this.$toast.add({ severity: 'error', summary: 'Error!', detail: err.message, life: 3000 });
                    this.loaders.disable = false;
                }
            }
            );
        }
    },
    mounted(){
    }
}
</script>

<template>
    <Head>
        <title>User</title>
    </Head>
    <div class="grid">
        <div class="col-12 md:col-6 lg:col-5 xl:col-4">
            <div class="p-4 card lg:p-5">
                <div class="w-full flex flex-col gap-2 lg:gap-3 items-center mb-4">
                    <img v-if="user?.avatar"
                        class="w-[60px] lg:w-[70px] rounded-full border-4 border-[#1895B0]/10 flex-shrink-0"
                        :src="user?.avatar"
                        alt="avatar"/>
                    <span v-else
                        class="w-[60px] h-[60px] lg:w-[70px] lg:h-[70px] rounded-full bg-[#dee2e6] font-medium text-black/60 text-3xl flex items-center justify-center flex-shrink-0"
                        >
                        {{ user?.firstname[0] }}{{ user?.lastname[0] }}
                    </span>
                    <div class="flex flex-col items-center gap-1">
                        <span class="font-semibold uppercase">
                            {{ user?.firstname }} {{ user?.lastname }}
                        </span>
                        <span :class="'customer-badge font-medium status-' + (user?.status === 'active'? 'qualified' : 'unqualified')">{{ user?.status }}</span>
                    </div>
                </div>
                <div class="text-center lg:text-left flex justify-between items-start">
                    <Button v-if="user?.role === 'user'"
                        style="color: #1895B0;"
                        text
                        label="Promote"
                        icon="pi pi-verified"
                        :loading="loaders.promote"
                        @click="promoteUser"
                        />
                    <Button v-else
                        text
                        label="Demote"
                        icon="pi pi-thumbs-down"
                        :loading="loaders.demote"
                        @click="demoteUser"
                        severity="danger"
                        />
                    <Button v-if="user?.status === 'active'"
                        text
                        label="Disable"
                        icon="pi pi-ban"
                        :loading="loaders.disable"
                        @click="disableUser"
                        severity="danger"
                        />
                    <Button v-else
                        text
                        label="Enable"
                        icon="pi pi-bolt"
                        :loading="loaders.enable"
                        @click="enableUser"
                        severity="info"
                        />
                </div>
            </div>
        </div>
        <div class="col-12 md:col-6 lg:col-7 xl:col-8">
            <div class="p-4 card lg:p-5">
                <h5 class="text-center lg:text-left text-black/70 mb-0">Account information</h5>
                <Divider type="solid" class="border-t my-3"/>
                <div class="w-full flex justify-between mb-2 lg:mb-4">
                    <span class="font-semibold uppercase">Email </span>
                    <span class="text-sm lg:text-lg">{{ user?.email }}</span>
                </div>
                <div class="w-full flex justify-between mb-2 lg:mb-4">
                    <span class="font-semibold uppercase">Phone </span>
                    <span class="text-sm lg:text-lg">{{ user?.phone }}</span>
                </div>
                <div class="w-full flex justify-between mb-2 lg:mb-4">
                    <span class="font-semibold uppercase">Facebook id </span>
                    <span class="text-sm lg:text-lg">{{ user?.facebook_id ? user?.facebook_id : '<blank>' }}</span>
                </div>
                <div class="w-full flex justify-between mb-2 lg:mb-4">
                    <span class="font-semibold uppercase">Google id </span>
                    <span class="text-sm lg:text-lg">{{ user?.google_id ? user?.google_id : '<blank>' }}</span>
                </div>
                <div class="w-full flex justify-between mb-2 lg:mb-4">
                    <span class="font-semibold uppercase">Role </span>
                    <span class="text-sm font-medium lg:text-lg text-[#1895B0]"><i :class="'pi pi-'+ (user?.role === 'user' ? 'user' : 'verified')"></i> {{ user?.role }}</span>
                </div>
                <div class="w-full flex justify-between mb-2 lg:mb-4">
                    <span class="font-semibold uppercase">Registered </span>
                    <span class="text-sm lg:text-lg">{{ formatDate(new Date(user?.created_at)) }}</span>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped lang="scss">
@import '@/assets/demo/styles/badges.scss';
</style>
