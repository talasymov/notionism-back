<template>
    <Head :title="template.title"/>

    <GuestLayout>
        <div class="container flex flex-wrap px-3 md:flex-nowrap">
            <div class="w-full md:w-1/3 md:pr-14 md:pt-0 pt-10">
                <div class="w-full border border-gray-200 rounded-xl overflow-hidden">
                    <img :src="template.preview" alt="" class="w-full h-52">
                    <div class="w-full p-4">
                        <div class="w-full flex flex-nowrap justify-between">
                            <div>
                                <span class="font-bold text-2xl">{{ template.dbs }}</span><br>
                                <span class="font-light text-sm">Databases</span>
                            </div>
                            <div>
                                <span class="font-bold text-2xl">{{ template.props }}</span><br>
                                <span class="font-light text-sm">Properties</span>
                            </div>
                            <div>
                                <span class="font-bold text-2xl">{{ template.pages }}</span><br>
                                <span class="font-light text-sm">Pages</span>
                            </div>
                        </div>
                        <div class="my-4 w-full">
                            <span class="text-sm font-semibold text-gray-400">Perfect for</span>
                            <div class="flex flex-wrap w-full justify-between mt-2">

                                <div v-for="tag in tags" class="truncate text-ellipsis w-5/12 mb-1"
                                     :class="{'hidden' : tags.indexOf(tag) > 4 && !more}">
                                    <a :href="`/${tag.slug}`">
                                        {{ tag.icon }} {{ tag.name }}
                                    </a>
                                </div>
                                <button class="w-5/12 text-sm font-light text-left text-gray-500" @click="more=true"
                                        v-if="!more && tags.length > 5" v-html="`+${tags.length - 5} more`"></button>
                            </div>
                        </div>
                        <div class="w-full flex flex-nowrap justify-between items-center mt-4 pt-4 pb-2">
                            <div class="text-2xl font-semibold">
                                Free
                            </div>
                            <button class="bg-rose-600 text-white font-bold text-lg px-4 py-2 rounded-md"
                                    @click="copyToClipboard(template.link)">
                                View & copy
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-full md:w-2/3 md:order-last order-first">
                <h1 class="text-6xl font-bold">{{ template.title }}</h1>
                <div class="w-full flex flex-nowrap justify-between my-4">
                    <div class="flex flex-nowrap items-center">
                        by
                        <img class="w-5 h-5 mr-1 ml-2"
                             src="https://notionism.org/wp-content/uploads/2022/11/cropped-Untitled-1-01-1.png">
                        <a href="/" class="font-semibold underline decoration-gray-400">notionism</a>
                        <div class="flex flex-nowrap items-center text-rose-600 text-sm ml-5 cursor-pointer"
                             @click="like">
                            <svg xmlns="https://www.w3.org/2000/svg" class="h-4 w-4 text-rose-600 mr-1"
                                 viewBox="0 0 512 512"><title>Heart</title>
                                <path
                                    d="M352.92 80C288 80 256 144 256 144s-32-64-96.92-64c-52.76 0-94.54 44.14-95.08 96.81-1.1 109.33 86.73 187.08 183 252.42a16 16 0 0018 0c96.26-65.34 184.09-143.09 183-252.42-.54-52.67-42.32-96.81-95.08-96.81z"
                                    fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="32"></path>
                            </svg>
                            {{ template.likes }}
                        </div>
                    </div>
                    <div class="text-sm font-light text-gray-500">
                        {{ template.publishing_at }}, v{{ template.ver }}
                    </div>
                </div>
                <div v-html="template.content.html"></div>
            </div>
        </div>
    </GuestLayout>
</template>

<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';

defineProps(['template', 'tags'])


</script>

<script>
export default {
    data() {
        return {
            more: false
        }
    },
    methods: {
        like() {
            this.$inertia.post(`/template/${this.template.slug}/like`)
        },
        copyToClipboard(text_to_copy) {
            navigator.clipboard.writeText(text_to_copy);
        },
    }
}
</script>
