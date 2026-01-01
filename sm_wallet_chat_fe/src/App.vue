<script setup>
import NavComponent from './components/NavComponent.vue';

</script>

<template>
    <NavComponent />

    <RouterView />
</template>

<style scoped>
.nav{
    display: flex;
    align-items: center;
    gap:20px;
}
</style>
