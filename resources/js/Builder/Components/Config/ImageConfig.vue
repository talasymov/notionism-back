<template>
    <SettingsIcon @click="modal=true" :classes="['cursor-pointer', 'w-4']"/>
    <Modal :show="modal">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900">
                Image configurator
            </h2>

            <div class="mt-6">
                <InputLabel for="image-url" value="Url"/>

                <form @submit.prevent="upload">
                    <input type="file" v-on:change="onChange"/>

                    <InputError :message="error" v-for="error in form.errors.image" class="mt-2"/>

                    <button type="submit">Upload</button>
                </form>

                <TextInput
                    id="image-url"
                    type="text"
                    v-model="item.config.src"
                    class="mt-1 block w-full"
                    placeholder="Image url"
                />

                <InputLabel for="image-class" value="Classes"/>

                <TextInput
                    id="image-class"
                    type="text"
                    v-model="item.config.classes"
                    class="mt-1 block w-full"
                    placeholder="Image classes"
                />
            </div>

            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="modal = false"> Close</SecondaryButton>
            </div>
        </div>
    </Modal>
</template>

<script>
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import SettingsIcon from "@/Icons/SettingsIcon.vue";
import InputError from '@/Components/InputError.vue';


export default {
    name: "ImageConfig",
    props: ['item'],
    components: {Modal, SecondaryButton, InputLabel, TextInput, SettingsIcon, InputError},
    data() {
        return {
            modal: false,
            form: {
                image: null,
                errors: {}
            },
        }
    },
    methods: {
        onChange(e) {
            this.form.image = e.target.files[0]
        },
        upload() {
            let data = new FormData();
            data.append('image', this.form.image);
            axios.post('/dashboard/images', data, {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            })
                .then((res) => this.item.config.src = res.data.path)
                .catch((res) => this.form.errors = res.response.data.errors)
        },
    }
}
</script>

<style scoped>

</style>
