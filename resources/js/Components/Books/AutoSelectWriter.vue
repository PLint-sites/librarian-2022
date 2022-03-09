<script setup>
import { ref } from 'vue'
import Autocomplete from 'vue3-autocomplete'
import 'vue3-autocomplete/dist/vue3-autocomplete.css'

defineProps({
    writers: Array
})

let items = ref([])
const getItems = (text) => {
    items.value = listOfWriters.filter(item => item.name.toLowerCase().includes(text.toLowerCase()))
}
const selectWriter = (writer) => console.log(writer.name)
</script>

<template>
    <div>
        <Autocomplete
            @input="getItems"
            :results="items"
            @onSelect="selectWriter"
        ></Autocomplete>
    </div>
</template>

