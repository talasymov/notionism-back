<template>
    <img :src="config.src" alt="No Image" :class="config.classes">
</template>

<script>
export default {
    name: "Image",
    props: ['config'],
}
</script>

<style scoped>

</style>
