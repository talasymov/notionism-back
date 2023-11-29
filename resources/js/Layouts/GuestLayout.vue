<script setup>
import {Link, usePage} from '@inertiajs/inertia-vue3';
import {computed, ref} from 'vue'
import CloseIcon from "@/Icons/CloseIcon.vue";

const shared_categories = computed(() => usePage().props.value.shared_categories)
const shared_tags = computed(() => usePage().props.value.shared_tags)

const showTags = ref(false)
const openMenu = ref(false)
</script>

<template>
    <header>
        <div class="container max-w-6xl mx-auto">
            <nav class="bg-white border-gray-200 px-2 sm:px-4 py-2.5 rounded dark:bg-gray-900">
                <div class="container flex flex-wrap items-center justify-between mx-auto">
                    <Link href="/" class="flex items-center">
                        <img src="https://notionism.org/wp-content/uploads/2022/10/icon-01.svg" class="h-6 mr-3 sm:h-9"
                             alt="Notionism" width="34" height="34">
                    </Link>
                    <button data-collapse-toggle="navbar-default" type="button" @click="openMenu = !openMenu"
                            class="inline-flex items-center p-2 ml-3 text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                            aria-controls="navbar-default" aria-expanded="false">
                        <span class="sr-only">Open main menu</span>
                        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                             xmlns="https://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                  d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                                  clip-rule="evenodd"></path>
                        </svg>
                    </button>
                    <div :class="{'hidden w-full md:block md:w-auto': !openMenu, 'w-full md:block md:w-auto': openMenu}" id="navbar-default">
                        <ul class="flex flex-col p-4 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:flex-row md:space-x-8 md:mt-0 md:text-sm md:font-medium md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
                            <li>
                                <Link href="/"
                                      class="block py-2 pl-3 pr-4 md:p-0 focus:text-rose-600 active:text-rose-600"
                                      aria-current="page">Homepage
                                </Link>
                            </li>
                            <li @click="showTags = true" class="cursor-pointer block py-2 pl-3 pr-4 md:p-0">Tags</li>
                            <li>
                                <Link href="/template-library"
                                      class="block py-2 pl-3 pr-4 md:p-0 focus:text-rose-600 active:text-rose-600">
                                    Template Library
                                </Link>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
        <Transition name="slide-fade">
            <div class="bg-white fixed shadow inset-0 z-40" v-show="showTags">
                <div
                    class="container max-w-6xl mx-auto fixed top-0 left-0 right-0 z-50 w-full p-4 overflow-x-hidden overflow-y-auto inset-0 h-modal h-full justify-center items-center flex">
                    <div class="w-full grid md:grid-cols-4">
                        <div v-for="shared_category in shared_categories">
                            <h4 class="text-xl">{{ shared_category.name }}</h4>
                            <ul class="my-4">
                                <li v-for="shared_tag in shared_tags[shared_category.id]">
                                    <Link :href="`/${shared_tag.slug}`">
                                        <div class="w-full flex flex-nowrap justify-between items-center">
                                            <span class="w-5/6 truncate text-ellipsis">
                                                {{ shared_tag.icon }} {{ shared_tag.name }}
                                            </span>
                                        </div>
                                    </Link>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <CloseIcon classes="w-10 fixed top-1 right-1 cursor-pointer" @click="showTags = false"/>
                </div>
            </div>
        </Transition>
    </header>
    <main class="overflow-hidden">
        <div class="container max-w-6xl mx-auto">
            <slot/>
        </div>
    </main>
    <footer class="py-10 bg-gray-50 border-t border-gray-200">
        <div class="container flex justify-between mx-auto items-center">
            <div>
                <svg class="w-12 h-12" xmlns="https://www.w3.org/2000/svg" viewBox="0 0 25 25"><path d="M17.62,16.67V13.53a7.91,7.91,0,0,0-.4-2.69,3.11,3.11,0,0,0-.82-1.17,2.12,2.12,0,0,0-1.33-.39,11.31,11.31,0,0,0-3.55,1.34c-.24.14-.36.28-.37.41v8a1.59,1.59,0,0,0,1.46,1.72h.1c.46.07.7.18.7.33s0,.24-.15.27H6.81a.2.2,0,0,1-.15-.22c0-.19.24-.31.7-.38a1.59,1.59,0,0,0,1.57-1.61.41.41,0,0,0,0-.11V10.51a.86.86,0,0,0-.67-.86,3.32,3.32,0,0,0-.62-.16L7.1,9.36a.71.71,0,0,1-.25-.11.3.3,0,0,1,0-.23c0-.12.07-.2.22-.28L10.8,7A.78.78,0,0,1,11,6.87c.16,0,.25.11.25.35V9.57c0,.1,0,.16.11.16A3.52,3.52,0,0,0,12,9.46c.84-.43,1.67-.83,2.49-1.26a5.14,5.14,0,0,1,2.1-.6q3.36,0,3.36,6.25l-.14,4.32V19a1.46,1.46,0,0,0,1.13,1.49,5,5,0,0,0,.92.24,2,2,0,0,1,.59.13.22.22,0,0,1,.13.23.18.18,0,0,1-.15.21h-7a.18.18,0,0,1-.15-.21c0-.19.22-.32.68-.38A1.64,1.64,0,0,0,17.5,19a.49.49,0,0,0,0-.12A15.17,15.17,0,0,0,17.62,16.67Z"/><path d="M4.72,2.24V11.5H2.66V2.24Z"/></svg>
                <span class="text-gray-500 mt-4">© 2022 notionism.org</span>
            </div>
            <div class="grid grid-cols-2 gap-12">
                <span>Contact us</span>
                <span>Templates</span>

            </div>
        </div>
    </footer>
</template>

<style>
/*
  Enter and leave animations can use different
  durations and timing functions.
*/
.slide-fade-enter-active {
    transition: all 0.3s ease-out;
}

.slide-fade-leave-active {
    transition: all 0.1s cubic-bezier(1, 0.5, 0.8, 1);
}

.slide-fade-enter-from,
.slide-fade-leave-to {
    transform: translateY(-200px) scale(0.5);
    opacity: 0;
}
</style>

