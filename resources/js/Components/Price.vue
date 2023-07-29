<script setup>
import {computed} from 'vue'

const props = defineProps({
    price: [Number, String]
})
const formattedPrice = computed(
    () => Number(props.price).toLocaleString('en-MY', {
        style: 'currency',
        currency: 'MYR',
        maximumFractionDigits: 2
    }),
)
</script>

<template>
    <span>{{ formattedPrice }}</span>
</template>

<style scoped>

</style>
