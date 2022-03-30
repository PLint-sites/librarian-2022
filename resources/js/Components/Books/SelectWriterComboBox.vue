<template>
    <div>
        <Combobox v-model="selectedWriter">
            <ComboboxInput 
                @change="query = $event.target.value" 
                :displayValue="(writer) => writer ? writer.name : ''"
                placeholder="Start typing writer's name"
            />
            <ComboboxOptions>
                <ComboboxOption
                    v-for="writer in filteredWriters"
                    :key="writer.id"
                    :value="writer"
                >
                {{ writer.name }}
                </ComboboxOption>
            </ComboboxOptions>
        </Combobox>
    </div>
</template>

<script>
import { Combobox, ComboboxInput, ComboboxOptions, ComboboxOption } from '@headlessui/vue'

export default {
    name: 'SelectWriterComboBox',
    components: {
        Combobox, 
        ComboboxInput, 
        ComboboxOptions, 
        ComboboxOption
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
            // selectedWriter: this.writers[0],
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
}
</script>

<style lang="less" scoped>

</style>