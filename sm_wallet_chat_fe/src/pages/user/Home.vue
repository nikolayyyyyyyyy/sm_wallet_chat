<script setup>
import { onMounted, ref } from 'vue';

const user = ref({});

onMounted(async () => {
    user.value = await (await fetch('http://127.0.0.1:8000/api/user',{
        method: 'GET',
        headers:{
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${localStorage.getItem('token')}`
        }
    })).json();
});
</script>

<template>
    <p v-if="user?.email">Wellcome {{ user.email }}</p>
</template>