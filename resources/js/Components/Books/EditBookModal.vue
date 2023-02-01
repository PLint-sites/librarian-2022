<template>
    <jet-dialog-modal :show="show" @close="show = false">
        <template #title>
            <h2 class="text-purple-700">Edit book</h2>
        </template>

        <template #content>
            <form @submit.prevent="updateBook">
                <!-- title -->
                <div class="form-group">
                    <label for="book_title">Title</label>
                    <input id="book_title" type="text" v-model="form.title" placeholder="Title" @focus="clearError('title')">
                </div>
                <div v-if="form.errors.title" class="mb-2 text-red-500">{{ form.errors.title }}</div>

                <!-- writer -->
                <div class="form-group">
                    <label for="book_writer">Writer</label>
                    <select id="book_writer" v-model="form.writer_id" @focus="clearError('writer_id')">
                        <option disabled value="">Select writer</option>
                        <option v-for="writer in writers" :key="writer.id" :value="writer.id">{{ writer.name }}</option>
                    </select>
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
                <div class="form-group book-checkbox">
                    <label for="book_owned">Owned</label>
                    <input id="book_owned" type="checkbox" v-model="form.owned">
                </div>
                
                <!-- completed -->
                <div class="form-group book-checkbox">
                    <label for="book_completed">Completed</label>
                    <input id="book_completed" type="checkbox" v-model="form.completed">
                </div>

                <!-- on loan -->
                <div id="on-loan-container">
                    <label for="book_on_loan">On loan to</label>
                    <input id="book_on_loan" type="text" v-model="form.on_loan_to" placeholder="On loan to" @focus="clearError('on_loan_to')">
                    <p v-if="form.on_loan_to && form.on_loan_to.length > 0" id="helptext" class="text-xs">Clear field when book is back</p>
                </div>
                <div v-if="form.errors.on_loan_to" class="mb-2 text-red-500">{{ form.errors.on_loan_to }}</div>

                <!-- submit -->
                <div>
                    <jet-button class="bg-purple-600 text-yellow-200" type="submit" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        <i class="fas fa-book mr-2"></i> Update
                    </jet-button>
                </div>

                <jet-action-message :on="form.recentlySuccessful" class="mt-3">
                    Book updated successfully
                </jet-action-message>
            </form>
        </template>

        <template #footer>
            <Link :href="`/book/${book.id}`" method="delete" preserve-scroll><i class="fas fa-trash"></i></Link>
        </template>

    </jet-dialog-modal>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3'
import JetDialogModal from '@/Jetstream/DialogModal'
import JetButton from '@/Jetstream/Button'
import JetActionMessage from '@/Jetstream/ActionMessage'

export default {
    name: 'EditBookModal',
    components: {
        Link,
        JetDialogModal,
        JetButton,
        JetActionMessage
    },
    props: ['showEditBookModal', 'book', 'writers', 'genres'],
    data() {
        return {
            show: this.showEditBookModal,
            form: this.$inertia.form({
                title: this.book.title,
                writer_id: this.book.writer_id,
                genre_id: this.book.genre_id,
                owned: !!this.book.owned,
                completed: !!this.book.completed,
                on_loan_to: this.book.on_loan_to
            }),
        }
    },
    emits: ['modal-closed'],
    methods: {
        updateBook() {
            this.form
            .transform(data => ({
                ...data,
            }))
            .patch(`/book/${this.book.id}`, {
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
        showEditBookModal(show) {
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

#on-loan-container {
    display: grid;
    grid-template-rows: 42px 42px 42px;
    grid-gap: 5px 0;
    align-items: center;
    margin-bottom: 5px;

    #helptext {
        align-self: start;
    }
}

@media (min-width: 768px) {
    #on-loan-container {
        display: grid;
        grid-gap: 5px 15px;
        grid-template-rows: 42px 18px;
        grid-template-columns: 100px 1fr;
        align-items: center;
        margin-bottom: 15px;

        #helptext {
            grid-column-start: 2;
        }
    }
}
</style>