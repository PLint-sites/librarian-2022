<template>
    <jet-confirmation-modal :show="show" @close="show = false">
        <template #title>
            <h2>Delete writer</h2>
        </template>

        <template #content>
            <p>Are you sure you want to delete this writer? This action can not be undone, use it with care!</p>
        </template>

        <template #footer>
            <form @submit.prevent="deleteWriter">
                <jet-secondary-button class="mr-2" @click="show = false">
                    <i class="fas fa-book mr-2"></i> No! Keep it
                </jet-secondary-button>

                <jet-button class="bg-purple-600 text-yellow-200" type="submit" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    <i class="fas fa-trash mr-2"></i> Delete
                </jet-button>

                <jet-action-message :on="form.recentlySuccessful" class="mt-4">
                    Writer deleted successfully
                </jet-action-message>
            </form>
        </template>
    </jet-confirmation-modal>
</template>

<script>
import JetConfirmationModal from '@/Jetstream/ConfirmationModal'
import JetButton from '@/Jetstream/Button'
import JetSecondaryButton from '@/Jetstream/SecondaryButton'
import JetActionMessage from '@/Jetstream/ActionMessage'

export default {
    name: 'DeleteWriterModal',
    components: {
        JetConfirmationModal,
        JetButton,
        JetSecondaryButton,
        JetActionMessage
    },
    props: ['showDeleteWriterModal', 'writer'],
    data() {
        return {
            show: this.showDeleteWriterModal,
            form: this.$inertia.form({}),
        }
    },
    emits: ['delete-modal-closed'],
    methods: {
        deleteWriter() {
            this.form.delete(`/writer/${this.writer.id}`, {
                onSuccess: () => {
                    setTimeout(() => {
                        this.show = false
                    }, 300)
                },
                onError: (errors) => {
                    // Handle validation errors
                    // console.log(JSON.stringify(errors))
                },
            })
        },
    },
    watch: {
        showDeleteWriterModal(show) {
            // watches incoming prop, makes sure modal opens when button in parent is clicked
            this.show = show
        },
        show(newValue) {
            // watch local value of show variable, makes sure the parent is notified if modal is closed
            if (!newValue) this.$emit('delete-modal-closed')
        },
    },
}
</script>