<template>
    <Head title="Edit template"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit template</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <section>
                        <form @submit.prevent="updateTemplate" class="mt-6 space-y-6">
                            <div class="flex items-center gap-4 sticky top-0 bg-white py-5">
                                <PrimaryButton :disabled="form.processing">Save</PrimaryButton>

                                <a :href="'/template/' + template.slug" target="_blank">
                                    <PrimaryButton type="button">Preview</PrimaryButton>
                                </a>

                                <Transition enter-from-class="opacity-0" leave-to-class="opacity-0"
                                            class="transition ease-in-out">
                                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Saved.</p>
                                </Transition>
                            </div>

                            <div>
                                <InputLabel for="title" value="Title"/>

                                <TextInput
                                    id="title"
                                    ref="titleInput"
                                    v-model="form.title"
                                    type="text"
                                    class="mt-1 block w-full"
                                />

                                <InputError :message="form.errors.title" class="mt-2"/>
                            </div>

                            <div>
                                <InputLabel for="preview" value="Preview"/>

                                <img :src="form.preview" class="w-24">

                                <input id="preview_file" type="file"
                                       @input="form.preview_file = $event.target.files[0]"/>

                                <InputError :message="form.errors.preview_file" class="mt-2"/>
                            </div>

                            <div>
                                <InputLabel value="Tags"/>

                                <div>
                                    <span class="mr-1 my-2 p-1 bg-amber-600 text-white rounded-lg inline-block"
                                          v-for="tag_item in form.tags" @click="deleteTag(tag_item)">
                                        {{ tag_item.name }}
                                    </span>
                                    <br>
                                    <select class="border border-gray-300 mr-2 rounded-lg" v-model="tag">
                                        <option :value="tag" v-for="tag in tags"> {{ tag.name }}</option>
                                    </select>
                                    <PrimaryButton type="button" @click="form.tags.push(tag)">Add tag</PrimaryButton>
                                </div>
                            </div>

                            <div>
                                <InputLabel for="desc" value="Desc"/>

                                <textarea
                                    id="content"
                                    class="border-gray-300 mt-1 w-full focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                    v-model="form.desc"></textarea>

                            </div>

                            <div>
                                <InputLabel for="dbs" value="Databases"/>

                                <TextInput
                                    id="dbs"
                                    v-model="form.dbs"
                                    type="text"
                                    class="mt-1 block w-full"
                                />

                                <InputError :message="form.errors.dbs" class="mt-2"/>
                            </div>

                            <div>
                                <InputLabel for="pages" value="Pages"/>

                                <TextInput
                                    id="pages"
                                    v-model="form.pages"
                                    type="text"
                                    class="mt-1 block w-full"
                                />

                                <InputError :message="form.errors.pages" class="mt-2"/>
                            </div>

                            <div>
                                <InputLabel for="props" value="Properties"/>

                                <TextInput
                                    id="props"
                                    v-model="form.props"
                                    type="text"
                                    class="mt-1 block w-full"
                                />

                                <InputError :message="form.errors.props" class="mt-2"/>
                            </div>

                            <div>
                                <InputLabel for="ver" value="Ver"/>

                                <TextInput
                                    id="ver"
                                    v-model="form.ver"
                                    type="text"
                                    class="mt-1 block w-full"
                                />

                                <InputError :message="form.errors.ver" class="mt-2"/>
                            </div>

                            <div>
                                <InputLabel for="slug" value="Slug"/>

                                <TextInput
                                    id="slug"
                                    ref="slugInput"
                                    v-model="form.slug"
                                    type="text"
                                    class="mt-1 block w-full"
                                />

                                <InputError :message="form.errors.slug" class="mt-2"/>
                            </div>

                            <div>
                                <InputLabel for="price" value="Price"/>

                                <TextInput
                                    id="price"
                                    ref="priceInput"
                                    v-model="form.price"
                                    type="number"
                                    class="mt-1 block w-full"
                                />

                                <InputError :message="form.errors.price" class="mt-2"/>
                            </div>

                            <div>
                                <InputLabel for="link" value="Link"/>

                                <TextInput
                                    id="link"
                                    ref="linkInput"
                                    v-model="form.link"
                                    type="url"
                                    class="mt-1 block w-full"
                                />

                                <InputError :message="form.errors.link" class="mt-2"/>
                            </div>
                        </form>

                        <div>
                            <div class="container flex my-4">
                                <div class="w-4/5 shadow-lg p-5 rounded-lg bg-white">
                                    <div ref="page" class="page">
                                        <Nested :item="item" v-for="item in items"/>
                                    </div>
                                </div>
                                <div class="w-1/5 ml-5 shadow-lg p-5 rounded-lg bg-white sticky top-0">
                                    <NestedAdd :items="items"/>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>

    <div v-show="false" class="w-1/2 w-1/3 w-1/4 w-1/5 w-1/6 w-1/12 w-full"></div>
</template>

<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import {useForm} from '@inertiajs/inertia-vue3';
import {Inertia} from '@inertiajs/inertia'
import {builder_store} from "@/builder_store";
import {ref} from 'vue';

const page = ref('page');

const props = defineProps(['template', 'builder_items', 'tags']);

const form = useForm({
    _method: 'put',
    title: props.template.title,
    preview: props.template.preview,
    preview_file: null,
    tags: props.template.tags,
    slug: props.template.slug,
    desc: props.template.desc,
    dbs: props.template.dbs,
    props: props.template.props,
    pages: props.template.pages,
    ver: props.template.ver,
    price: props.template.price,
    link: props.template.link,
    html: null,
    builder: null,
});

const updateTemplate = () => {
    form.html = page.value.outerHTML;
    form.builder = builder_store.items;

    form.post('/dashboard/templates/' + props.template.id, {
        preserveScroll: true,
        onSuccess: () => Inertia.visit(`/dashboard/templates/${props.template.id}/edit`, {only: ['template'],}),
    });
};

const deleteTag = (tag) => {
    form.tags = form.tags.filter((item) => item.id !== tag.id)
};
</script>

<script>
import Image from "@/Builder/Components/Image.vue";
import Container from "@/Builder/Components/Container.vue";
import Nested from "@/Builder/Components/Nested.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {builder_store} from "@/builder_store";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import NestedAdd from "@/Builder/Components/NestedAdd.vue";

export default {
    name: "Builder",
    components: {NestedAdd, PrimaryButton, AuthenticatedLayout, Nested, Container, Image},
    data() {
        return {
            tag: null,
            component: null,
            export_data: null,
            export_object: null,
        }
    },
    computed: {
        items() {
            return builder_store.items
        }
    },
    mounted() {
        builder_store.items = JSON.parse(JSON.stringify(this.builder_items))
    }
}
</script>
