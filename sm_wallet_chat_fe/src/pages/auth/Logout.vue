<script setup>
import auth from '@/crud/auth';
import { onMounted } from 'vue';
import { useRouter } from 'vue-router';
const { logout } = auth();
const router = useRouter();

onMounted(async () => {
    await logout();
    router.push('/login');
});
</script>

<template></template>