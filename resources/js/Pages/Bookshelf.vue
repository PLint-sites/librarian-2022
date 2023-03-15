<template>
    <app-layout>
        <template #header>
            <h1 class="font-semibold text-xl text-gray-800 leading-tight">
                Your bookshelf ({{ books.length }})
            </h1>
        </template>

        <div id="booklist">
            <Book v-for="book in books" :key="book.id" :book="book" :writers="writers" :genres="genres" />
        </div>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'
import Book from '@/Components/Books/Book'
import BookHeaderMobile from '@/Components/Books/BookHeaderMobile'
import BookHeaderDesktop from '@/Components/Books/BookHeaderDesktop'
import MiniMasonry from 'minimasonry'

export default {
    components: {
        AppLayout,
        Book,
        BookHeaderMobile,
        BookHeaderDesktop
    },
    props: ['books', 'writers', 'genres'],
    data() {
        return {
            smartphoneSize: null,
            desktopSize: null,
            masonry: null
        }
    },
    methods: {
        initMasonry() {
            this.masonry = new MiniMasonry({
                container: '#booklist',
                baseWidth: 150,
                minify: false,
                gutter: this.smartphoneSize ? 5 : 20,
                wedge: true,
            });
        },
    },
    mounted() {
        this.initMasonry()

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