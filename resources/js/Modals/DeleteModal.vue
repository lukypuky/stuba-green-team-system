<template>
    <div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400">
        <div class="flex items-end justify-center min-h-screen pt-5 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <!-- This element is to trick the browser into centering the modal contents. -->
            <div class="inline-block bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full mt-0"
                role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                    <div class="flex justify-between border-b border-gray-100 px-4 pt-4 font-bold text-red-500">
                        <div>
                            Upozornenie
                        </div>
                    </div>
                    <div class="bg-white px-4 pt-4 pb-4 sm:p-6 sm:pb-4">
                        <div>
                            <span class="text-gray-700" v-if="this.objectName == 'order'">
                                Naozaj si želáte odstrániť túto objednávku ? <br/>
                                Po stlačení tlačidla "Áno" sa objednávka natrvalo odstráni a nebude ju možné vrátiť späť.
                            </span>
                            <span class="text-gray-700" v-else-if="this.objectName == 'task'">
                                Naozaj si želáte odstrániť túto úlohu ? <br/>
                                Po stlačení tlačidla "Áno" sa úloha natrvalo odstráni a nebude ju možné vrátiť späť.
                            </span>
                            <span class="text-gray-700" v-else-if="this.objectName == 'report'">
                                Naozaj si želáte odstrániť tento výkaz ? <br/>
                                Po stlačení tlačidla "Áno" sa výkaz natrvalo odstráni a nebude ho možné vrátiť späť.
                            </span>
                            <span class="text-gray-700" v-else-if="this.objectName == 'attendance'">
                                Naozaj si želáte odstrániť túto dochádzku ? <br/>
                                Po stlačení tlačidla "Áno" sa dochádzka natrvalo odstráni a nebude ho možné vrátiť späť.
                            </span>
                        </div>
                    </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button @click.prevent="deleteObject" type="button"
                        class="inline-flex justify-center w-full border border-red-500 text-red-500 rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:text-white hover:bg-red-600 focus:outline-none focus:shadow-outline">Áno</button>
                    <button @click.prevent="closeDeleteModal" type="button"
                        class="inline-flex justify-center w-full border border-gray-200 bg-gray-200 text-gray-700 rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-gray-300 focus:outline-none focus:shadow-outline">Nie</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "CalendarModal",
        props: {
            deletedObjectId: {
                type: String,
            },
            objectName: {
                type: String,
            }
        },
        methods: {
            closeDeleteModal() {
                this.$emit('closeDeleteModal');
            },
            deleteObject() {
                this.$emit('deleteObject', this.deletedObjectId);
            }
        },
    };
</script>

<style scoped>

</style>