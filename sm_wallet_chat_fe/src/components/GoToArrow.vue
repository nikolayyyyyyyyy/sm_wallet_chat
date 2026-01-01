<script setup>
defineProps({
    navTo: {
        type: String,
        required: true
    }
});
</script>

<template>
    <RouterLink :to="navTo" class="go-to-arrow">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
            <path
                d="M8 20L14.6739 13.3261C15.299 12.701 15.6116 12.3884 15.6116 12C15.6116 11.6116 15.299 11.299 14.6739 10.6739L8 4"
                stroke="#6784C1" stroke-width="2.13333" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
    </RouterLink>
</template>

<style scoped>
.go-to-arrow {
    display: block;
    width: 24px;
    height: 24px;
    cursor: pointer;
    background: transparent;
    rotate: 180deg;
}
</style>