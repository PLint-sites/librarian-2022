<template>
    <div>
        <Combobox v-model="selectedWriter">
            <ComboboxInput 
                className="w-full"
                @change="query = $event.target.value" 
                :displayValue="(writer) => writer ? writer.name : ''"
                placeholder="Start typing writer's name"
            />
            <ComboboxOptions>
                <!-- Use the `active` state to conditionally style the active option. -->
                <!-- Use the `selected` state to conditionally style the selected option. -->
                <ComboboxOption
                    as="template"
                    v-slot="{ active, selected }"
                    v-for="writer in filteredWriters"
                    :key="writer.id"
                    :value="writer"
                >
                    <li
                        :class="{
                            'bg-amber-500 text-purple-500': active && selected,
                            'bg-purple-500 text-amber-500': active,
                            'bg-white text-black': !active
                        }"
                    >
                        <i class="fas fa-check-circle text-purple-500" 
                            :class="{
                                'text-purple-800': selected && active,
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