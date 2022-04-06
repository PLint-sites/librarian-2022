<template>
    <div class="relative">
        <Combobox v-model="selectedWriter" >
            <ComboboxInput 
                className="w-full"
                @change="query = $event.target.value" 
                :displayValue="(writer) => writer ? writer.name : ''"
                placeholder="Start typing writer's name"
            />
            <ComboboxOptions
                :class="{
                    'absolute w-full h-40 z-10 overflow-y-auto text-sm bg-white border border-purple-300 py-2 my-1': filteredWriters.length > 0,
                    'absolute w-full h-9 z-10 text-xs': filteredWriters.length === 0
                }"                
            >
                <Link v-if="filteredWriters.length === 0" :href="route('writers')">
                    <i class="fas fa-times"></i> No writer found, create a new one?
                </Link>
                <ComboboxOption
                    v-else
                    as="template"
                    v-slot="{ active, selected }"
                    v-for="writer in filteredWriters"
                    :key="writer.id"
                    :value="writer"
                >
                    <li
                        class="px-3 py-1"
                        :class="{
                            'bg-amber-500 text-purple-500': active && selected,
                            'bg-purple-500 text-amber-500': active,
                            'bg-white text-black': !active
                        }"
                    >
                        <i class="fas fa-check-circle text-purple-500" 
                            :class="{
                                'text-amber-500': selected && active,
                            }" 
                            v-show="selected"
                        ></i>
                        {{ writer.name }}
                    </li>
                </ComboboxOption>
            </ComboboxOptions>
        </Combobox>
    </div>
</template>

<script>
import { Combobox, ComboboxInput, ComboboxOptions, ComboboxOption } from '@headlessui/vue'
import { Link } from '@inertiajs/inertia-vue3';

export default {
    name: 'SelectWriterComboBox',
    components: {
        Combobox, 
        ComboboxInput, 
        ComboboxOptions, 
        ComboboxOption,
        Link
    },
    props: {
        writers: {
            type: Array,
            required: true,
        },
    },
    data() {
        return {
            query: '',
            selectedWriter: null,
        }
    },
    computed: {
        filteredWriters() {
            return this.query.value === '' ? this.writers : this.writers.filter(writer => {
                return writer.name.toLowerCase().includes(this.query.toLowerCase())
            })
        },
    },
    watch: {
        selectedWriter(chosenWriter) {
            this.$emit('writer-chosen', {id: chosenWriter.id})
        },
    },
}
</script>

<style lang="less" scoped>

</style>