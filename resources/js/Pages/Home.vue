<template>
    <home-layout>
        <div id="page-content">
            <div id="home-img">
                <img :src="imgSmall"
                    :srcset="`${imgSmall} 350w,
                            ${imgLarge} 600w`"
                    sizes="(max-width: 420px) 350px,
                        600px"
                    alt="Wall of books"
                >
            </div>

            <div id="home-content">
                <h2 class="title">Your books in your pocket</h2>
                <p>
                    <i>
                        Looking through books in a bookshop? But don't remember if you read them already?
                    </i>
                </p>

                <p>
                    With Librarian you have all your books in your pocket! Simply add the books you own, mark the ones read or on loan.
                </p>

                <p>
                    Moreover, you keep an eye on your reading history. May come in handy one day!
                </p>

                <h2 class="title">Start now</h2>

                <p>
                    Register by clicking the button below. It's <b>free</b>. Already have an account? <a :href="route('login')">Sign in</a> 
                </p>

                <a class="btn" :href="route('register')"><i class="fas fa-user-plus"></i> Register</a>
            </div>
        </div>
    </home-layout>
</template>

<script>
import HomeLayout from '@/Layouts/HomeLayout'

export default {
    components: { HomeLayout },
    name: 'Home',
    props: {
        canLogin: Boolean,
        canRegister: Boolean,
    },
    data() {
        return {
            imgSmall: '/images/home-350px.jpg',
            imgLarge: '/images/home-600px.jpg',
        }
    },
}
</script>

<style scoped lang="less">
#page-content {
    margin: 15px;
    box-sizing: border-box;
    border: 1px solid #ddd;
    border-radius: 4px;
    box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 13px;

    #home-content {
        padding: 0 15px 15px 15px;
    }

    p {
        margin-bottom: 15px;
    }
}
</style>
