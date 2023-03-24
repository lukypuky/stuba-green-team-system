<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/inertia-vue3';

const props = defineProps({
    active: Boolean,
    href: String,
    as: String,
});

const classes = computed(() => {
    return props.active
        ? ''
        : 'block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-100 hover:text-gray-400 focus:outline-none focus:text-gray-400 transition';
});
</script>

<template>
    <button v-if="as == 'button'" :class="classes" class="w-full text-left">
        <slot />
    </button>

    <Link v-else :href="href" :class="classes">
        <slot />
    </Link>
</template>
