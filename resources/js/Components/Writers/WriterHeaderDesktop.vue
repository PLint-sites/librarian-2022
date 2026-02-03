<template>
    <div id="page-title" class="desktop">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Your authors
        </h2>

        <div v-if="hasWriters" id="buttons-and-search">
            <button class="icon-button" type="button" @click="$emit('show-modal')">
                <i class="fas fa-plus"></i>
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

            <div id="search-container">
                <input type="text" placeholder="Search author..." @keyup="debounceSearch" v-model="search" ref="searchInput">
                <button class="icon-button" type="button" @click="resetSearch">
                    <i class="fas fa-times-circle"></i>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'WriterHeaderDesktop',
    props: ['sortingType', 'hasWriters'],
    emits: ['show-modal', 'sort-az', 'sort-za', 'sort-date', 'filter-writers', 'reset-filter'],
    data() {
        return {
            search: '',
            debounce: null,
        }
    },
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
            this.$refs.searchInput.focus()
            this.$emit('reset-filter')
        },
    },
}
</script>

<style lang="less" scoped>
@purple: #7b1fa2;

#page-title {
    grid-template-columns: 200px 1fr;
    align-items: center;

    #buttons-and-search {
        display: grid;
        grid-template-columns: 40px 40px 40px 40px 1fr;
        align-items: center;

        #search-container {
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
}
</style>