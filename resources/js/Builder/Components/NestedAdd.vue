<template>
    <ul :class="{'pl-6': child}">
        <li v-for="item in items">
            <div class="flex justify-between">
                <span class="capitalize">{{ item.component }}</span>
                <div class="flex">
                    <Config :item="item"/>
                    <AddComponent v-if="item.children" :item="item"/>
                </div>
            </div>
            <NestedAdd v-if="item.children" :items="item.children" :child="true"/>
        </li>
    </ul>

</template>

<script>
import AddComponent from "@/Builder/Components/AddComponent.vue";
import Config from "@/Builder/Components/Config.vue";

export default {
    name: "NestedAdd",
    components: {Config, AddComponent},
    props: ['items', 'child']
}
</script>

<style scoped>

</style>
