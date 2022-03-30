<template>
    <div>
        <transition leave-active-class="transition ease-in duration-1000" leave-from-class="opacity-100" leave-to-class="opacity-0">
            <div v-show="on" class="text-sm bg-purple-300 text-purple-600 px-4 py-2">
                <slot />
            </div>
        </transition>
    </div>
</template>

<script>
    import { defineComponent } from 'vue'

    export default defineComponent({
        props: ['on'],
    })
</script>
