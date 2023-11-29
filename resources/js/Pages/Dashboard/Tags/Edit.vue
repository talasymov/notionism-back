<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/inertia-vue3';
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia'

const props = defineProps(['tags', 'tag', 'categories']);

const titleInput = ref(null);
const slugInput = ref(null);

const form = useForm({
    name: props.tag.name,
    slug: props.tag.slug,
    icon: props.tag.icon,
    tag_id: props.tag.tag_id,
    category_id: props.tag.category_id,
});

const updateTag = () => {
    form.put('/dashboard/tags/' + props.tag.id, {
        preserveScroll: true,
        onSuccess: () => Inertia.visit(`/dashboard/tags/${props.tag.id}/edit`, {only: ['tag'],}),
        onError: () => {
            // if (form.errors.password) {
            //     form.reset('password', 'password_confirmation');
            //     passwordInput.value.focus();
            // }
            // if (form.errors.current_password) {
            //     form.reset('current_password');
            //     currentPasswordInput.value.focus();
            // }
        },
    });
};
</script>

<template>
    <Head title="Edit tag"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit tag</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <section>
                        <form @submit.prevent="updateTag" class="mt-6 space-y-6">
                            <div>
                                <InputLabel for="name" value="Name" />

                                <TextInput
                                    id="name"
                                    ref="nameInput"
                                    v-model="form.name"
                                    type="text"
                                    class="mt-1 block w-full"
                                />

                                <InputError :message="form.errors.name" class="mt-2" />
                            </div>

                            <div>
                                <InputLabel for="slug" value="Slug" />

                                <TextInput
                                    id="slug"
                                    ref="slugInput"
                                    v-model="form.slug"
                                    type="text"
                                    class="mt-1 block w-full"
                                />

                                <InputError :message="form.errors.slug" class="mt-2" />
                            </div>

                            <div>
                                <InputLabel for="icon" value="Icon" />

                                <TextInput
                                    id="icon"
                                    ref="iconInput"
                                    v-model="form.icon"
                                    type="text"
                                    class="mt-1 block w-full"
                                />

                                <InputError :message="form.errors.icon" class="mt-2" />
                            </div>

                            <div>
                                <InputLabel for="tag_id" value="Parent Tag" />

                                <select
                                    id="tag_id"
                                    v-model="form.tag_id"
                                    type="text"
                                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                >
                                    <option :value="null">None</option>
                                    <option v-for="tag_item in tags" :value="tag_item.id">{{ tag_item.name }}</option>
                                </select>

                                <InputError :message="form.errors.tag_id" class="mt-2" />
                            </div>

                            <div>
                                <InputLabel for="category" value="Category" />

                                <select
                                    id="category"
                                    ref="categoryInput"
                                    v-model="form.category_id"
                                    type="text"
                                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                >
                                    <option v-for="category in categories" :value="category.id">{{ category.name }}</option>
                                </select>

                                <InputError :message="form.errors.category_id" class="mt-2" />
                            </div>

                            <div class="flex items-center gap-4">
                                <PrimaryButton :disabled="form.processing">Save</PrimaryButton>

                                <Transition enter-from-class="opacity-0" leave-to-class="opacity-0" class="transition ease-in-out">
                                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Saved.</p>
                                </Transition>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
