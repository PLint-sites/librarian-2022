<template>
    <jet-dialog-modal :show="show" @close="show = false">
        <template #title>
            <h2 class="text-purple-700">Edit author</h2>
        </template>

        <template #content>
            <form @submit.prevent="updateWriter">
                <!-- name -->
                <div class="form-group">
                    <label for="writer_name">Name</label>
                    <input id="writer_name" type="text" v-model="form.name" placeholder="Name" @focus="clearError('name')">
                </div>
                <div v-if="form.errors.name" class="mb-2 text-red-500">{{ form.errors.name }}</div>
                
                <!-- submit -->
                <div class="mt-4">
                    <jet-button class="bg-purple-600 text-yellow-200" type="submit" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        <i class="fas fa-pencil-alt mr-2"></i> Update
                    </jet-button>
                </div>

                <jet-action-message :on="form.recentlySuccessful" class="mt-3">
                    Author updated successfully
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
    name: 'EditWriterModal',
    components: {
        JetDialogModal,
        JetButton,
        JetActionMessage
    },
    props: ['showEditWriterModal', 'writer'],
    data() {
        return {
            show: this.showEditWriterModal,
            form: this.$inertia.form({
                name: this.writer.name,
            }),
        }
    },
    emits: ['modal-closed'],
    methods: {
        updateWriter() {
            this.form
            .transform(data => ({
                ...data,
            }))
            .patch(`/writer/${this.writer.id}`, {
                onSuccess: () => {
                    // this.form.reset()

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
        showEditWriterModal(show) {
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