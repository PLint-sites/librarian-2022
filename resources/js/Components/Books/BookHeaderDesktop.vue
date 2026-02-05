<template>
    <div id="page-title" class="desktop">
        <div v-if="booksReadThisYear !== undefined" class="books-read-metric">
            📚 {{ booksReadThisYear }} {{ booksReadThisYear === 1 ? 'book' : 'books' }} read this year
        </div>

        <h1 class="font-semibold text-xl text-gray-800 leading-tight">
            Your books ({{ booksCount }})
        </h1>

        <div v-if="hasBooks" class="button-and-search">
            <button class="icon-button" type="button" @click="showModal">
                <i class="fas fa-plus"></i>
            </button>

            <Link class="icon-button" href="/bookshelf" as="button"><i class="fas fa-book-open"></i></Link>
            
            <input type="text" placeholder="Search book..." @keyup="debounceSearch" v-model="search">
            <button class="icon-button" type="button" @click="resetSearch">
                <i class="fas fa-times-circle"></i>
            </button>
        </div>
    </div>
</template>

<script>
import { Link } from '@inertiajs/vue3'

export default {
    name: 'BookHeaderDesktop',
    components: {
        Link,
    },
    props: ['booksCount', 'booksReadThisYear', 'hasBooks'],
    data() {
        return {
            search: '',
            debounce: null,
        }
    },
    emits: ['filter-books', 'reset-filter', 'show-modal'],
    methods: {
        debounceSearch(event) {
            if (this.debounce) clearTimeout(this.debounce)

            this.debounce = setTimeout(() => {
                if (this.search.length > 2) {
                    this.$emit('filter-books', {search: this.search})    
                }
            }, 1500)
        },
        resetSearch() {
            this.search = ''
            this.$emit('reset-filter')
        },
        showModal() {
            this.$emit('show-modal')
        },
    },
}
</script>

<style lang="less" scoped>
@purple: #7b1fa2;

.books-read-metric {
    grid-column-start: span 2;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 8px 16px;
    border-radius: 6px;
    font-size: 14px;
    text-align: center;
    margin-bottom: 10px;
    font-weight: 500;
}

#page-title {
    grid-template-columns: auto 320px;

    .button-and-search {
        position: relative;

        input[type="text"] ~ button {
            position: absolute;
            right: 9px;
            top: 9px;
            box-shadow: none;
            background: none;
            border: none;
            width: 23px;
            height: 23px;

            i {
                color: @purple;
            }
        }
    }
}
</style>