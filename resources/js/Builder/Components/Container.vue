<template>
    <div class="container" :class="config.classes">
        <slot/>
    </div>
</template>

<script>
import AddComponent from "@/Builder/Components/AddComponent.vue";

export default {
    name: "Container",
    components: {AddComponent},
    props: ['item', 'config'],
    data() {
        return {
            modal: false
        }
    }
}
</script>

<style scoped>
.container {
    outline: 2px solid grey;
}
</style>
