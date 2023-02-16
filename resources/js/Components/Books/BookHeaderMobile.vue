<template>
    <div id="page-title" class="mobile">
        <h1 class="font-semibold text-xl text-gray-800 leading-tight">
            Your books ({{ booksCount }})
        </h1>

        <div v-if="hasBooks" class="buttons">
            <button class="icon-button" type="button" @click="showModal">
                <i class="fas fa-plus"></i>
            </button>

            <button class="icon-button" type="button" @click="showBookShelf">
                <i class="fas fa-book-open"></i>
            </button>
            
            <button class="icon-button" type="button" @click="showSearch">
                <i class="fas fa-search"></i>
            </button>
        </div>

        <div id="search-field" v-show="showSearchInput">
            <input type="text" ref="searchInput" placeholder="Search book/writer..." @keyup="debounceSearch" v-model="search">
            <button class="icon-button" type="button" @click="resetSearch">
                <i class="fas fa-times-circle"></i>
            </button>
        </div>
    </div>
</template>

<script>
export default {
    name: 'BookHeaderMobile',
    props: ['booksCount', 'hasBooks'],
    data() {
        return {
            showSearchInput: false,
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
            this.showSearchInput = false
            this.$emit('reset-filter')
        },
        showSearch() {
            this.showSearchInput = true
            setTimeout(() => {
                this.$refs.searchInput.focus()
            }, 300)
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

.icon-button i.fas {
    pointer-events: none;
}

#page-title {
    grid-template-columns: auto 112px;

    #search-field {
        width: 100%;
        margin-top: 15px;
        grid-column-start: span 2;
        justify-self: start;
        position: relative;

        input {
            width: 100%;
        }

        button {
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