<script setup>
defineProps({
    inputError: String
})
</script>

<template>
    <div v-if="inputError" class="input-error">
        {{ inputError }}
    </div>
</template>

<style scoped>

</style>
