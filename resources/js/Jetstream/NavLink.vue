<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>

<script>
    import { defineComponent } from 'vue'
    import { Link } from '@inertiajs/vue3';

    export default defineComponent({
        components: {
            Link,
        },
        props: ['href', 'active'],

        computed: {
            classes() {
                return this.active
                    ? 'inline-flex items-center px-1 pt-1 border-b-2 border-yellow-400 text-sm font-medium leading-5 focus:outline-none focus:border-yellow-700 transition'
                    : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm text-gray-300 font-medium leading-5  hover:border-gray-300 focus:outline-none focus:text-amber-300 focus:border-gray-300 transition'
            }
        }
    })
</script>
