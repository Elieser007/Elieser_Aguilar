<template>
    <transition enter-active-class="transition ease-in-out duration-150" enter-from-class="opacity-0"
        enter-to-class="opacity-100" leave-active-class="transition ease-in-out duration-150"
        leave-from-class="opacity-100" leave-to-class="opacity-0">
        <div v-show="$page.props.showingMobileMenu"
            class="fixed inset-0 z-10 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center"></div>
    </transition>
    <transition enter-active-class="transition ease-in-out duration-150"
        enter-from-class="opacity-0 transform -translate-x-20" enter-to-class="opacity-100"
        leave-active-class="transition ease-in-out duration-150" leave-from-class="opacity-100"
        leave-to-class="opacity-0 transform -translate-x-20">
        <aside v-show="$page.props.showingMobileMenu"
            class="fixed inset-y-0 z-20 flex-shrink-0 w-64 mt-16 overflow-y-auto bg-purple-900 md:hidden">
            <div class="py-4 text-white">
                <Link class="ml-6 text-lg font-bold" :href="route('dashboard')">
                Library
                </Link>
                <ul class="mt-6">
                    <li class="relative px-6 py-3">
                        <ResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')">
                            <template #icon>
                                <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round"
                                    stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                    <path
                                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                    </path>
                                </svg>
                            </template>
                            Dashboard
                        </ResponsiveNavLink>
                    </li>

                    <li class="relative px-6 py-3">
                        <ResponsiveNavLink :href="route('users.index')" :active="route().current('users.index')">
                            <template #icon>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                    </path>
                                </svg>
                            </template>
                            Users
                        </ResponsiveNavLink>
                    </li>

                    <li class="relative px-6 py-3">
                        <ResponsiveNavLink :href="route('productos.index')"
                            :active="route().current('productos.index')">
                            <template #icon>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                </svg>
                            </template>
                            Productos
                        </ResponsiveNavLink>
                    </li>
                    <li class="relative px-6 py-3">
                        <ResponsiveNavLink :href="route('categorias.index')"
                            :active="route().current('categorias.index')">
                            <template #icon>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                </svg>
                            </template>
                            Categorías
                        </ResponsiveNavLink>
                    </li>
                </ul>
            </div>
        </aside>
    </transition>
</template>

<script setup>
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue'
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue'

let showingTwoLevelMenu = ref(false)
</script>
