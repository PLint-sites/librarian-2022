<template>
    <form @submit.prevent="storeBookAndWriter">
        <h2>Add your first book</h2>
        <!-- title -->
        <div class="form-group">
            <label for="book_title">Title</label>
            <input id="book_title" type="text" v-model="form.title" placeholder="Title" @focus="clearError('title')">
        </div>
        <div v-if="form.errors.title" class="mb-2 text-red-500">{{ form.errors.title }}</div>

        <!-- author -->
        <div class="form-group">
            <label for="writer_title">Author</label>
            <input id="writer_title" type="text" v-model="form.writer" placeholder="Author" @focus="clearError('writer')">
        </div>
        <div v-if="form.errors.writer" class="mb-2 text-red-500">{{ form.errors.writer }}</div>

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

<script>
import JetActionMessage from '@/Jetstream/ActionMessage'
import JetButton from '@/Jetstream/Button'

export default {
    name: 'AddBookAndWriter',
    props: ['genres'],
    components: {
        JetActionMessage,
        JetButton,
    },
    data() {
        return {
            form: this.$inertia.form({
                title: '',
                writer: '',
                genre_id: null,
                owned: false,
                completed: false,
            }),
        }
    },
    methods: {
        storeBookAndWriter() {
            this.form
            .transform(data => ({
                ...data,
            }))
            .post('/book-and-writer', {
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
}
</script>

<style scoped lang="less">
@purple: #7b1fa2;

form {
    margin-top: 25px;
    margin-bottom: 25px;
    padding: 15px;
    background: #eee;

    h2 {
        color: @purple;
        text-align: center;
        margin: 10px;
        font-size: 20px;
    }

    .form-group.book-checkbox {
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
    }
}

@media (min-width: 767px) {
    form {
        padding: 15px 300px 15px 260px;
    }
}
</style>