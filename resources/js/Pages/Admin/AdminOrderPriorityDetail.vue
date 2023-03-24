<template>
    <AppLayout>
        <div class="relative w-full">
            <div class="absolute top-0 right-0 h-10 border-t border-b px-4 py-2 message" v-if="showAlert">
                <p class="text-sm">{{ $page.props.flash.success_object_update_save }}</p>
            </div>
        </div>
        <div class="container page-container">
            <div class="mx-auto grid grid-cols-12 gap-4 p-1">
                <div class="col-span-12 sm:col-span-2">
                    <AdminMenu/>
                </div>
                <div class="col-span-12 sm:col-span-10">
                    <div class="page-heading">
                        <div class="flex items-center">
                            <div class="mr-3">
                                <h1>Upraviť záznam (Priorita objednávky)</h1>
                            </div>
                            <div v-if="inputEnable">
                                <div>
                                    <Icon name="update" width="20" @click="setInputs"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex mb-3">
                        <div v-if="!inputEnable" class="mr-3">
                            <button @click.prevent="update" class="buttons">Uložiť</button>
                        </div>
                        <div v-if="!inputEnable">
                             <button @click.prevent="reset" class="buttons-red">Zrušiť</button>
                        </div>
                    </div>
                    <div class="admin-cards">
                        <input type="hidden" name="id" v-model="this.orderPriority[0].id" />
                        <div class="admin-card bg-transparent">
                            <div class="admin-card-row">
                                <div>Názov: <span class="text-red-500">*</span></div>
                                <div>
                                    <input type="text" v-model="this.orderPriority[0].order_priority_title" :disabled="inputEnable"
                                        class="mt-1 shadow appearance-none border rounded w-full py-2 px-3 text-gray-800 leading-tight focus:outline-none focus:shadow-outline"
                                        id="order_priority_title"/>
                                    <div v-if="$page.props.errors.order_priority_title" class="text-red-500">
                                        {{ $page.props.errors.order_priority_title }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import { Inertia } from '@inertiajs/inertia';
    import AdminMenu from '@/Components/AdminMenu.vue';
    import Icon from '@/Components/Icon.vue';

    export default {
        name: 'AdminOrderPriorityDetail',
        components: {
            AppLayout,
            AdminMenu,
            Icon,
        },
        props: {
            orderPriority:{
                type: Object,
                default: () => { }
            },
        },
        data() {
            return {
                inputEnable: true,
                tmpObject: {
                    order_priority_title: this.orderPriority[0].order_priority_title,
                },
            }
        },
        methods: {
            setInputs(){
                this.inputEnable = false;
            },
            reset(){
                this.inputEnable = true;

                this.orderPriority[0].order_priority_title = this.tmpObject.order_priority_title;
            },
            update(){
                this.inputEnable = true;

                Inertia.post(route("dashboard-update-order-priority"), this.orderPriority[0]);
            },
        },
        computed: {
            showAlert() {
                if(this.$page.props.flash.success_object_update_save !== null) {
                    setTimeout(() => {
                        this.$page.props.flash.success_object_update_save = null
                    }, 3000);
                    return true;
                }

                return false;
            },
        },
    }
</script>

<style scoped>
    input:disabled {
        background-color: #e9ecef;
    }

    textarea:disabled {
        background-color: #e9ecef;
    }
</style>