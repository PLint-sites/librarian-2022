<template>
    <div class="book" :class="bookOwnedCompletedClass" @click="showEditBookModal = true">
        <div class="title">
            <h3>{{ book.title }}</h3>
        </div>
        <div class="info">
            {{ book.writer.name }}
            <br>
            {{ book.genre.name }}
            <br>
            <span class="created">Added {{ book.start_reading_date}}</span>
        </div>

        <EditBookModal :show-edit-book-modal="showEditBookModal" :book="book" :writers="writers" :genres="genres" @modal-closed="showEditBookModal = false"/>
    </div>
</template>

<script>
import EditBookModal from './EditBookModal'

export default {
    name: 'Book',
    components: { 
        EditBookModal, 
    },
    props: ['book', 'writers', 'genres'],
    data() {
        return {
            showEditBookModal: false,
        }
    },
    computed: {
        bookOwnedCompletedClass() {
            // let bookClass
            return `${this.book.owned ? 'owned' : ''} ${this.book.completed ? 'completed' : ''}`
        },
    },
}
</script>

<style lang="less" scoped>
@green: #4caf50;
@orange: #ff9800;

.book {
    position: absolute;
    opacity: 0.6;
    box-sizing: border-box;
    background: @orange;
    color: rgba(0,0,0,.54);
    padding: 10px 15px;
    border-radius: 4px;
    box-shadow: 0 3px 1px -2px rgb(0 0 0 / 20%), 0 2px 2px 0 rgb(0 0 0 / 14%), 0 1px 5px 0 rgb(0 0 0 / 12%);

    &.owned {
        background: @green;
    }

    &.completed {
        opacity: 1;        
    }

    .title {
        display: grid;
        grid-template-columns: auto 32px 32px;
        grid-column-gap: 8px;
        font-size: .875rem;
        line-height: 1.375rem;

        h3 {
            align-self: center;
            text-transform: uppercase;
        }
    }

    .info {
        font-size: .8rem;
        line-height: 1.15rem;

        .created {
            color: #616161;
        }
    }
}
</style>