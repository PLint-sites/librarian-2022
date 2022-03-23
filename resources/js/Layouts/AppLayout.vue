<template>
    <div>
        <div class="min-h-screen">
            <nav class="border-b border-gray-100">
                <!-- Primary Navigation Menu -->
                <div class="navbar mx-auto">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="flex-shrink-0 flex items-center">
                                <inertia-link id="brand" :href="route('books')">
                                    Librarian
                                </inertia-link>
                            </div>

                            <!-- Navigation Links -->
                            <div v-if="$page.props.user" class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                                <jet-nav-link :href="route('books')" :active="route().current('books')">
                                    <i class="fas fa-book"></i> Books
                                </jet-nav-link>
                                <jet-nav-link :href="route('writers')" :active="route().current('writers')">
                                    <i class="fas fa-pencil-alt"></i> Writers
                                </jet-nav-link>
                            </div>
                        </div>

                        <div v-if="$page.props.user" class="hidden sm:flex sm:items-center sm:ml-6">
                            <!-- Settings Dropdown -->
                            <div class="ml-3 relative">
                                <jet-dropdown align="right" width="48">
                                    <template #trigger>
                                        <button v-if="$page.props.jetstream.managesProfilePhotos" class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition duration-150 ease-in-out">
                                            <img class="h-8 w-8 rounded-full object-cover" :src="$page.props.user.profile_photo_url" :alt="$page.props.user.name" />
                                        </button>

                                        <span v-else class="inline-flex">
                                            <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                                {{ $page.props.user.name }}

                                                <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <jet-dropdown-link :href="route('profile.show')">
                                            <i class="fas fa-user"></i> Profile
                                        </jet-dropdown-link>

                                        <div>
                                            <jet-nav-link id="logout-link" :href="route('logout')" method="post" class="uppercase block w-full px-4 py-2 text-sm leading-5 text-gray-700 text-left hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
                                                <i class="fas fa-sign-out-alt"></i> Log out
                                            </jet-nav-link>
                                        </div>
                                    </template>
                                </jet-dropdown>
                            </div>
                        </div>

                        <!-- Hamburger -->
                        <div class="-mr-2 flex items-center sm:hidden">
                            <button @click="showingNavigationDropdown = ! showingNavigationDropdown" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                                <svg class="h-6 w-6" stroke="#ffeb3b" fill="#ffeb3b" viewBox="0 0 24 24">
                                    <path :class="{'hidden': showingNavigationDropdown, 'inline-flex': ! showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                    <path :class="{'hidden': ! showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div id="mobile-menu" :class="{'block': showingNavigationDropdown, 'hidden': ! showingNavigationDropdown}" class="sm:hidden">
                    <div v-if="$page.props.user" class="">
                        <jet-responsive-nav-link :href="route('books')" :active="route().current('books')">
                            <i class="fas fa-book"></i> Books
                        </jet-responsive-nav-link>

                        <jet-responsive-nav-link :href="route('writers')" :active="route().current('writers')">
                            <i class="fas fa-pencil-alt"></i> Writers
                        </jet-responsive-nav-link>

                        <jet-responsive-nav-link :href="route('profile.show')" :active="route().current('profile.show')">
                            <i class="fas fa-user"></i> Profile
                        </jet-responsive-nav-link>

                        <!-- For some reason, jet-responsive-nav-link does not work as button, use a inertia Link directly with classes copied from jet-responsive-nav-link -->
                        <Link :href="route('logout')" method="post" as="button" type="button" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300 transition">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </Link>

                    </div>
                </div>
            </nav>

            
            <div id="main-content">
                <!-- Page Heading -->
                <header v-if="$slots.header">
                    <div>
                        <slot name="header"></slot>
                    </div>
                </header>

                <!-- Page Content -->
                <main id="app-main">
                    <slot></slot>
                </main>
            </div>

            <!-- Footer -->
            <footer>
                <div>
                    <slot name="footer">
				        © 2013-{{ (new Date()).getFullYear() }}	LIBRARIAN - <i>een idee van <a href="https://ww.plint-sites.nl" target="_blank" title="PLint-sites maatwerk websites, webshops en webapplicaties">PLint-sites</a></i>		
                    </slot>
                </div>
            </footer>
        </div>
    </div>
</template>

<script>
import JetDropdown from '@/Jetstream/Dropdown'
import JetDropdownLink from '@/Jetstream/DropdownLink'
import JetNavLink from '@/Jetstream/NavLink'
import JetResponsiveNavLink from '@/Jetstream/ResponsiveNavLink'

import { Link } from '@inertiajs/inertia-vue3';

export default {
    components: {
        JetDropdown,
        JetDropdownLink,
        JetNavLink,
        JetResponsiveNavLink,
        Link,
    },
    data() {
        return {
            showingNavigationDropdown: false,
        }
    },
    methods: {
        switchToTeam(team) {
            this.$inertia.put(route('current-team.update'), {
                'team_id': team.id
            }, {
                preserveState: false
            })
        },

        logout() {
            this.$inertia.post(route('logout'));
        },
    }
}
</script>

<style lang="less">
@purple: #7b1fa2;
@yellow: #ffeb3b;

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

.icon-button-lg {
    width: 60px;
    height: 60px;
}

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

nav {
    background: @purple;
    color: white;

    .navbar {
        width: 100%;
        max-width: 1200px;
        padding: 0 15px;
    }

    #brand {
        text-transform: uppercase;
        font-size: 1.25rem;
        color: yellow;
        font-weight: bold;
    }

    a, button {
        i {
            margin-right: 5px;
        }
    }

    a {
        text-transform: uppercase;
        color: yellow;
        border-color: yellow;
    }

    #logout-link {
        padding: 0.5rem 1rem;
        color: rgb(55 65 81 / var(--tw-text-opacity));
    }

    #mobile-menu {
        background: white;
        box-shadow: 3px 3px 20px @purple;

        a {
            text-transform: capitalize;
        }
    }
}

header > div {
    padding: 15px 0.9rem;
}

main#app-main, header {
    width: 100%;
    max-width: 1200px;
    margin-left: auto;
    margin-right: auto;
}

#main-content {
    min-height: calc(100vh - 100px);
}

footer {
    background: @yellow;
    color: @purple;
    text-align: center;
    padding: 8px 0;
    font-size: 13px;

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
        grid-template-rows: 42px 42px;
        align-items: center;
        margin-bottom: 5px;
        height: 84px;
    }

@media (max-width: 767px) {
    .icon-button-lg {
        width: 42px;
        height: 42px;
    }
}

@media (min-width: 768px) {
    .form-group {
        display: grid;
        grid-gap: 15px;
        grid-template-columns: 100px 1fr;
        align-items: center;
        margin-bottom: 15px;
        height: 42px;
    }

    footer {
        font-size: 14px;
    }
}
</style>