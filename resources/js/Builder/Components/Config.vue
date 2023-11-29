<template>
    <component :is="item.component + 'Config'" :item="item"/>
</template>

<script>
import ImageConfig from "@/Builder/Components/Config/ImageConfig.vue";
import ContainerConfig from "@/Builder/Components/Config/ContainerConfig.vue";
import ColumnConfig from "@/Builder/Components/Config/ColumnConfig.vue";
import HtmlConfig from "@/Builder/Components/Config/HtmlConfig.vue";
import TablePropsConfig from "@/Builder/Components/Config/TablePropsConfig.vue";

export default {
    name: "Config",
    components: {ImageConfig, ContainerConfig, ColumnConfig, HtmlConfig, TablePropsConfig},
    props: ['item']
}
</script>

<style scoped>

</style>
