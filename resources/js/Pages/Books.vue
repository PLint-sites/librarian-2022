<template>
    <app-layout>
        <template #header>
            <BookHeaderMobile 
                v-if="smartphoneSize" 
                :booksCount="numberOfBooks"
                :has-books="userHasBooks"
                @filter-books="filterBooks" 
                @reset-filter="resetFilter"
                @show-modal="showAddBookModal = true"
            />
            <BookHeaderDesktop 
                v-else 
                :booksCount="numberOfBooks"
                :has-books="userHasBooks" 
                @filter-books="filterBooks" 
                @reset-filter="resetFilter"
                @show-modal="showAddBookModal = true"
            />
        </template>

        <NoSearchResult v-if="isSearching && !hasSearchResults" :search="search" />

        <div id="booklist">
            <Book v-for="book in bookList" :key="book.id" :book="book" :writers="writers" :genres="genres"/>
        </div>

        <NoBookYet v-if="!isSearching && isBooklistEmpty" @show-modal="showAddBookModal = true"/>

        <AddBookModal :show-add-book-modal="showAddBookModal" :writers="writers" :genres="genres" @modal-closed="showAddBookModal = false"/>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'
import Book from '@/Components/Books/Book'
import NoBookYet from '@/Components/Books/NoBookYet'
import NoSearchResult from '@/Components/Books/NoSearchResult'
import AddBookModal from '@/Components/Books/AddBookModal'
import BookHeaderMobile from '@/Components/Books/BookHeaderMobile'
import BookHeaderDesktop from '@/Components/Books/BookHeaderDesktop'

import MiniMasonry from 'minimasonry'

export default {
    components: {
        AppLayout,
        Book,
        NoBookYet,
        NoSearchResult,
        AddBookModal,
        BookHeaderMobile,
        BookHeaderDesktop
    },
    props: ['books', 'booksCount', 'writers', 'genres', 'perPage'],
    data() {
        return {
            observer: null,
            isObserving: false,
            showAddBookModal: false,
            bookList: this.books,
            numberOfBooks: this.booksCount,
            page: 1,
            smartphoneSize: null,
            desktopSize: null,
            search: '',
            isSearching: false,
            hasSearchResults: false,
            masonry: null,
        }
    },
    computed: {
        userHasBooks() {
            return this.booksCount > 0
        },
        isBooklistEmpty() {
            return this.bookList.length === 0
        },
    },
    methods: {
        filterBooks({search}) {
            this.isSearching = true
            this.search = search

            // clear pagination
            this.page = 0
            this.bookList = []

            // call API
            this.loadMoreBooks()
        },
        resetFilter() {
            this.search = ''
            this.page = 0
            this.bookList = []

            this.loadMoreBooks()
            .then(() => {
                this.isSearching = false
                this.hasSearchResults = false

                if (!this.isObserving) {
                    this.observer.observe(document.querySelector('footer'))
                    this.isObserving = true
                }
            })
        },
        async loadMoreBooks() {
            const {data: {books, booksCount}} = await axios.get(`/books/draw/${this.page}/${this.search}`)

            if (this.search.length > 0) {
                // er is gezocht
                this.hasSearchResults = booksCount > 0
            } 
            
            if (booksCount > 0 && books.length) {
                this.numberOfBooks = booksCount
                this.bookList.push(...books)

                this.redrawMasonry()

                this.page += 1
                return books.length !== this.perPage
            } 
            return true
        },
        initMasonry() {
            this.masonry = new MiniMasonry({
                container: '#booklist',
                baseWidth: 150,
                minify: false,
                gutter: this.smartphoneSize ? 5 : 20,
                wedge: true,
            }); 
        },
        redrawMasonry() {
            this.$nextTick(() => {
                this.masonry.layout()
            })
        },
    },
    watch: {
        books(list) {
            this.bookList = list

            this.redrawMasonry()
        },
        booksCount(amount) {
            this.numberOfBooks = amount
        }
    },
    mounted() {
        // Setup Intersection observer API for lazy loading more books on scroll
        this.observer = new IntersectionObserver(
            (entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        // not when search is applied
                        if (!this.isSearching) {
                            this.loadMoreBooks()
                            .then(shouldUnobserve => {
                                this.redrawMasonry()
                                if (shouldUnobserve) {
                                    observer.unobserve(entry.target)
                                    this.isObserving = false
                                }
                            })
                            .catch(err => console.log(err))
                        }
                    }
                });
            },
            { 
                threshold: [0.5],
            }
        );

        this.observer.observe(document.querySelector('footer'))
        this.isObserving = true

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

        // Setup MiniMasonry
        this.initMasonry()
    },
    updated() {
        // when a book is removed in the edit book modal, the /books endpoint is called again
        // and this page is rerendered and we need to relayout masonry.
        this.redrawMasonry()
    },
}
</script>

<style scoped lang="less">
#booklist {
    position: relative;
    max-width: 1200px;
    margin-bottom: 10px;
}
</style>