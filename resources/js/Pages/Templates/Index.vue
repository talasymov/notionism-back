<template>
    <Head title="Templates"/>

    <GuestLayout>
        <div class="md:flex justify-between px-4 mx-auto max-w-8xl mt-12 relative">
            <div class="hidden md:block md:w-1/4 pr-14">
                <div class="md:sticky top-5">
                    <div v-for="category in categories">
                        <h4 class="text-xl">{{ category.name }}</h4>
                        <ul class="my-4">
                            <li v-for="tag in tags[category.id]">
                                <Link :href="`/${tag.slug}`">
                                    <div class="w-full flex flex-nowrap justify-between items-center">
                                        <span class="w-5/6 truncate text-ellipsis">{{ tag.icon }} {{ tag.name }}</span>
                                        <span class="w-1/6 text-right font-light text-gray-400">{{ tag.templates_count }}</span>
                                    </div>
                                </Link>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="w-full">
                <div class="w-full flex flex-nowrap mb-10 items-center" v-if="tag && tag.name">
                    <span class="text-6xl md:text-9xl">{{ tag.icon }}</span>
                    <h1 class="pl-2 text-xl md:text-5xl font-bold">{{ tag.name }}</h1>
                </div>
                <div class="w-full flex flex-nowrap mb-10 items-center" v-else>
                    <span class="text-6xl md:text-9xl">🖼️</span>
                    <h1 class="pl-2 text-xl md:text-5xl font-bold">Notion<br>Templates Gallery</h1>
                </div>
                <div class="w-full grid md:gap-4 md:grid-cols-2 lg:grid-cols-3">
                    <ul v-for="template in templates_items">
                        <li class="rounded-lg border border-gray-200 lg:w-60 overflow-hidden mb-10">
                            <Link :href="'/template/' + template.slug"
                                  class="text-gray-700 dark:text-gray-500">
                                <img :src="template.preview" alt="" class="w-full h-52 md:h-32">
                                <div class="p-3">
                                    <h3 class="line-clamp-2 h-14">{{ template.title }}</h3>
                                    <div class="flex justify-between items-center">
                                        <span class="font-bold">Free</span>
                                        <div class="flex flex-nowrap items-center text-rose-600 text-sm">
                                            <svg xmlns="https://www.w3.org/2000/svg" class="h-4 w-4 text-rose-600 mr-1" viewBox="0 0 512 512"><title>Heart</title><path d="M352.92 80C288 80 256 144 256 144s-32-64-96.92-64c-52.76 0-94.54 44.14-95.08 96.81-1.1 109.33 86.73 187.08 183 252.42a16 16 0 0018 0c96.26-65.34 184.09-143.09 183-252.42-.54-52.67-42.32-96.81-95.08-96.81z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"/></svg>
                                            {{ template.likes }}
                                        </div>
                                    </div>
                                </div>
                            </Link>
                        </li>
                    </ul>
                    <span ref="loadMoreIntersect" class="mb-32"/>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>

<script setup>
import {Head, Link} from '@inertiajs/inertia-vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';

defineProps(['templates', 'tags', 'categories', 'tag'])
</script>

<script>
export default {
    name: "TemplateIndex",
    mounted() {
        const observer = new IntersectionObserver(entries => entries.forEach(entry => entry.isIntersecting && this.loadMore(), {
            rootMargin: "-150px 0px 0px 0px"
        }));

        observer.observe(this.$refs.loadMoreIntersect)
    },
    data() {
        return {
            templates_items: this.templates.data,
            initial_url: this.$page.url,
        }
    },
    methods: {
        loadMore() {
            if (this.templates.next_page_url === null) {
                return
            }

            this.$inertia.get(this.templates.next_page_url, {}, {
                preserveState: true,
                preserveScroll: true,
                only: ['templates'],
                onSuccess: () => {
                    this.templates_items = [...this.templates_items, ...this.templates.data]
                }
            })
        }
    }
}
</script>
