<template>
    <jet-dialog-modal :show="show" @close="show = false">
        <template #title>
            <h2 class="text-purple-700">Add author</h2>
        </template>

        <template #content>
            <form @submit.prevent="storeWriter">
                <!-- name -->
                <div class="form-group">
                    <label for="writer_name">Name</label>
                    <input id="writer_name" type="text" v-model="form.name" placeholder="Name" @focus="clearError('name')">
                </div>
                <div v-if="form.errors.name" class="mb-2 text-red-500">{{ form.errors.name }}</div>

                <!-- submit -->
                <div class="mt-4">
                    <jet-button class="bg-purple-600 text-yellow-200" type="submit" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        <i class="fas fa-pencil-alt mr-2"></i> Add
                    </jet-button>
                </div>

                <jet-action-message :on="form.recentlySuccessful" class="mt-3">
                    Author added successfully
                </jet-action-message>
            </form>
        </template>

    </jet-dialog-modal>
</template>

<script>
import JetDialogModal from '@/Jetstream/DialogModal'
import JetButton from '@/Jetstream/Button'
import JetActionMessage from '@/Jetstream/ActionMessage'

export default {
    name: 'AddWriterModal',
    components: {
        JetDialogModal,
        JetButton,
        JetActionMessage
    },
    props: ['showAddWriterModal'],
    data() {
        return {
            show: this.showAddWriterModal,
            form: this.$inertia.form({
                name: null,
            }),
        }
    },
    emits: ['modal-closed'],
    methods: {
        storeWriter() {
            this.form
            .transform(data => ({
                ...data,
            }))
            .post('/writer', {
                onSuccess: () => {
                    this.form.reset()

                    setTimeout(() => {
                        this.show = false
                    }, 300)
                },
                onError: (errors) => {
                    // Handle validation errors
                    // console.log(JSON.stringify(errors))
                },
                onFinish: () => {
                    
                }
            })
        },
        clearError(field) {
            if (this.form.hasErrors) {
                this.form.clearErrors(field)
            }
        },
    },
    watch: {
        showAddWriterModal(show) {
            // watches incoming prop, makes sure modal opens when button in parent is clicked
            this.show = show
        },
        show(newValue) {
            // watch local value of show variable, makes sure the parent is notified if modal is closed
            if (!newValue) this.$emit('modal-closed')
        },
    },
}
</script>

<style lang="less" scoped>

</style>