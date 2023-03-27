<template>
    <AppLayout>
        <div class="relative w-full">
            <div class="absolute top-0 right-0 h-10 border-t border-b px-4 py-2 message" v-if="showAlert">
                <p class="text-sm">{{ $page.props.flash.success_object_save }}</p>
                <p class="text-sm">{{ $page.props.flash.success_object_update_save }}</p>
                <p class="text-sm">{{ $page.props.flash.success_object_delete }}</p>
            </div>
        </div>
        <div class="container page-container">
            <div class="mx-auto grid grid-cols-12 gap-4 p-1">
                <div class="col-span-12 sm:col-span-2">
                    <div class="hidden md:block text-sm">
                        <OrderMenu/>
                    </div>
                </div>
                <div class="col-span-12 sm:col-span-10">
                    <div class="page-heading">
                        <div class="flex justify-between">
                            <div>
                                <h1>Prehľad mojich objednávok</h1>
                            </div>
                            <div class="md:hidden">
                                <div class="dropdown pl-3">
                                    <label tabindex="0" class="m-1">                                        
                                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                         </svg>
                                    </label>
                                    <ul tabindex="0" class="dropdown-content menu p-3 shadow bg-white rounded-box w-52 text-sm right-4">
                                        <OrderMenu/>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <button @click="openModal" class="buttons">Pridať objednávku</button>
                    </div>
                    <div>
                        <OrderModal v-if="this.showModal" @closeModal="closeModal" @saveOrder="saveOrder" :form="this.newOrder" :currencies="this.currencies" :orderPriorities="this.orderPriorities" 
                        :orderStatuses="this.orderStatuses" :formulaPartSpecifies="this.formulaPartSpecifies" :updateOrderFlag="this.updateOrderFlag"/>

                        <DeleteModal v-if="this.showDeleteModal" @closeDeleteModal="closeDeleteModal" @deleteObject="deleteObject" :deletedObjectId="deletedObjectId"/>
                    </div>
                    <div class="overflow-x-scroll rounded-lg shadow">
                        <table class="w-full">
                            <thead class="bg-gray-50 border-b-2 border-gray-200">
                                <tr>
                                    <th class="p-3 text-sm font-semibold tracking-wide text-left whitespace-nowrap">Akcie</th>
                                    <th class="p-3 text-sm font-semibold tracking-wide text-left whitespace-nowrap">Schválenie</th>
                                    <th class="p-3 text-sm font-semibold tracking-wide text-left whitespace-nowrap">Objednávkové číslo</th>
                                    <th class="p-3 text-sm font-semibold tracking-wide text-left whitespace-nowrap">Presný názov</th>
                                    <th class="p-3 text-sm font-semibold tracking-wide text-left whitespace-nowrap">Stručný popis</th>
                                    <th class="p-3 text-sm font-semibold tracking-wide text-left whitespace-nowrap">Kde je to určené</th>
                                    <th class="p-3 text-sm font-semibold tracking-wide text-left whitespace-nowrap">Množstvo</th>
                                    <th class="p-3 text-sm font-semibold tracking-wide text-left whitespace-nowrap">Cena za kus</th>
                                    <th class="p-3 text-sm font-semibold tracking-wide text-left whitespace-nowrap">Celková cena</th>
                                    <th class="p-3 text-sm font-semibold tracking-wide text-left whitespace-nowrap">Zadal</th>
                                    <th class="p-3 text-sm font-semibold tracking-wide text-left whitespace-nowrap">Obchod</th>
                                    <th class="p-3 text-sm font-semibold tracking-wide text-left whitespace-nowrap">Link</th>
                                    <th class="p-3 text-sm font-semibold tracking-wide text-left whitespace-nowrap">Priorita</th>
                                    <th class="p-3 text-sm font-semibold tracking-wide text-left whitespace-nowrap">Stav</th>
                                    <th class="p-3 text-sm font-semibold tracking-wide text-left whitespace-nowrap">Poznámka</th>
                                    <th class="p-3 text-sm font-semibold tracking-wide text-left whitespace-nowrap">Dátum zadania</th>
                                    <th class="p-3 text-sm font-semibold tracking-wide text-left whitespace-nowrap">Dátum úpravy</th>
                                    <th class="p-3 text-sm font-semibold tracking-wide text-left whitespace-nowrap">Dátum dodania</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <tr class="bg-white" v-for="(order, index) in this.orders.data" :key="index">
                                    <td class="p-3 text-sm text-gray-700 whitespace-nowrap"> <!--Akcie-->
                                        <div class="flex">
                                            <div class="pr-2">
                                                <Icon name="update" width="20" @click="updateOrder(order)"/>
                                            </div>
                                            <div class="pl-2">
                                                <Icon name="delete" width="20" @click="deleteOrderModal(order.id)"/>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-3 text-sm text-gray-700 whitespace-nowrap"> <!--Schválené-->
                                        <ApprovalIcon :type="order.approval"/>
                                    </td>
                                    <td class="p-3 text-sm text-gray-700 whitespace-nowrap"> <!--Objednávkové číslo-->
                                        {{ order.order_number }}
                                    </td>
                                    <td class="p-3 text-sm text-gray-700 whitespace-nowrap"> <!--Presný názov-->
                                        {{ order.order_title }}
                                    </td>
                                    <td class="p-3 text-sm text-gray-700 whitespace-nowrap"> <!--Stručný popis-->
                                        {{ order.description }}
                                    </td>
                                    <td class="p-3 text-sm text-gray-700 whitespace-nowrap"> <!--Kde je to určené-->
                                        {{ order.formula_part_specify_title }}
                                    </td>
                                    <td class="p-3 text-sm text-gray-700 whitespace-nowrap"> <!--Množstvo-->
                                        {{ order.quantity }}
                                    </td>
                                    <td class="p-3 text-sm text-gray-700 whitespace-nowrap"> <!--Cena za kus-->
                                        {{ order.price_per_piece }} {{ order.currency_symbol }}
                                    </td>
                                    <td class="p-3 text-sm text-gray-700 whitespace-nowrap"> <!--Celková cena-->
                                        {{ order.price_total }} {{ order.currency_symbol }}
                                    </td>
                                    <td class="p-3 text-sm text-gray-700 whitespace-nowrap"> <!--Zadal-->
                                        {{ order.name }}
                                    </td>
                                    <td class="p-3 text-sm text-gray-700 whitespace-nowrap"> <!--Obchod-->
                                        {{ order.shop }}
                                    </td>
                                    <td class="p-3 text-sm text-gray-700 whitespace-nowrap"> <!--Link-->
                                        <a :href="order.link">{{ order.link }}</a>
                                    </td>
                                    <td class="p-3 text-sm text-gray-700 whitespace-nowrap"> <!--Priorita-->
                                        {{ order.order_priority_title }}
                                    </td>
                                    <td class="p-3 text-sm text-gray-700 whitespace-nowrap"> <!--Stav-->
                                        {{ order.order_status_title }}
                                    </td>
                                    <td class="p-3 text-sm text-gray-700 whitespace-nowrap"> <!--Poznámka-->
                                        {{ order.order_comment }}
                                    </td>
                                    <td class="p-3 text-sm text-gray-700 whitespace-nowrap"> <!--Dátum zadania-->
                                        {{ order.created_at }}
                                    </td>
                                    <td class="p-3 text-sm text-gray-700 whitespace-nowrap"> <!--Dátum úpravy-->
                                        {{ order.updated_at }}
                                    </td>
                                    <td class="p-3 text-sm text-gray-700 whitespace-nowrap"> <!--Dátum dodania-->
                                        {{ order.delivery_date }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div>
                        <Pagination :links="this.orders.links"/>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import OrderMenu from '@/Components/OrderMenu.vue';
    import OrderModal from '@/Modals/OrderModal.vue';
    import DeleteModal from '@/Modals/DeleteModal.vue';
    import Icon from '@/Components/Icon.vue';
    import { Inertia } from '@inertiajs/inertia';
    import ApprovalIcon from '@/Components/OrderIcons.vue';
    import Pagination from '@/Components/Pagination.vue';

    export default {
        name: 'DashboardMyOrders',
        components: { 
            AppLayout,
            OrderMenu,
            OrderModal,
            DeleteModal, 
            ApprovalIcon,
            Icon,
            Pagination,
        },
        props: {
            orders: {
                type: Object,
                default: () => { }
            },
            currencies:{
                type: Object,
                default: () => { }
            }, 
            orderPriorities:{
                type: Object,
                default: () => { }
            }, 
            orderStatuses:{
                type: Object,
                default: () => { }
            }, 
            formulaPartSpecifies:{
                type: Object,
                default: () => { }
            }, 
        },
        data(){
            return{
                showDeleteModal: false,
                deletedObjectId: '',
                showModal: false,
                updateOrderFlag :false,
                newOrder: {
                    id: '',
                    order_number: '',
                    order_title: '',
                    description: '',
                    formula_part_specify_id: '',
                    quantity: '',
                    price_per_piece: '',
                    price_total: '',
                    currency_id: '',
                    shop: '',
                    link: '',
                    order_priority_id: '',
                    order_status_id: '',
                    order_comment: '',
                    delivery_date: '',
                    approval: '',
                }
            }
        },
        methods: {
            openModal(){
                this.showModal = true;
                this.updateOrderFlag = false;
            },
            closeModal() {
                this.showModal = false;
                this.resetModal();
            },
            closeDeleteModal() {
                this.showDeleteModal = false;
            },
            saveOrder(param){
                if (this.updateOrderFlag) {
                    Inertia.post(route("dashboard-update-order"), param, {
                        onSuccess: page => {
                            if (Object.entries(page.props.errors).length === 0) {
                                this.closeModal();
                            }
                        }
                    });
                }
                else {
                    Inertia.post(route("dashboard-store-order"), param, {
                        onSuccess: page => {
                            if (Object.entries(page.props.errors).length === 0) {
                                this.closeModal();
                            }
                        }
                    });
                }
            },
            deleteOrderModal(orderId){
                this.showDeleteModal = true;
                this.deletedObjectId = orderId;
            },
            deleteObject(param){
                var request = {id: param};

                Inertia.post(route("dashboard-delete-order"), request);

                Inertia.on("error", event => {
                    event.preventDefault();
                    console.log('error pri delete order', event.message);
                });

                this.closeDeleteModal();
                this.closeModal();
            },
            resetModal(){
                this.newOrder = {
                    id: '',
                    order_number: '',
                    order_title: '',
                    description: '',
                    formula_part_specify_id: '',
                    quantity: '',
                    price_per_piece: '',
                    price_total: '',
                    currency_id: '',
                    shop: '',
                    link: '',
                    order_priority_id: '',
                    order_status_id: '',
                    order_comment: '',
                    delivery_date: '',
                    approval: '',
                }
            },
            updateOrder(order){
                this.newOrder.id = order.id;
                this.newOrder.order_number = order.order_number;
                this.newOrder.order_title = order.order_title;
                this.newOrder.description = order.description;
                this.newOrder.formula_part_specify_id = order.formula_part_specify_id;
                this.newOrder.quantity = order.quantity;
                this.newOrder.price_per_piece = order.price_per_piece;
                this.newOrder.price_total = order.price_total;
                this.newOrder.currency_id = order.currency_id;
                this.newOrder.shop = order.shop;
                this.newOrder.link = order.link;
                this.newOrder.order_priority_id = order.order_priority_id;
                this.newOrder.order_status_id = order.order_status_id;
                this.newOrder.order_comment = order.order_comment;
                this.newOrder.delivery_date = order.delivery_date;
                this.newOrder.approval = order.approval;

                this.updateOrderFlag = true;
                this.showModal = true;
            },
        },
        computed: {
            showAlert() {
                if (this.$page.props.flash.success_object_save !== null) {
                    setTimeout(() => {
                        this.$page.props.flash.success_object_save = null
                    }, 3000);
                    return true;
                }
                else if(this.$page.props.flash.success_object_update_save !== null) {
                    setTimeout(() => {
                        this.$page.props.flash.success_object_update_save = null
                    }, 3000);
                    return true;
                }
                else if(this.$page.props.flash.success_object_delete !== null) {
                    setTimeout(() => {
                        this.$page.props.flash.success_object_delete = null
                    }, 3000);
                    return true;
                }

                return false;
            },
        },
    }
</script>

<style scoped>

</style>

