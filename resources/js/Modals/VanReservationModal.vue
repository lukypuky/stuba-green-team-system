<template>
    <div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <!-- This element is to trick the browser into centering the modal contents. -->
            <div class="inline-block bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full mt-0"
                role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                <form>
                    <input type="hidden" name="id" v-model="form.id"/>
                    <input type="hidden" name="user_id" v-model="form.user_id"/>
                    <div class="flex justify-between border-b border-gray-100 px-4 pt-4 font-bold">
                        <div>
                            <span class="text-gray-700" v-if="this.updateReservationFlag == false">Pridať novú rezerváciu</span>
                            <span class="text-gray-700" v-else>Upraviť rezerváciu</span>
                        </div>
                    </div>
                    <div class="bg-white px-4 pt-4 pb-4 sm:p-6 sm:pb-4 van-reservation-modal-form-container">
                        <div>
                            <div class="mb-3">
                                <label for="reason" 
                                    class="block text-gray-700 text-sm font-bold mb-2">Dôvod rezervácie <span class="text-red-500">*</span></label>
                                <textarea v-model="form.reason"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    id="reason">
                                </textarea>
                                <div v-if="$page.props.errors.reason" class="text-red-500">
                                    {{ $page.props.errors.reason }}
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="reservation_from"
                                    class="block text-gray-700 text-sm font-bold mb-2">Od <span class="text-red-500">*</span></label>
                                <input v-model="form.reservation_from" type="datetime-local"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    id="reservation_from" step="any"/>
                                <div v-if="$page.props.errors.reservation_from" class="text-red-500">
                                    {{ $page.props.errors.reservation_from }}
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="reservation_to"
                                    class="block text-gray-700 text-sm font-bold mb-2">Do <span class="text-red-500">*</span></label>
                                <input v-model="form.reservation_to" type="datetime-local"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    id="reservation_to" step="any"/>
                                <div v-if="$page.props.errors.reservation_to" class="text-red-500">
                                    {{ $page.props.errors.reservation_to }}
                                </div>
                            </div>

                            <div v-if="this.rolesIds.includes($page.props.user.role_id)">
                                <div class="col-span-6 sm:col-span-3 mb-3" v-if="updateReservationFlag">
                                    <label for="approval"
                                        class="block text-gray-700 text-sm font-bold mb-2">Schválenie</label>
                                    <select id="approval" v-model="form.approval"
                                        class="mt-1 block form-select w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                                        <option value="1">Schválené</option>
                                        <option value="2">Čaká na schálenie</option>
                                        <option value="3">Neschálené</option>
                                    </select>
                                </div>
                            </div>

                            <div v-if="$page.props.errors.booked" class="text-red-500">
                                {{ $page.props.errors.booked }}
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button @click.prevent="storeVanReservation(form)" type="button" :class="{ hidden:this.updateReservationFlag}"
                            class="inline-flex justify-center w-full rounded-md px-4 py-2 m-2 transition duration-500 ease select-none buttons">Pridať</button>
                        <button @click.prevent="updateVanReservation(form)" type="button" :class="{ hidden:!this.updateReservationFlag}"
                            class="inline-flex justify-center w-full rounded-md px-4 py-2 m-2 transition duration-500 ease select-none buttons">Upraviť</button>
                        <button @click.prevent="closeModal" type="button"
                            class="inline-flex justify-center w-full rounded-md px-4 py-2 m-2 transition duration-500 ease select-none buttons-gray">Zrušiť</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    name: "VanReservationModal",
    props: {
        form: {
            type: Object,
            default: () => { }
        },
        updateReservationFlag: {
            type: Boolean,
            default: false,
        },
    },
    data(){
        return{
            rolesIds: [
                0,
                1,
                2,
            ],
        }
    },
    methods: {
        closeModal() {
            this.$emit('closeModal');
        },
        storeVanReservation(form) {
            this.$emit('saveVanReservation', form);
        },
        updateVanReservation(form) {
            this.$emit('saveVanReservation', form);
        },
    },
};
</script>

<style scoped>
    .van-reservation-modal-form-container {
        max-height: 670px;
        overflow-y:auto;
    }
</style>