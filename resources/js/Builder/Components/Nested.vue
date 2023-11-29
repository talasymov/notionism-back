<template>
    <component :is="item.component" :item="item" :config="item.config">
        <Nested :item="child" v-for="child in item.children"/>
    </component>
</template>

<script>
import Image from "@/Builder/Components/Image.vue";
import Container from "@/Builder/Components/Container.vue";
import Column from "@/Builder/Components/Column.vue";
import Main from "@/Builder/Components/Main.vue";
import Html from "@/Builder/Components/Html.vue";
import TableProps from "@/Builder/Components/TableProps.vue";

export default {
    name: "Nested",
    components: {Html, Container, Column, Image, Main, TableProps},
    props: ['item'],
}
</script>

<style scoped>

</style>
