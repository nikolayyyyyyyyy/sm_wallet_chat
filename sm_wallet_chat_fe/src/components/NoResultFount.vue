<script setup>
defineProps({
    text:{
        type: String,
        required: true
    }
});
</script>

<template>
    <div class="empty">
        {{ text }}
    </div>
</template>

<style scoped lang="scss">
.empty{
    width: fit-content;
    color: var(--c-gray);
    padding: 10px;
    border-radius: 10px;
    background: var(--c-red);
}
</style>