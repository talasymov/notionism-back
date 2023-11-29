<template>
    <SettingsIcon @click="modal=true" :classes="['cursor-pointer', 'w-4']"/>
    <Modal :show="modal">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900">
                Image configurator
            </h2>

            <div class="mt-6">
                <InputLabel for="table-name" value="Table name"/>

                <TextInput
                    id="table-name"
                    type="text"
                    v-model="item.config.table_name"
                    class="mt-1 block w-full"
                    placeholder="Table name"
                />

                <table>
                    <thead>
                    <tr>
                        <th>Property</th>
                        <th>Type</th>
                        <th>Description</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="prop_item in item.config.items">
                        <td>
                            <TextInput
                                type="text"
                                v-model="prop_item.property"
                                class="mt-1 block w-full"
                                placeholder="Property"
                            />
                        </td>
                        <td>
                            <select v-model="prop_item.type">
                                <option value="text">Text</option>
                                <option value="number">Number</option>
                                <option value="select">Select</option>
                                <option value="multi-select">Multi-select</option>
                                <option value="status">Status</option>
                                <option value="date">Date</option>
                                <option value="person">Person</option>
                                <option value="files_media">Files & media</option>
                                <option value="checkbox">Checkbox</option>
                                <option value="url">URL</option>
                                <option value="email">Email</option>
                                <option value="phone">Phone</option>
                                <option value="formula">Formula</option>
                                <option value="relation">Relation</option>
                                <option value="rollup">Rollup</option>
                                <option value="created_time">Created time</option>
                                <option value="created_by">Created by</option>
                                <option value="last_edited_time">Last edited time</option>
                                <option value="last_edited_by">Last edited by</option>
                            </select>
<!--                            <TextInput-->
<!--                                type="text"-->
<!--                                v-model="prop_item.type"-->
<!--                                class="mt-1 block w-full"-->
<!--                                placeholder="Type"-->
<!--                            />-->
                        </td>
                        <td>
<!--                            <TextInput-->
<!--                                type="text"-->
<!--                                v-model=""-->
<!--                                class="mt-1 block w-full"-->
<!--                                placeholder="Description"-->
<!--                            />-->
                            <vue-editor v-model="prop_item.description" />
                        </td>
                    </tr>
                    </tbody>
                </table>
                <SecondaryButton @click="add">Add</SecondaryButton>

                <InputLabel for="image-class" value="Classes"/>

                <TextInput
                    type="text"
                    v-model="item.config.classes"
                    class="mt-1 block w-full"
                    placeholder="Classes"
                />
            </div>

            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="modal = false">Close</SecondaryButton>
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
import { VueEditor } from "vue3-editor";

export default {
    name: "TablePropsConfig",
    props: ['item'],
    components: {Modal, SecondaryButton, InputLabel, TextInput, SettingsIcon, VueEditor},
    data() {
        return {
            modal: false,
        }
    },
    methods: {
        add() {
            this.item.config.items.push({
                property: '',
                type: '',
                description: '',
            })
        }
    }
}
</script>

<style scoped>

</style>
