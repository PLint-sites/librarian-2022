<template>
    <app-layout>
        <template #header>
            <WriterHeaderMobile
                v-if="smartphoneSize"
                :sorting-type="sortingType"
                :has-writers="userHasWriters"
                @filter-writers="filterWriters" 
                @reset-filter="resetFilter"
                @show-modal="showAddWriterModal = true"
                @sort-az="sortAZ"
                @sort-za="sortZA"
                @sort-date="sortDateAdded"
            />
            <WriterHeaderDesktop
                v-else
                :sorting-type="sortingType"
                :has-writers="userHasWriters"
                @filter-writers="filterWriters" 
                @reset-filter="resetFilter"
                @show-modal="showAddWriterModal = true"
                @sort-az="sortAZ"
                @sort-za="sortZA"
                @sort-date="sortDateAdded"
            />            
        </template>

        <div v-if="hasWritersToShow" id="writerlist">
            <Writer v-for="writer in writerList" :key="writer.id" :writer="writer" :genres="genres"/>
        </div>

        <NoSearchResult :search="search" v-else-if="listIsFiltered"/>

        <NoWriterYet v-else @show-modal="showAddWriterModal = true"/>

        <AddWriterModal :show-add-writer-modal="showAddWriterModal" @modal-closed="showAddWriterModal = false"/>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'
import WriterHeaderMobile from '@/Components/Writers/WriterHeaderMobile'
import WriterHeaderDesktop from '@/Components/Writers/WriterHeaderDesktop'
import AddWriterModal from '@/Components/Writers/AddWriterModal'
import Writer from '@/Components/Writers/Writer'
import NoWriterYet from '@/Components/Writers/NoWriterYet'
import NoSearchResult from '@/Components/Books/NoSearchResult'

export default {
    components: {
        AppLayout,
        WriterHeaderMobile,
        WriterHeaderDesktop,
        AddWriterModal,
        Writer,
        NoWriterYet,
        NoSearchResult,
    },
    props: ['writers', 'genres'],
    data() {
        return {
            showAddWriterModal: false,
            sortingType: 'lastCreated',
            writerList: this.writers,
            smartphoneSize: null,
            search: '',
            isSearching: false,
        }
    },
    computed: {
        userHasWriters() {
            return this.writers.length > 0
        },
        hasWritersToShow() {
            return this.writerList.length > 0
        },
        listIsFiltered() {
            return this.search.length > 0
        },
    },
    methods: {
        filterWriters({search}) {
            this.isSearching = true
            this.search = search

            // API call or just simple filter on writerList?
            this.writerList = this.writers.filter(writer => {
                const name = writer.name.toLowerCase()
                const searchTerm = search.toLowerCase()
                return name.includes(searchTerm)
            })
        },
        resetFilter() {
            this.writerList = this.writers
        },
        sortAZ() {
            this.sortingType = 'sortAZ'
            this.writerList.sort((writer1, writer2) => {
                if (writer1.name > writer2.name) {
                    return 1;
                } else if (writer1.name < writer2.name) {
                    return -1;
                }
                return 0;
            })
        },
        sortZA() {
            this.sortingType = 'sortZA'
            this.writerList.sort((writer1, writer2) => {
                if (writer1.name < writer2.name) {
                    return 1;
                } else if (writer1.name > writer2.name) {
                    return -1;
                }
                return 0;
            })
        },
        sortDateAdded() {
            this.sortingType = 'lastUpdated'
            this.writerList.sort((writer1, writer2) => {
                    if (writer1.updated_at < writer2.updated_at) {
                        return 1;
                    } else if (writer1.updated_at > writer2.updated_at) {
                        return -1;
                    }
                    return 0;
                })
        },
    },
    watch: {
        writers(list) {
            this.writerList = list
        }
    },
    mounted() {
        // MatchMedia 
        const mediaQuery = window.matchMedia('(max-width: 767px)')
        // Check if the media query is true
        if (mediaQuery.matches) {
            this.smartphoneSize = true
            this.desktopSize = false
        } else {
            this.smartphoneSize = false
            this.desktopSize = true
        }
    },
}
</script>

<style lang="less" scoped>
#writerlist {
    max-width: 1200px;
    display: grid;
    grid-gap: 20px;
    grid-template-columns: repeat(auto-fit, minmax(325px, 1fr));
    padding: 0px 15px 10px;
    margin-bottom:10px;
}
</style>