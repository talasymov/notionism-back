<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Link} from '@inertiajs/inertia-vue3';
import {useForm, Head} from '@inertiajs/inertia-vue3';
import PrimaryButton from "@/Components/PrimaryButton.vue";

const form = useForm({
    name: '',
});

const create = () => {
    form.post('/dashboard/templates')
};

defineProps(['templates']);
</script>

<template>
    <Head title="Templates"/>

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Templates</h2>
                <form @submit.prevent="create">
                    <PrimaryButton>Create</PrimaryButton>
                </form>
            </div>
        </template>

        <div class="max-w-7xl mx-auto p-4 sm:p-6 lg:p-8">
            <table class="border-collapse table-auto w-full text-sm">
                <thead>
                <tr>
                    <th class="border-b dark:border-slate-600 font-medium p-4 pl-8 pt-0 pb-3 text-slate-400 dark:text-slate-200 text-left">
                        Title
                    </th>
                    <th class="border-b dark:border-slate-600 font-medium p-4 pt-0 pb-3 text-slate-400 dark:text-slate-200 text-left">
                        Slug
                    </th>
                </tr>
                </thead>
                <tbody class="bg-white dark:bg-slate-800">
                <tr v-for="template in templates">
                    <td class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">
                        <Link :href="`/dashboard/templates/${template.id}/edit`">
                            {{ template.title }}
                        </Link>
                    </td>
                    <td class="border-b border-slate-100 dark:border-slate-700 p-4 text-slate-500 dark:text-slate-400">
                        {{ template.slug }}
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </AuthenticatedLayout>
</template>
