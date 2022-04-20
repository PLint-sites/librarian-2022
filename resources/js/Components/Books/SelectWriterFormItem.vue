<template>
    <div class="form-group">
        <label for="book_writer">Writer</label>

        <SelectWriterComboBox :writers="writers" @writer-chosen="setWriterChosen"/>
    </div>
    <div v-if="error" class="mb-2 text-red-500">{{ error }}</div>
</template>

<script>
import SelectWriterComboBox from './SelectWriterComboBox.vue'

export default {
    name: 'SelectWriterFormItem',
    components: {
        SelectWriterComboBox
    },
    props: {
        writers: {
            type: Array,
            required: true,
        },
        error: {
            required: false,
        },
    },
    methods: {
        setWriterChosen({id}) {
            this.$emit('writer-chosen', {id})
        },
    },
}
</script>

<style lang="less" scoped>

</style>