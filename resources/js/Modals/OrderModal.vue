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
                    <div class="flex justify-between border-b border-gray-100 px-4 pt-4 font-bold">
                        <div>
                            <span class="text-gray-700" v-if="this.updateOrderFlag == false">Pridať novú objednávku</span>
                            <span class="text-gray-700" v-else>Upraviť objednávku</span>
                        </div>
                    </div>
                    <div class="bg-white px-4 pt-4 pb-4 sm:p-6 sm:pb-4 order-modal-form-container">
                        <div>
                            <div class="mb-3">
                                <label for="order_number"
                                    class="block text-gray-700 text-sm font-bold mb-2">Objednávkové číslo <span class="text-red-500">*</span></label>
                                <input type="text" v-model="form.order_number"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-800 leading-tight focus:outline-none focus:shadow-outline"
                                    id="order_number"
                                    autocomplete="off" required/>
                                <div v-if="$page.props.errors.order_number" class="text-red-500">
                                    {{ $page.props.errors.order_number }}
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="order_title"
                                    class="block text-gray-700 text-sm font-bold mb-2">Presný názov <span class="text-red-500">*</span></label>
                                <input type="text" v-model="form.order_title"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-800 leading-tight focus:outline-none focus:shadow-outline"
                                    id="order_title"
                                    autocomplete="off" required/>
                                <div v-if="$page.props.errors.order_title" class="text-red-500">
                                    {{ $page.props.errors.order_title }}
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="description" 
                                    class="block text-gray-700 text-sm font-bold mb-2">Stručný popis </label>
                                <textarea v-model="form.description"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    id="description">
                                </textarea>
                            </div>
                            <div class="col-span-6 sm:col-span-3 mb-3">
                                <label for="formula_part_specify_id"
                                    class="block text-gray-700 text-sm font-bold mb-2">Kde je to určené <span class="text-red-500">*</span></label>
                                <select id="formula_part_specify_id" v-model="form.formula_part_specify_id"
                                    class="mt-1 block form-select w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" required>
                                    <option v-for="(formulaPartSpecify, index) in this.formulaPartSpecifies" :key="index" :value="formulaPartSpecify.id">{{ formulaPartSpecify.formula_part_specify_title }}</option>
                                </select>
                                <div v-if="$page.props.errors.formula_part_specify_id" class="text-red-500">
                                    {{ $page.props.errors.formula_part_specify_id }}
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="quantity"
                                    class="block text-gray-700 text-sm font-bold mb-2">Množstvo <span class="text-red-500">*</span></label>
                                <input type="number" v-model="form.quantity"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-800 leading-tight focus:outline-none focus:shadow-outline"
                                    id="quantity"
                                    autocomplete="off" required/>
                                <div v-if="$page.props.errors.quantity" class="text-red-500">
                                    {{ $page.props.errors.quantity }}
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="price_per_piece"
                                    class="block text-gray-700 text-sm font-bold mb-2">Cena za kus <span class="text-red-500">*</span></label>
                                <input type="number" v-model="form.price_per_piece"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-800 leading-tight focus:outline-none focus:shadow-outline"
                                    id="price_per_piece"
                                    autocomplete="off" required/>
                                <div v-if="$page.props.errors.price_per_piece" class="text-red-500">
                                    {{ $page.props.errors.price_per_piece }}
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="price_total"
                                    class="block text-gray-700 text-sm font-bold mb-2">Celková cena <span class="text-red-500">*</span></label>
                                <input type="number" v-model="form.price_total"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-800 leading-tight focus:outline-none focus:shadow-outline"
                                    id="price_total"
                                    autocomplete="off" required/>
                                <div v-if="$page.props.errors.price_total" class="text-red-500">
                                    {{ $page.props.errors.price_total }}
                                </div>
                            </div>
                            <div class="col-span-6 sm:col-span-3 mb-3">
                                <label for="currency_id"
                                    class="block text-gray-700 text-sm font-bold mb-2">Mena <span class="text-red-500">*</span></label>
                                <select id="currency_id" v-model="form.currency_id"
                                    class="mt-1 block form-select w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" required>
                                    <option v-for="(currency, index) in this.currencies" :key="index" :value="currency.id">{{ currency.shortcut }}</option>
                                </select>
                                <div v-if="$page.props.errors.currency_id" class="text-red-500">
                                    {{ $page.props.errors.currency_id }}
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="shop"
                                    class="block text-gray-700 text-sm font-bold mb-2">Obchod <span class="text-red-500">*</span></label>
                                <input type="text" v-model="form.shop"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-800 leading-tight focus:outline-none focus:shadow-outline"
                                    id="shop"
                                    autocomplete="off" required/>
                                <div v-if="$page.props.errors.shop" class="text-red-500">
                                    {{ $page.props.errors.shop }}
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="link"
                                    class="block text-gray-700 text-sm font-bold mb-2">Link <span class="text-red-500">*</span></label>
                                <input type="text" v-model="form.link"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-800 leading-tight focus:outline-none focus:shadow-outline"
                                    id="link"
                                    autocomplete="off" required/>
                                <div v-if="$page.props.errors.link" class="text-red-500">
                                    {{ $page.props.errors.link }}
                                </div>
                            </div>
                            <div class="col-span-6 sm:col-span-3 mb-3">
                                <label for="order_priority_id"
                                    class="block text-gray-700 text-sm font-bold mb-2">Priorita <span class="text-red-500">*</span></label>
                                <select id="order_priority_id" v-model="form.order_priority_id"
                                    class="mt-1 block form-select w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" required>
                                    <option v-for="(orderPriority, index) in this.orderPriorities" :key="index" :value="orderPriority.id">{{ orderPriority.order_priority_title }}</option>
                                </select>
                                <div v-if="$page.props.errors.order_priority_id" class="text-red-500">
                                    {{ $page.props.errors.order_priority_id }}
                                </div>
                            </div>
                            <div class="col-span-6 sm:col-span-3 mb-3">
                                <label for="order_status_id"
                                    class="block text-gray-700 text-sm font-bold mb-2">Stav <span class="text-red-500">*</span></label>
                                <select id="order_status_id" v-model="form.order_status_id"
                                    class="mt-1 block form-select w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" required>
                                    <option v-for="(orderStatus, index) in this.orderStatuses" :key="index" :value="orderStatus.id">{{ orderStatus.order_status_title }}</option>
                                </select>
                                <div v-if="$page.props.errors.order_status_id" class="text-red-500">
                                    {{ $page.props.errors.order_status_id }}
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="order_comment" 
                                    class="block text-gray-700 text-sm font-bold mb-2">Poznámka </label>
                                <textarea v-model="form.order_comment"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    id="order_comment">
                                </textarea>
                            </div>
                            <div class="mb-3" v-if="updateOrderFlag">
                                <label for="delivery_date"
                                    class="block text-gray-700 text-sm font-bold mb-2">Dátum dodania</label>
                                <input type="date" v-model="form.delivery_date"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    id="delivery_date" />
                            </div>
                            <div class="col-span-6 sm:col-span-3 mb-3" v-if="updateOrderFlag">
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
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button @click.prevent="storeOrder(form)" type="button" :class="{ hidden:this.updateOrderFlag}"
                            class="inline-flex justify-center w-full rounded-md px-4 py-2 m-2 transition duration-500 ease select-none buttons">Pridať</button>
                        <button @click.prevent="updateOrder(form)" type="button" :class="{ hidden:!this.updateOrderFlag}"
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
    name: "TaskModal",
    props: {
        form: {
            type: Object,
            default: () => { }
        },
        updateOrderFlag: {
            type: Boolean,
            default: false,
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
    methods: {
        closeModal() {
            this.$emit('closeModal');
        },
        storeOrder(form) {
            this.$emit('saveOrder', form);
        },
        updateOrder(form) {
            this.$emit('saveOrder', form);
        },
    },
};
</script>

<style scoped>
    .order-modal-form-container{
        max-height: 670px;
        overflow-y:auto;
    }
</style>