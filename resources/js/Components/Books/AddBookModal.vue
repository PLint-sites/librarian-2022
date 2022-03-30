<template>
    <jet-dialog-modal :show="show" @close="show = false">
        <template #title>
            <h2 class="text-purple-700">Add book</h2>
        </template>

        <template #content>
            <form @submit.prevent="storeBook">
                <!-- title -->
                <div class="form-group">
                    <label for="book_title">Title</label>
                    <input id="book_title" type="text" v-model="form.title" placeholder="Title" @focus="clearError('title')">
                </div>
                <div v-if="form.errors.title" class="mb-2 text-red-500">{{ form.errors.title }}</div>

                <!-- writer -->
                <div class="form-group">
                    <label for="book_writer">Writer</label>

                    <SelectWriterComboBox :writers="writers" @writer-chosen="setWriterChosen"/>
                    <!-- <select id="book_writer" v-model="form.writer_id" @focus="clearError('writer_id')">
                        <option disabled value="">Select writer</option>
                        <option v-for="writer in writers" :key="writer.id" :value="writer.id">{{ writer.name }}</option>
                    </select> -->
                </div>
                <div v-if="form.errors.writer_id" class="mb-2 text-red-500">{{ form.errors.writer_id }}</div>

                <!-- genre -->
                <div class="form-group">
                    <label for="book_genre">Genre</label>
                    <select id="book_genre" v-model="form.genre_id" @focus="clearError('genre_id')">
                        <option disabled value="">Select genre</option>
                        <option v-for="genre in genres" :key="genre.id" :value="genre.id">{{ genre.name }}</option>
                    </select>
                </div>
                <div v-if="form.errors.genre_id" class="mb-2 text-red-500">{{ form.errors.genre_id }}</div>

                <!-- owned -->
                <div class="form-group  book-checkbox">
                    <label for="book_owned">Owned</label>
                    <input id="book_owned" type="checkbox" v-model="form.owned">
                </div>
                
                <!-- completed -->
                <div class="form-group book-checkbox">
                    <label for="book_completed">Completed</label>
                    <input id="book_completed" type="checkbox" v-model="form.completed">
                </div>
                
                <!-- submit -->
                <div>
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
import SelectWriterComboBox from './SelectWriterComboBox.vue'

export default {
    name: 'AddBookModal',
    components: {
        JetDialogModal,
        JetButton,
        JetActionMessage,
        SelectWriterComboBox,
    },
    props: ['showAddBookModal', 'writers', 'genres'],
    data() {
        return {
            show: this.showAddBookModal,
            form: this.$inertia.form({
                title: null,
                writer_id: null,
                genre_id: null,
                owned: false,
                completed: false,
            }),
        }
    },
    emits: ['modal-closed'],
    methods: {
        storeBook() {
            this.form
            .transform(data => ({
                ...data,
            }))
            .post('/book', {
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
        setWriterChosen({id: writerId}) {
            this.form.writer_id = writerId
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
</style>