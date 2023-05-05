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
                                <h1>Prehľad rezervácií dodávky</h1>
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
                    <div class="lg:flex mb-3">
                        <div class="mr-3 custom-margin">
                            <button @click="openModal" class="buttons">Pridať rezerváciu</button>
                        </div>
                        <div class="mr-3 custom-margin">
                            <input type="text" class="rounded-md" v-model="this.findReservation.findNameString"
                            placeholder="Vyhľadať člena">
                        </div>
                        <div>
                            <button class="buttons" id="searchReservationButton" @click="searchReservation">Hľadať</button>
                        </div>
                    </div>
                    <div>
                        <VanReservationModal v-if="this.showModal" @closeModal="closeModal" @saveVanReservation="saveVanReservation" :form="this.newReservation"
                        :updateReservationFlag="this.updateReservationFlag"/>

                        <DeleteModal v-if="this.showDeleteModal" @closeDeleteModal="closeDeleteModal" @deleteObject="deleteObject" :deletedObjectId="deletedObjectId"/>
                    </div>
                    <div class="overflow-x-scroll rounded-lg shadow">
                        <table class="w-full">
                            <thead class="bg-gray-50 border-b-2 border-gray-200">
                                <tr>
                                    <th class="p-3 text-sm font-semibold tracking-wide text-left whitespace-nowrap">Akcie</th>
                                    <th class="p-3 text-sm font-semibold tracking-wide text-left whitespace-nowrap">Schválenie</th>
                                    <th class="p-3 text-sm font-semibold tracking-wide text-left whitespace-nowrap">Zadal</th>
                                    <th class="p-3 text-sm font-semibold tracking-wide text-left whitespace-nowrap">Od</th>
                                    <th class="p-3 text-sm font-semibold tracking-wide text-left whitespace-nowrap">Do</th>
                                    <th class="p-3 text-sm font-semibold tracking-wide text-left whitespace-nowrap">Dátum zadania</th>
                                    <th class="p-3 text-sm font-semibold tracking-wide text-left whitespace-nowrap">Dátum úpravy</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <tr class="bg-white" v-for="(reservation, index) in this.newReservations.data" :key="index">
                                    <td class="p-3 text-sm text-gray-700 whitespace-nowrap"> <!--Akcie-->
                                        <div class="flex">
                                            <div class="pr-2">
                                                <Icon name="update" width="20" @click="updateReservation(reservation)"/>
                                            </div>
                                            <div class="pl-2">
                                                <Icon name="delete" width="20" @click="deleteReservationModal(reservation.id)"/>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-3 text-sm text-gray-700 whitespace-nowrap">
                                        <ApprovalIcon :type="reservation.approval"/>
                                    </td>
                                    <td class="p-3 text-sm text-gray-700 whitespace-nowrap">
                                        {{ reservation.name }}
                                    </td>
                                    <td class="p-3 text-sm text-gray-700 whitespace-nowrap">
                                        {{ reservation.reservation_from }}
                                    </td>
                                    <td class="p-3 text-sm text-gray-700 whitespace-nowrap">
                                        {{ reservation.reservation_to }}
                                    </td>
                                    <td class="p-3 text-sm text-gray-700 whitespace-nowrap">
                                        {{ reservation.created_at }}
                                    </td>
                                    <td class="p-3 text-sm text-gray-700 whitespace-nowrap">
                                        {{ reservation.updated_at }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div>
                        <Pagination :links="this.newReservations.links"/>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import OrderMenu from '@/Components/OrderMenu.vue';
    import VanReservationModal from '@/Modals/VanReservationModal.vue';
    import DeleteModal from '@/Modals/DeleteModal.vue';
    import Icon from '@/Components/Icon.vue';
    import { Inertia } from '@inertiajs/inertia';
    import ApprovalIcon from '@/Components/OrderIcons.vue';
    import Pagination from '@/Components/Pagination.vue';
    import axios from 'axios';

    export default {
        name: 'DashboardVanReservations',
        components: { 
            AppLayout,
            OrderMenu,
            VanReservationModal,
            DeleteModal, 
            ApprovalIcon,
            Icon,
            Pagination,
        },
        props: {
            vanReservations: {
                type: Object,
                default: () => { }
            },
        },
        data(){
            return{
                showDeleteModal: false,
                deletedObjectId: '',
                showModal: false,
                updateReservationFlag :false,
                newReservations: {},
                newReservation: {
                    id: '',
                    reason: '',
                    user_id: '',
                    reservation_from: '',
                    reservation_to: '',
                    approval: '',
                },
                findReservation: {findNameString: ''},
            }
        },
        methods: {
            openModal(){
                this.showModal = true;
                this.updateReservationFlag = false;
            },
            closeModal() {
                this.showModal = false;
                this.resetModal();
            },
            closeDeleteModal() {
                this.showDeleteModal = false;
            },
            resetModal(){
                this.newReservation = {
                    id: '',
                    reason: '',
                    user_id: '',
                    reservation_from: '',
                    reservation_to: '',
                    approval: '',
                }
            },
            deleteReservationModal(vanReservationId){
                this.showDeleteModal = true;
                this.deletedObjectId = vanReservationId.toString();
            },
            deleteObject(param){
                var request = {id: param};

                Inertia.post(route("dashboard-delete-van-reservation"), request, {
                    onSuccess: page => {
                        if (Object.entries(page.props.errors).length === 0) {
                            this.newReservations = page.props.vanReservations;
                            this.closeDeleteModal();
                            this.closeModal();
                        }
                    }
                });

                Inertia.on("error", event => {
                    event.preventDefault();
                    console.log('error pri delete rezetvacii dodavky', event.message);
                });
            },
            updateReservation(reservation){
                this.newReservation.id = reservation.id;
                this.newReservation.reason = reservation.reason;
                this.newReservation.reservation_from = reservation.reservation_from;
                this.newReservation.reservation_to = reservation.reservation_to;
                this.newReservation.approval = reservation.approval;
                this.newReservation.user_id = reservation.user_id;

                this.updateReservationFlag = true;
                this.showModal = true;
            },
            saveVanReservation(param){
                if (this.updateReservationFlag) {
                    Inertia.post(route("dashboard-update-van-reservation"), param, {
                        onSuccess: page => {
                            if (Object.entries(page.props.errors).length === 0) {
                                this.newReservations = page.props.vanReservations;
                                this.closeModal();
                            }
                        }
                    });
                }
                else {
                    Inertia.post(route("dashboard-store-van-reservation"), param, {
                        onSuccess: page => {
                            if (Object.entries(page.props.errors).length === 0) {
                                console.log(page.props);
                                this.newReservations = page.props.vanReservations;
                                this.closeModal();
                            }
                        }
                    });
                }
            },
            searchReservation(){
                axios.post(route('dashboard-search-van-reservations', this.findReservation))
                .then((res) => {
                    this.newReservations = res.data;
                });
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
        beforeMount() {
            this.newReservations = this.vanReservations;
        },
    }
</script>

<style scoped>

</style>