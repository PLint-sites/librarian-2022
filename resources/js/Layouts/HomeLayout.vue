<template>
    <div>
        <div id="home-layout">
            <nav>
                <div id="brand">Librarian</div>
                <a class="btn" :href="route('login')"><i class="fas fa-user"></i> Sign in</a>
            </nav>

            <!-- Page Heading -->
            <header v-if="$slots.header">
                <div>
                    <slot name="header"></slot>
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <slot></slot>
            </main>

            <!-- Page Heading -->
            <footer>
                <div>
                    <slot name="footer">
				        © 2020-{{ (new Date()).getFullYear() }}	LIBRARIAN
                        <br>
                        <i>concept by <a href="https://ww.plint-sites.nl" target="_blank" title="PLint-sites maatwerk websites, webshops en webapplicaties">PLint-sites</a></i>		
                        <br>
                        <p class="small">Photo by <a href="https://unsplash.com/@reneefisherandco">Renee Fisher</a> on Unsplash</p>
                    </slot>
                </div>
            </footer>
        </div>
    </div>
</template>

<script>
export default {
}
</script>

<style lang="less">
@purple: #7b1fa2;
@yellow: #ffeb3b;

body {
    background: #f3f4f7;
}

#home-layout {
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
    background: white;
}

.icon-button {
    width: 32px;
    height: 32px;
    background: @purple;
    border: 1px solid @purple;
    border-radius: 50%;
    box-shadow: 0 3px 5px -1px rgb(0 0 0 / 20%), 0 6px 10px 0 rgb(0 0 0 / 14%), 0 1px 18px 0 rgb(0 0 0 / 12%);

    .fas {
        color: white;
    }

    &:disabled {
        opacity: 0.6;
    }
}

h2, h3, h4, h5 {
    font-weight: bold;
    color: @purple;
}

h2 {
    font-size: 1.25rem;
    margin: 0.75rem 0;
}

a {
    color: @purple;
    font-weight: bold;
}

.btn {
    background: @yellow;
    color: @purple;
    text-transform: uppercase;
    padding: 4px 10px;
    font-size: .8rem;
    border-radius: 4px;

    i.fas {
        margin-right: 3px;
    }
}

p.small {
    font-size: 0.75rem;
}

nav {
    background: @purple;
    color: white;
    height: 4rem;

    display: grid;
    grid-template-columns: 1fr 1fr;
    align-items: center;
    padding: 0 15px;

    #brand {
        text-transform: uppercase;
        font-size: 1.25rem;
        color: yellow;
        font-weight: bold;
    }

    a {
        justify-self: end;
    }
}

header > div {
    padding: 15px 25px;
}

main, header {
    width: 100%;
    max-width: 1200px;
    margin-left: auto;
    margin-right: auto;
}

footer {
    background: @yellow;
    color: @purple;
    text-align: center;
    padding: 8px 0;
    line-height: 24px;

    a:hover {
        text-decoration: underline;
    }
}

#page-title {
    display: grid;
    grid-template-columns: auto 200px;
    grid-column-gap: 8px;

    div {
        justify-self: end;
        
        button {
            margin-right: 8px;

            &:last-child {
                margin-right: 0;
            }
        }
    }

    .icon-button i.fas {
        color: @yellow;
    }
}

.form-group {
    display: grid;
    grid-gap: 15px;
    grid-template-columns: 100px 1fr;
    align-items: center;
    margin-bottom: 15px;
    height: 42px;
}
</style>