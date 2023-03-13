<template>
    <div class="fixed z-10 inset-0 ease-out duration-400">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <!-- This element is to trick the browser into centering the modal contents. -->
            <div class="inline-block bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full mt-0"
                role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                <form>
                    <input type="hidden" name="id" v-model="this.form.id" />
                    <div class="flex justify-between border-b border-gray-100 px-4 pt-4 font-bold">
                        <div>
                            <span class="text-gray-700" v-if="this.updateReportFlag == false">Pridať nový výkaz</span>
                            <span class="text-gray-700" v-else>Upraviť výkaz</span>
                        </div>
                    </div>
                    <div class="bg-white px-4 pt-4 pb-4 sm:p-6 sm:pb-4 modal-height">
                        <div>
                            <div class="col-span-6 sm:col-span-3 mb-3">
                                <label for="task_id"
                                    class="block text-gray-700 text-sm font-bold mb-2">Úloha <span class="text-red-500">*</span></label>
                                <select id="task_id" v-model="form.task_id" 
                                    class="mt-1 block form-select w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" required>
                                    <option v-for="(task, index) in modalTasks" :key="index" :value="task.id">{{ task.task_title }}</option>
                                </select>
                                <div v-if="$page.props.errors.task_id" class="text-red-500">
                                    {{ $page.props.errors.task_id }}
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="report_title"
                                    class="block text-gray-700 text-sm font-bold mb-2">Názov <span class="text-red-500">*</span></label>
                                <input v-model="form.report_title" type="text"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-800 leading-tight focus:outline-none focus:shadow-outline"
                                    id="report_title"
                                    autocomplete="off" required/>
                                <div v-if="$page.props.errors.report_title" class="text-red-500">
                                    {{ $page.props.errors.report_title }}
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="date"
                                    class="block text-gray-700 text-sm font-bold mb-2">Dátum</label>
                                <input v-model="form.date" disabled="true" type="text"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    id="date" />
                            </div>
                            <div class="mb-3">
                                <label for="start_time"
                                    class="block text-gray-700 text-sm font-bold mb-2">Od <span class="text-red-500">*</span></label>
                                <input v-model="form.start_time" type="time"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    id="start_time" />
                                <div v-if="$page.props.errors.start_time" class="text-red-500">
                                    {{ $page.props.errors.start_time }}
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="end_time"
                                    class="block text-gray-700 text-sm font-bold mb-2">Do <span class="text-red-500">*</span></label>
                                <input v-model="form.end_time" type="time"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    id="end_time" required/>
                                <div v-if="$page.props.errors.end_time" class="text-red-500">
                                    {{ $page.props.errors.end_time }}
                                </div>
                            </div>
                            <div>
                                <label for="description"
                                    class="block text-gray-700 text-sm font-bold mb-2">Poznámka:</label>
                                <textarea v-model="form.description"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    id="description">
                                </textarea>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button @click.prevent="storeReport(this.form)" type="button" :class="{ hidden:this.updateReportFlag}"
                            class="inline-flex justify-center w-full border border-teal-500 bg-teal-500 text-white rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-teal-600 focus:outline-none focus:shadow-outline">Pridať</button>
                        <button @click.prevent="updateReport(this.form)" type="button" :class="{ hidden:!this.updateReportFlag}"
                            class="inline-flex justify-center w-full border border-teal-500 bg-teal-500 text-white rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-teal-600 focus:outline-none focus:shadow-outline">Upraviť</button>
                        <button @click.prevent="deleteOrderModal(this.form)" type="button" :class="{ hidden:!this.updateReportFlag}"
                            class="inline-flex justify-center w-full border border-red-500 text-red-500 rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:text-white hover:bg-red-600 focus:outline-none focus:shadow-outline">Zmazať</button>
                        <button @click.prevent="closeModal(form)" type="button"
                            class="inline-flex justify-center w-full border border-gray-200 bg-gray-200 text-gray-700 rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-gray-300 focus:outline-none focus:shadow-outline">Zrušiť</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <DeleteModal v-if="this.showDeleteModal" @closeDeleteModal="closeDeleteModal" @deleteObject="deleteObject" :deletedObjectId="deletedObjectId"/>
</template>

<script>
    import DeleteModal from '@/Modals/DeleteModal.vue';
    import { Inertia } from '@inertiajs/inertia';

    export default {
        name: "CalendarModal",
        components: {
            DeleteModal,
        },
        props: {
            form: {
                type: Object,
                default: () => { }
            },
            updateReportFlag: {
                type: Boolean,
                default: false,
            },
            modalTasks:{
                type: Object,
                default: () => { }
            }, 
        },
        data(){
            return{
                showDeleteModal: false,
                deletedObjectId: '',
            }
        },
        emits: {
            closeModal: null,
            saveReport: null,
            deleteReport: null,
        },
        methods: {
            closeModal() {
                this.$emit('closeModal');
            },
            storeReport(form) {
                this.$emit('saveReport', form);
            },
            updateReport(form) {
                this.$emit('saveReport', form);
            },
            deleteOrderModal(orderId){
                this.showDeleteModal = true;
                this.deletedObjectId = orderId.id;
            },
            deleteObject(param){
                var request = {id: param};

                Inertia.post(route("dashboard-delete-report"), request, {
                    onSuccess: page => {
                        if (Object.entries(page.props.errors).length === 0) {
                            this.closeDeleteModal()
                            this.closeModal();
                            this.$emit('deleteReport', page.props.reports);
                        }
                    }
                });

                Inertia.on("error", event => {
                    event.preventDefault();
                    console.log('error pri deleteReport ', event.message);
                });
            },
            closeDeleteModal() {
                this.showDeleteModal = false;
            },
        },
    };
</script>

<style scoped>

</style>