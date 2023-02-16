<template>
    <div id="page-title" class="desktop">
        <h1 class="font-semibold text-xl text-gray-800 leading-tight">
            Your books ({{ booksCount }})
        </h1>

        <div v-if="hasBooks" class="button-and-search">
            <button class="icon-button" type="button" @click="showModal">
                <i class="fas fa-plus"></i>
            </button>

            <button class="icon-button" type="button" @click="showBookShelf">
                <i class="fas fa-book-open"></i>
            </button>
            
            <input type="text" placeholder="Search book..." @keyup="debounceSearch" v-model="search">
            <button class="icon-button" type="button" @click="resetSearch">
                <i class="fas fa-times-circle"></i>
            </button>
        </div>
    </div>
</template>

<script>
export default {
    name: 'BookHeaderDesktop',
    props: ['booksCount', 'hasBooks'],
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
        showBookShelf() {
            this.$emit('show-bookshelf')
        },
    },
}
</script>

<style lang="less" scoped>
@purple: #7b1fa2;

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