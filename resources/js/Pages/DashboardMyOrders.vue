<template>
    <AppLayout>
        <div class="container page-container">
            <div class="mx-auto grid grid-cols-12 gap-4 p-1">
                <div class="col-span-12 sm:col-span-2">
                    <OrderMenu/>
                </div>
                <div class="col-span-12 sm:col-span-10">
                    <div class="bg-green-100 border-t border-b border-green-500 text-green-700 px-4 py-3" role="alert" v-if="showAlert">
                        <p class="text-sm">{{ $page.props.flash.success_object_save }}</p>
                        <p class="text-sm">{{ $page.props.flash.success_object_update_save }}</p>
                        <p class="text-sm">{{ $page.props.flash.success_object_delete }}</p>
                    </div>
                    <div class="page-heading">
                        <h1>Prehľad mojich objednávok</h1>
                    </div>
                    <div class="m-2">
                        <button @click="openModal">Pridať objednávku</button>
                    </div>
                    <div>
                        <OrderModal v-if="this.showModal" @closeModal="closeModal" @saveOrder="saveOrder" :form="this.newOrder" :currencies="this.currencies" :orderPriorities="this.orderPriorities" 
                        :orderStatuses="this.orderStatuses" :formulaPartSpecifies="this.formulaPartSpecifies" :updateOrderFlag="this.updateOrderFlag"/>

                        <DeleteModal v-if="this.showDeleteModal" @closeDeleteModal="closeDeleteModal" @deleteObject="deleteObject" :deletedObjectId="deletedObjectId"/>
                    </div>
                    <div class="overflow-x-scroll rounded-lg border border-gray-200 shadow-md">
                        <table class="w-full border-collapse bg-white text-left text-sm text-gray-500">
                            <thead class="bg-gray-300">
                                <tr>
                                    <th scope="col" class="p-3 font-medium text-gray-900">Akcie</th>
                                    <th scope="col" class="p-3 font-medium text-gray-900">Schválené</th>
                                    <th scope="col" class="p-3 font-medium text-gray-900 whitespace-nowrap">Objednávkové číslo</th>
                                    <th scope="col" class="p-3 font-medium text-gray-900 whitespace-nowrap">Presný názov</th>
                                    <th scope="col" class="p-3 font-medium text-gray-900 whitespace-nowrap">Stručný popis</th>
                                    <th scope="col" class="p-3 font-medium text-gray-900 whitespace-nowrap">Kde je to určené</th>
                                    <th scope="col" class="p-3 font-medium text-gray-900 whitespace-nowrap">Množstvo</th>
                                    <th scope="col" class="p-3 font-medium text-gray-900 whitespace-nowrap">Cena za kus</th>
                                    <th scope="col" class="p-3 font-medium text-gray-900 whitespace-nowrap">Celková cena</th>
                                    <th scope="col" class="p-3 font-medium text-gray-900 whitespace-nowrap">Zadal</th>
                                    <th scope="col" class="p-3 font-medium text-gray-900 whitespace-nowrap">Obchod</th>
                                    <th scope="col" class="p-3 font-medium text-gray-900 whitespace-nowrap">Link</th>
                                    <th scope="col" class="p-3 font-medium text-gray-900 whitespace-nowrap">Priorita</th>
                                    <th scope="col" class="p-3 font-medium text-gray-900 whitespace-nowrap">Stav</th>
                                    <th scope="col" class="p-3 font-medium text-gray-900 whitespace-nowrap">Poznámka</th>
                                    <th scope="col" class="p-3 font-medium text-gray-900 whitespace-nowrap">Dátum zadania</th>
                                    <th scope="col" class="p-3 font-medium text-gray-900 whitespace-nowrap">Dátum úpravy</th>
                                    <th scope="col" class="p-3 font-medium text-gray-900 whitespace-nowrap">Dátum dodania</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 border-t border-gray-100">
                                <tr class="hover:bg-gray-50" v-for="(order, index) in this.orders" :key="index">
                                    <td class="p-3 border-b-2 border-gray-300"> <!--Akcie-->
                                        <div class="flex">
                                            <div class="pr-2">
                                                <Icon name="update" width="20" @click="updateOrder(order)"/>
                                            </div>
                                            <div class="pl-2">
                                                <Icon name="delete" width="20" @click="deleteOrderModal(order.id)"/>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-3 border-b-2 border-gray-300"> <!--Schválené-->
                                        <ApprovalIcon :type="order.approval"/>
                                    </td>
                                    <td class="p-3 border-b-2 border-gray-300"> <!--Objednávkové číslo-->
                                        {{ order.order_number }}
                                    </td>
                                    <td class="p-3 border-b-2 border-gray-300"> <!--Presný názov-->
                                        {{ order.order_title }}
                                    </td>
                                    <td class="p-3 border-b-2 border-gray-300"> <!--Stručný popis-->
                                        {{ order.description }}
                                    </td>
                                    <td class="p-3 border-b-2 border-gray-300"> <!--Kde je to určené-->
                                        {{ order.formula_part_specify_title }}
                                    </td>
                                    <td class="p-3 border-b-2 border-gray-300"> <!--Množstvo-->
                                        {{ order.quantity }}
                                    </td>
                                    <td class="p-3 border-b-2 border-gray-300"> <!--Cena za kus-->
                                        {{ order.price_per_piece }} {{ order.currency_symbol }}
                                    </td>
                                    <td class="p-3 border-b-2 border-gray-300"> <!--Celková cena-->
                                        {{ order.price_total }} {{ order.currency_symbol }}
                                    </td>
                                    <td class="p-3 border-b-2 border-gray-300"> <!--Zadal-->
                                        {{ order.name }}
                                    </td>
                                    <td class="p-3 border-b-2 border-gray-300"> <!--Obchod-->
                                        {{ order.shop }}
                                    </td>
                                    <td class="p-3 border-b-2 border-gray-300"> <!--Link-->
                                        <a :href="order.link">{{ order.link }}</a>
                                    </td>
                                    <td class="p-3 border-b-2 border-gray-300"> <!--Priorita-->
                                        {{ order.order_priority_title }}
                                    </td>
                                    <td class="p-3 border-b-2 border-gray-300"> <!--Stav-->
                                        {{ order.order_status_title }}
                                    </td>
                                    <td class="p-3 border-b-2 border-gray-300"> <!--Poznámka-->
                                        {{ order.order_comment }}
                                    </td>
                                    <td class="p-3 border-b-2 border-gray-300"> <!--Dátum zadania-->
                                        {{ order.created_at }}
                                    </td>
                                    <td class="p-3 border-b-2 border-gray-300"> <!--Dátum úpravy-->
                                        {{ order.updated_at }}
                                    </td>
                                    <td class="p-3 border-b-2 border-gray-300"> <!--Dátum dodania-->
                                        {{ order.delivery_date }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
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
    import ApprovalIcon from '@/Components/AttendanceIcons.vue';

    export default {
        name: 'DashboardMyOrders',
        components: { 
            AppLayout,
            OrderMenu,
            OrderModal,
            DeleteModal, 
            ApprovalIcon,
            Icon,
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

