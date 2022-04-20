<template>
    <div class="form-group" :class="className">
        <label for="book_writer">Writer</label>

        <SelectWriterComboBox 
            :writers="writers" 
            @writer-chosen="setWriterChosen"
            @query-results-updated="updateStylingFormGroup"    
        />
    </div>
    <div v-if="error" class="mb-2 text-red-500">{{ error }}</div>
</template>

<script>
import SelectWriterComboBox from './SelectWriterComboBox.vue'

export default {
    name: 'SelectWriterFormItem',
    components: {
        SelectWriterComboBox,
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
    data() {
        return {
            className: '',
        }
    },
    methods: {
        setWriterChosen({id}) {
            this.$emit('writer-chosen', {id})
        },
        updateStylingFormGroup({n}) {
            if (n === 0) {
                this.className = 'no-writers-found'
            } else {
                this.className = ''
            }
        },
    },
}
</script>

<style lang="less" scoped>
.form-group.no-writers-found {
    margin-bottom: 52px;
}
</style>