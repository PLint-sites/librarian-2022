<template>
    <div class="writer">
        <div class="name">
            <div class="writer-and-books">
                <h3>{{ writer.name }} ({{ booksCount }})</h3>
                <ul v-if="booksCount > 0">
                    <li v-for="book in writer.books" :key="book.id">
                        {{ book.title }}
                        <i v-if="book.is_on_bookshelf" class="fas fa-book-open"></i>
                    </li>
                </ul>
            </div>

            <div class="buttons">
                <button v-if="writer.books.length === 0" class="icon-button" type="button" @click="showDeleteWriterModal = true" style="margin-right: 8px">
                    <i class="fas fa-trash"></i>
                </button>
                <button class="icon-button" type="button" @click="showEditWriterModal = true">
                    <i class="fas fa-pencil-alt"></i>
                </button>
            </div>
        </div>

        <EditWriterModal :show-edit-writer-modal="showEditWriterModal" :writer="writer" @modal-closed="showEditWriterModal = false"/>

        <DeleteWriterModal :show-delete-writer-modal="showDeleteWriterModal" :writer="writer" @delete-modal-closed="showDeleteWriterModal = false"/>
    </div>
</template>

<script>
import EditWriterModal from './EditWriterModal'
import DeleteWriterModal from './DeleteWriterModal'

export default {
    name: 'Writer',
    components: {EditWriterModal, DeleteWriterModal},
    props: ['writer'],
    data() {
        return {
            showEditWriterModal: false,
            showDeleteWriterModal: false,
        }
    },
    computed: {
        booksCount() {
            return this.writer.books.length
        }
    },
}
</script>

<style lang="less" scoped>
@lightyellow: #fff59d;
@darkyellow: #ffeb3b;
@purple: #7b1fa2;

.writer {
    box-sizing: border-box;
    background: @lightyellow;
    color: rgba(0,0,0,.54);
    padding: 10px 15px;
    border-radius: 4px;
    box-shadow: 0 3px 1px -2px rgb(0 0 0 / 20%), 0 2px 2px 0 rgb(0 0 0 / 14%), 0 1px 5px 0 rgb(0 0 0 / 12%);

    .name {
        display: grid;
        grid-template-columns: 1fr 72px;
        grid-column-gap: 8px;
        font-size: .875rem;
        line-height: 1.375rem;

        .writer-and-books {
            h3 {
                align-self: center;
                text-transform: uppercase;
                color: inherit;
            }

            ul {
                padding-left: 15px;
                list-style: disc;
            }
        }

        div.buttons {
            justify-self: end;
        }
    }

    button.icon-button {
        background: @darkyellow;
        border-color: @darkyellow;

        i.fas {
            color: @purple;
        }
    }
}
</style>