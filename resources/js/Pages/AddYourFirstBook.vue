<template>
    <app-layout>
        <div id="intro">
            <div class="left-panel">
                <img src="/images/onboarding/reading-woman.jpg" alt="Woman reading book">
                <span>
                    Photo by <a href="https://unsplash.com/@kate_gliz">Kate Hliznitsova</a>
                </span>
            </div>

            <div id="welcome-heading">
                <h2>Welcome!</h2>
                <p class="subtitle">I am your personal librarian</p>
            </div>

            <div id="welcome-text" ref="welcomeText">
                <p>There is nothing for me to do without books. Hurry, fill out the form below, add me a book and make me work!</p>
            </div>
        </div>

        <div id="form-container">
            <AddBookAndWriter :genres="genres"/>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'
import AddBookAndWriter from '@/Components/Books/AddBookAndWriter'

export default {
    props: ['genres'],
    components: {
        AppLayout,
        AddBookAndWriter,
    },
    data() {
        return {
            highlightInterval: null,
        }
    },
    methods: {
        stopHighlight() {
            clearInterval(this.highlightInterval)
        }
    },
    mounted() {
        this.highlightInterval = setInterval(() => {
            this.$refs.welcomeText.classList.toggle('highlight')
        }, 2000)

        setTimeout(this.stopHighlight, 12000)
    },
    unmounted() {
        this.stopHighlight()
    },
}
</script>

<style scoped lang="less">
@purple: #7b1fa2;
@yellow: #ffeb3b;

#intro {
    padding: 15px;
    width: 100%;
    display: grid;
    grid-gap: 20px;
    
    grid-template-areas: "image head"
                         "body body";
    grid-template-columns: 1fr 1fr;
    grid-template-rows: 1fr 72px;

    .left-panel {
        grid-area: image;
        span {
            font-size: 12px;
            line-height: 15px;
            display: inline-block;
            margin-top: 5px;
        }
    }

    #welcome-heading {
        grid-area: head;
        h2 {
            color: @purple;
            margin-top: 24px;
            margin-bottom: 16px;
            font-size: 24px;
        }
        
        .subtitle {
            font-style: italic;
        }
    }
    
    #welcome-text {
        grid-area: body;

        &.highlight {
            transition: all 2s ease;
            color: @purple;
            font-style: italic;
        }
    }
}

@media (min-width: 767px) {
    #intro {
        padding-top: 45px;
        grid-template-areas: "image head"
                             "image body";
        grid-template-columns: 1fr 1fr;
        grid-template-rows: 1fr;

        .left-panel {
            display: grid;
            place-items: center;

            img {
                max-width: 400px;
                border-radius: 50%;
            }
        }

        #welcome-heading {
            align-self: center;
            height: 150px;
            h2 {
                font-size: 36px;
                text-align: center;
            }

            .subtitle {
                text-align: center;
                font-size: 20px;
                font-style: none;
            }
        }

        #welcome-text {
            grid-row-start: 1;
            grid-row-end: 2;
            align-self: end;
            
            padding: 25px;
            background: #eee;
            color: @purple;
            font-weight: bold;
            font-style: italic;

            &.highlight {
                transition: all 2s ease;
                background: @purple;
                color: #eee;
            }
        }
    }

    #form-container {
        padding-left: 15px;
        padding-right: 15px;
    }
}
</style>