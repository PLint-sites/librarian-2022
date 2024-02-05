<template>
    <div>
        <div id="auth-page" class="min-h-screen">
            <nav class="border-b border-gray-100">
                <div class="navbar mx-auto">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <div class="flex-shrink-0 flex items-center">
                                <Link id="brand" href="#">
                                    Librarian
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
            
            <main id="auth-main">
                <slot></slot>
            </main>
        </div>
    </div>
</template>

<script>
import { Link } from '@inertiajs/vue3';
export default {
    components: {Link}
}
</script>

<style lang="less">
@purple: #7b1fa2;
@yellow: #ffeb3b;

h2, h3, h4, h5 {
    font-weight: bold;
}

[type="checkbox"]:checked:hover, [type="checkbox"]:checked:focus, [type="radio"]:checked:hover, [type="radio"]:checked:focus {
    background-color: @purple;
}

[type="text"]:focus, [type="email"]:focus, [type="url"]:focus, [type="password"]:focus, [type="number"]:focus, [type="date"]:focus, [type="datetime-local"]:focus, [type="month"]:focus, [type="search"]:focus, [type="tel"]:focus, [type="time"]:focus, [type="week"]:focus, [multiple]:focus, textarea:focus, select:focus {
    border-color: @purple;
    border-width: 1px;
    box-shadow: none;
}

#auth-page {
    display: grid;
    grid-template-rows: 65px 1fr;
}

nav {
    background: @purple;
    color: white;

    .navbar {
        width: 100%;
        max-width: 1200px;
        padding: 0 25px;
    }

    #brand {
        text-transform: uppercase;
        font-size: 1.25rem;
        color: yellow;
        font-weight: bold;
    }

    a {
        text-transform: uppercase;
        color: yellow;
        border-color: yellow;

        i {
            margin-right: 5px;
        }
    }
}

main#auth-main {
    padding: 25px;
    
}

@media (min-width: 768px) {
    main#auth-main {
        padding-top: 100px;
        width: 600px;
        margin-left: auto;
        margin-right: auto;
    }
}
</style>