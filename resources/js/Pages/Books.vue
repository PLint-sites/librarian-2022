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

        <div v-if="hasBooksToShow" id="booklist">
            <Book v-for="book in bookList" :key="book.id" :book="book" :writers="writers" :genres="genres"/>
        </div>

        <NoSearchResult :search="search" v-else-if="listIsFiltered"/>

        <NoBookYet v-else @show-modal="showAddBookModal = true"/>

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
            showAddBookModal: false,
            bookList: this.books,
            numberOfBooks: this.booksCount,
            page: 1,
            smartphoneSize: null,
            desktopSize: null,
            search: '',
            isSearching: false,
            masonry: null,
        }
    },
    computed: {
        userHasBooks() {
            return this.booksCount > 0
        },
        hasBooksToShow() {
            return this.bookList.length > 0
        },
        listIsFiltered() {
            return this.search.length > 0
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
            .then(() => this.isSearching = false)
        },
        resetFilter() {
            this.search = ''
            this.page = 0
            this.bookList = []
            this.loadMoreBooks()
        },
        async loadMoreBooks() {
            const {data: {books, booksCount}} = await axios.get(`/books/draw/${this.page}/${this.search}`)
            
            // if (books.length) {
            if (booksCount > 0 && books.length) {
                this.numberOfBooks = booksCount
                this.bookList.push(...books)
                this.page += 1
                return books.length !== this.perPage
            } 
            return true
        },
    },
    watch: {
        books(list) {
            this.bookList = list
        },
        booksCount(amount) {
            this.numberOfBooks = amount
        }
    },
    mounted() {
        // Setup Intersection observer API for lazy loading more books on scroll
        let observer = new IntersectionObserver(
            (entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        // not when search is applied
                        if (!this.isSearching) {
                            this.loadMoreBooks()
                            .then(shouldUnobserve => {
                                this.masonry.layout()
                                if (shouldUnobserve) observer.unobserve(entry.target)
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

        observer.observe(document.querySelector('footer'))

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
        this.masonry = new MiniMasonry({
            container: '#booklist',
            baseWidth: 150,
            minify: false,
            gutter: this.smartphoneSize ? 5 : 20,
        }); 
    },
    updated() {
        // when a book is removed in the edit book modal, the /books endpoint is called again
        // and this page is rerendered and we need to relayout masonry.
        this.masonry.layout()
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