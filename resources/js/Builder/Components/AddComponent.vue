<template>
    <AddCircleIcon @click="modal=true" :classes="['cursor-pointer', 'w-4', 'ml-1', 'hover:fill-red-500']"/>
    <Modal :show="modal">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900">
                Add component
            </h2>

            <div class="grid grid-cols-4 gap-4">
                <div class="rounded-lg shadow-lg p-4 uppercase font-black cursor-pointer hover:text-blue-700"
                     @click="add(component)" v-for="component in components">{{ component }}
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="modal = false">Close</SecondaryButton>
            </div>
        </div>
    </Modal>
</template>

<script>
import {builder_store} from "@/builder_store";
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import AddCircleIcon from "@/Icons/AddCircleIcon.vue";

export default {
    name: "AddComponent",
    components: {AddCircleIcon, SecondaryButton, Modal},
    props: ['item'],
    data() {
        return {
            components: ['container', 'column', 'image', 'html', 'tableProps'],
            modal: false,
            default_config: {
                image: {
                    src: 'https://via.placeholder.com/640x480.png/001199?text=recusandae',
                    alt: 'no image'
                },
                column: {
                    classes: 'column w-full lg:w-1/3'
                },
                container: {
                    classes: 'container w-full flex'
                },
                html: {
                    classes: 'container',
                    source: 'asd'
                },
                tableProps: {
                    classes: 'container',
                    table_name: '',
                    items: []
                }
            }
        }
    },
    methods: {
        add(component) {
            let obj = {
                component: component,
                config: this.default_config[component],
            }

            if (['main', 'container', 'column'].includes(component)) {
                obj['children'] = []
            }

            if (component === 'container') {
                obj['children'] = [
                    {component: 'column', config: this.default_config.column, children: []}
                ]
            }

            builder_store.add(this.item, obj)

            this.modal = false
        },
    }
}
</script>

<style scoped>

</style>
