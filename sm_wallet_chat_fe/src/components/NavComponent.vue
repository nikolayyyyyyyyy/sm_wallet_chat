<script setup>
import auth from '@/crud/auth';

const  { is_logged }  = auth();
</script>

<template>
    <nav class="nav">
        <RouterLink v-if="is_logged" to="/">
            Начало
        </RouterLink>
        <RouterLink v-if="is_logged" to="/profile">
            Профил
        </RouterLink>
        <RouterLink v-if="!is_logged" to="/login">
            Вход
        </RouterLink>
        <RouterLink class="logout" v-if="is_logged" to="/logout">
            Изход
        </RouterLink>
    </nav>
</template>

<style scoped lang="scss">
.nav{
    display: flex;
    align-items: center;
    gap:10px;
    background: var(--c-blue);
    padding: 5px 10px;
    font-weight: 500;
}

.logout{
    margin-left: auto;
}
</style>