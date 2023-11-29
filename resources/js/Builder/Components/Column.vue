<template>
    <div :class="config.classes">
        <slot/>
    </div>
</template>

<script>
export default {
    name: "Column",
    props: ['config']
}
</script>

<style scoped>
.column {
    outline: 1px solid red;
}
</style>
