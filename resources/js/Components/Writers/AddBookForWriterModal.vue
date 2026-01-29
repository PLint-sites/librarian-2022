<template>
    <jet-dialog-modal :show="show" @close="show = false">
        <template #title>
            <h2 class="text-purple-700">Add book for {{ writer.name }}</h2>
        </template>

        <template #content>
            <form @submit.prevent="storeBook">
                <!-- title -->
                <div class="form-group">
                    <label for="book_title">Title</label>
                    <input id="book_title" type="text" v-model="form.title" placeholder="Title" @focus="clearError('title')">
                </div>
                <div v-if="form.errors.title" class="mb-2 text-red-500">{{ form.errors.title }}</div>

                <!-- genre -->
                <div class="form-group">
                    <label for="book_genre">Genre</label>
                    <select id="book_genre" v-model="form.genre_id" @focus="clearError('genre_id')">
                        <option disabled value="">Select genre</option>
                        <option v-for="genre in genres" :key="genre.id" :value="genre.id">{{ genre.name }}</option>
                    </select>
                </div>
                <div v-if="form.errors.genre_id" class="mb-2 text-red-500">{{ form.errors.genre_id }}</div>

                <!-- start_reading -->
                <div class="form-group book-checkbox">
                    <label for="start_reading">Start reading</label>
                    <input id="start_reading" type="checkbox" v-model="form.start_reading">
                </div>

                <!-- owned -->
                <div class="form-group book-checkbox">
                    <label for="book_owned">Owned</label>
                    <input id="book_owned" type="checkbox" v-model="form.owned">
                </div>
                
                <!-- completed -->
                <div class="form-group book-checkbox">
                    <label for="book_completed">Completed</label>
                    <input id="book_completed" type="checkbox" v-model="form.completed">
                </div>

                <!-- comment -->
                <div class="form-group form-group-ta">
                    <label for="comment">Comment</label>
                    <textarea id="comment" v-model="form.comment" placeholder="Comment" @focus="clearError('comment')"></textarea>
                </div>
                <div v-if="form.errors.comment" class="mb-2 text-red-500">{{ form.errors.comment }}</div>
                
                <!-- submit -->
                <div class="mt-4">
                    <jet-button class="bg-purple-600 text-yellow-200" type="submit" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        <i class="fas fa-save mr-2"></i> Add
                    </jet-button>
                </div>

                <jet-action-message :on="form.recentlySuccessful" class="mt-3">
                    Book added successfully
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
    name: 'AddBookForWriterModal',
    components: {
        JetDialogModal,
        JetButton,
        JetActionMessage,
    },
    props: ['showAddBookModal', 'writer', 'genres'],
    data() {
        return {
            show: this.showAddBookModal,
            form: this.$inertia.form({
                title: null,
                comment: null,
                genre_id: null,
                start_reading: true,
                owned: false,
                completed: false,
            }),
        }
    },
    emits: ['modal-closed'],
    methods: {
        storeBook() {
            this.form.post(`/writer/${this.writer.id}/book`, {
                onSuccess: () => {
                    this.form.reset()

                    setTimeout(() => {
                        this.show = false
                    }, 300)
                },
            })
        },
        clearError(field) {
            if (this.form.hasErrors) {
                this.form.clearErrors(field)
            }
        },
    },
    watch: {
        showAddBookModal(show) {
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
.book-checkbox {
    grid-template-rows: 1fr;
    grid-template-columns: 26px 120px;
    height: 42px;

    label {
        grid-column-start: 2;
        grid-column-end: 3;
        grid-row-start: 1;
        grid-row-end: 2;
    }

    input {
        grid-column-start: 1;
        grid-column-end: 2;
        grid-row-start: 1;
        grid-row-end: 2;
    }

    @media (min-width: 768px) {
        grid-template-columns: 100px 1fr;

        label {
            grid-column-start: 1;
            grid-column-end: 2;
        }

        input {
            grid-column-start: 2;
            grid-column-end: 3;
        }
    }
}

.form-group-ta {
    grid-template-rows: 42px 84px;
    height: auto;

    textarea {
        height: 84px;
    }

    @media (min-width: 768px) {
        grid-template-rows: 1fr;
    }
}
</style>
