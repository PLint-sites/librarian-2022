<template>
    <div id="no-writers-block" class="px-5 mb-5">
        <div id="left-panel">
            <img src="/images/onboarding/reading-woman.jpg" alt="Woman reading book">
            <span>
                Photo by <a href="https://unsplash.com/@kate_gliz">Kate Hliznitsova</a> on <a href="https://unsplash.com/s/photos/reading-a-book">Unsplash</a>
            </span>
        </div>
        <div id="right-panel">
            <b>Who</b> 
            <br>
            are you reading?
            <br>
            <button class="icon-button icon-button-lg mt-2 sm:mt-5" type="button" @click="$emit('show-modal')">
                <i class="fas fa-plus"></i>
            </button>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'NoWriterYet',
    }
</script>

<style lang="less" scoped>
@purple: #7b1fa2;
@yellow: #ffeb3b;


#no-writers-block {
    display: grid;
    grid-template-columns: 1fr 1fr;
    grid-gap: 20px;

    #left-panel {
        img {
            border-radius: 50%;
        }

        span {
            font-size: 13px;
            display: block;
            text-align: center;
            margin-top: 5px;

            a {
                text-decoration: underline;
            }
        }
    }

    #right-panel {
        align-self: center;
        padding: 3rem;
        font-size: 36px;
        line-height: 50px;
        text-align: center;

        b {
            color: @purple;
            font-size: 42px;
        }
    }
}

@media (max-width: 767px) {
    #no-writers-block {
        grid-template-columns: 1fr;
        grid-template-rows: 145px 335px;
        grid-gap: 0;

        #left-panel img {
            border-radius: 0;
        }

        #right-panel {
            grid-row-start: 1;
            grid-row-end: 2;

            background: @yellow;
            padding: 1rem;
            font-size: 24px;
            line-height: 32px;

            b {
                font-size: 30px;
            }
        }
    }
}
</style>