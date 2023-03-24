<template>
    <div v-if="links.length > 3">
        <div class="flex flex-wrap mb-1 justify-center">
            <template v-for="(link, k) in links" :key="k">
                <div v-if="link.url === null"  class="mr-1 mb-1 px-4 py-3 text-sm leading-4" v-html="link.label"></div>
                <Link v-else class="mr-1 mb-1 px-4 py-3 text-sm leading-4" :class="{ 'active': link.active }" :href="link.url" v-html="link.label"></Link>
            </template>
        </div>
    </div>
</template>

<script>
    import { Link } from '@inertiajs/inertia-vue3';

    export default {
        name: 'Pagination',
        components: {
            Link,
        },
        props: {
            links: Object,
        },
    }
</script>

<style scoped>
    .active {
        color: var(--sgt-color);
        font-weight: bold;
        border-bottom: 2px solid var(--sgt-color);
        border-radius: 0;
    }
</style>