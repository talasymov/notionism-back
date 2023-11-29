<template>
    <div v-html="item.config.source" class="page"></div>
</template>

<script>
export default {
    name: "Html",
    props: ['item', 'config'],
}
</script>

<style scoped>

</style>
