<script setup>
import { Head, useForm } from '@inertiajs/inertia-vue3';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

defineProps({
    status: String,
});

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.customEmail'));
};
</script>

<template>
    <Head title="Forgot Password" />

    <AuthenticationCard>
        <div class="mb-4 text-sm text-gray-600">
            Zabudol si heslo ? Žiadny problém. Stačí, ak zadáš svoju emailovú adresu a my Ti pošleme email s odkazom na obnovenie hesla, ktorý Ti umožní zmeniť si heslo.
        </div>

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

        <form @submit.prevent="submit">
            <div>
                <InputLabel for="email" value="Email" />
                <input
                    id="email"
                    v-model="form.email"
                    type="email"
                    class="mt-1 block w-full rounded-md"
                    required
                    autofocus
                />
                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <button class="buttons" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Poslať link
                </button>
            </div>
        </form>
    </AuthenticationCard>
</template>
