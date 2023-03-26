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
                    <input type="hidden" name="id" v-model="this.form.id"/>
                    <div class="flex justify-between border-b border-gray-100 px-4 pt-4 font-bold">
                        <div>
                            <span class="text-gray-700">Pridať novú úlohu</span>
                        </div>
                    </div>
                    <div class="bg-white px-4 pt-4 pb-4 sm:p-6 sm:pb-4 modal-height">
                        <div>
                            <div class="col-span-6 sm:col-span-3 mb-3">
                                <label for="type_id"
                                    class="block text-gray-700 text-sm font-bold mb-2">Typ <span class="text-red-500">*</span></label>
                                <select id="type_id" v-model="form.type_id"
                                    class="mt-1 block form-select w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" required>
                                    <option v-for="(taskType, index) in taskTypes" :key="index" :value="taskType.id">{{ taskType.task_type_title }}</option>
                                </select>
                                <div v-if="$page.props.errors.type_id" class="text-red-500">
                                    {{ $page.props.errors.type_id }}
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="task_title"
                                    class="block text-gray-700 text-sm font-bold mb-2">Názov <span class="text-red-500">*</span></label>
                                <input type="text" v-model="form.task_title"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-800 leading-tight focus:outline-none focus:shadow-outline"
                                    id="task_title"
                                    autocomplete="off" required/>
                                <div v-if="$page.props.errors.task_title" class="text-red-500">
                                    {{ $page.props.errors.task_title }}
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="description" 
                                    class="block text-gray-700 text-sm font-bold mb-2">Popis </label>
                                <textarea v-model="form.description"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    id="description">
                                </textarea>
                            </div>
                            <div class="col-span-6 sm:col-span-3 mb-3">
                                <label for="task_priority_id"
                                    class="block text-gray-700 text-sm font-bold mb-2">Priorita <span class="text-red-500">*</span></label>
                                <select id="task_priority_id" v-model="form.task_priority_id"
                                    class="mt-1 block form-select w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" required>
                                    <option v-for="(taskPriority, index) in taskPriorities" :key="index" :value="taskPriority.id">{{ taskPriority.task_priority_title }}</option>
                                </select>
                                <div v-if="$page.props.errors.priority_id" class="text-red-500">
                                    {{ $page.props.errors.priority_id }}
                                </div>
                            </div>
                            <div class="col-span-6 sm:col-span-3 mb-3">
                                <label for="division_id"
                                    class="block text-gray-700 text-sm font-bold mb-2">Divízia <span class="text-red-500">*</span></label>
                                <select id="division_id" v-model="form.division_id"
                                    class="mt-1 block form-select w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" required>
                                    <option v-for="(division, index) in divisions" :key="index" :value="division.id">{{ division.division_title }}</option>
                                </select>
                                <div v-if="$page.props.errors.division_id" class="text-red-500">
                                    {{ $page.props.errors.division_id }}
                                </div>
                            </div>
                            <div class="col-span-6 sm:col-span-3 mb-3">
                                <label for="area_id" 
                                    class="block text-gray-700 text-sm font-bold mb-2">Oblasť <span class="text-red-500">*</span></label>
                                <select id="area_id" v-model="form.area_id"
                                    class="mt-1 block form-select w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" required>
                                    <option v-for="(area, index) in areas" :key="index" :value="area.id">{{ area.area_title }}</option>
                                </select>
                                <div v-if="$page.props.errors.area_id" class="text-red-500">
                                    {{ $page.props.errors.area_id }}
                                </div>
                            </div>
                            <!-- <div class="col-span-6 sm:col-span-3 mb-3">
                                <label for="task_user_id"
                                    class="block text-gray-700 text-sm font-bold mb-2">Priradiť <span class="text-red-500">*</span></label>
                                <select id="task_user_id"
                                    class="mt-1 block form-select w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" required>
                                    <option value="1">Daco</option>
                                </select>
                            </div> -->
                            <div class="mb-3">
                                <label for="deadline"
                                    class="block text-gray-700 text-sm font-bold mb-2">Deadline</label>
                                <input type="date" v-model="form.deadline"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    id="deadline" />
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button @click.prevent="storeTask(form)" type="button"
                            class="inline-flex justify-center w-full rounded-md px-4 py-2 m-2 transition duration-500 ease select-none buttons">Pridať</button>
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
    name: "TaskModal",
    props: {
        form: {
            type: Object,
            default: () => { }
        },
        taskTypes:{
            type: Object,
            default: () => { }
        }, 
        taskPriorities:{
            type: Object,
            default: () => { }
        }, 
        divisions:{
            type: Object,
            default: () => { }
        }, 
        areas:{
            type: Object,
            default: () => { }
        }, 
    },
    methods: {
        closeModal() {
            this.$emit('closeModal');
        },
        storeTask(form) {
            this.$emit('saveTask', form);
        },
        // updateReport(form) {

        // },
        // deleteReport(form) {

        // }
    },
    
};
</script>

<style scoped>

</style>