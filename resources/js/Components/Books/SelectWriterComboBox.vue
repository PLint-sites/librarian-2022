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
                    'absolute top-14 w-full h-12 z-10 text-red-700': filteredWriters.length === 0
                }"                
            >
                <span v-if="filteredWriters.length === 0">
                    No writer found for <b>{{ query }}</b>, let's create a new one
                    <Link :href="route('writers')" class="px-2.5 py-1.5 bg-red-200 rounded-full ml-1">
                        <i class="fas fa-plus"></i>
                    </Link>
                </span>
                
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
import { Link } from '@inertiajs/vue3';

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
        filteredWriters(writerList) {
            this.$emit('query-results-updated', {n: writerList.length})
        },
    },
}
</script>

<style lang="less" scoped>

</style>