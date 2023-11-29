<template>
    <SettingsIcon @click="modal=true" :classes="['cursor-pointer', 'w-4']"/>
    <Modal :show="modal">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900">
                Column configurator
            </h2>

            <div class="mt-6">
                <InputLabel for="image-class" value="Classes" />

                <TextInput
                    id="image-class"
                    type="text"
                    v-model="item.config.classes"
                    class="mt-1 block w-full"
                    placeholder="Image classes"
                />
            </div>

            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="modal = false"> Close </SecondaryButton>
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


export default {
    name: "ColumnConfig",
    props: ['item'],
    components: {Modal, SecondaryButton, InputLabel, TextInput, SettingsIcon},
    data() {
        return {
            modal: false,
        }
    }
}
</script>

<style scoped>

</style>
