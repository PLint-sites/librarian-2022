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

export default {
    components: {
        AppLayout,
        Book,
        BookHeaderMobile,
        BookHeaderDesktop
    },
    props: ['books'],
}
</script>