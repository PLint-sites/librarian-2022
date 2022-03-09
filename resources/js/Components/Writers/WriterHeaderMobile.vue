<template>
    <div id="page-title" class="mobile" :class="hasWriters ? 'has-writers' : 'no-writers'">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Your writers
        </h2>

        <div v-if="hasWriters">
            <button class="icon-button" type="button" @click="$emit('show-modal')">
                <i class="fas fa-plus"></i>
            </button>
            <button class="icon-button" type="button" @click="showSearch">
                <i class="fas fa-search"></i>
            </button>
            <button class="icon-button" type="button" :disabled="sortingType === 'sortAZ'" @click="$emit('sort-az')">
                <i class="fas fa-sort-alpha-down"></i>
            </button>
            <button class="icon-button" type="button" :disabled="sortingType === 'sortZA'" @click="$emit('sort-za')">
                <i class="fas fa-sort-alpha-up"></i>
            </button>
            <button class="icon-button" type="button" :disabled="sortingType === 'lastCreated'" @click="$emit('sort-date')">
                <i class="fas fa-sort-amount-down"></i>
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
    name: 'WriterHeaderMobile',
    props: ['sortingType', 'hasWriters'],
    data() {
        return {
            showSearchInput: false,
            search: '',
            debounce: null,
        }
    },
    emits: ['show-modal', 'sort-az', 'sort-za', 'sort-date', 'filter-writers', 'reset-filter'],
    methods: {
        debounceSearch(event) {
            if (this.debounce) clearTimeout(this.debounce)

            this.debounce = setTimeout(() => {
                if (this.search.length > 2) {
                    this.$emit('filter-writers', {search: this.search})
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
    },
}
</script>

<style lang="less" scoped>
@purple: #7b1fa2;

#page-title {
    &.no-writers {
        grid-template-columns: 1fr;
    }

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