<script setup>
import Load from '@/components/Load.vue';
import Admin from '@/layouts/Admin.vue';
import User from '@/layouts/User.vue';
import { onMounted, ref } from 'vue';
import { useRouter } from 'vue-router';
const router = useRouter();
const user = ref();
const is_loading = ref(false);

onMounted(async () => {
    if(!localStorage.getItem('token')){
        router.push('/login');
        return;
    }

    is_loading.value = true;
    user.value = await (await fetch('http://127.0.0.1:8000/api/user',{
        method: 'GET',
        headers:{
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${localStorage.getItem('token')}`
        }
    })).json();
    is_loading.value = false;
});
</script>

<template>
    <section class="section-dashboard">
        <div class="section__inner shell">
            <User v-if="!is_loading && user?.role_id == 2" :user/>

            <Admin v-if="!is_loading && user?.role_id == 1" />
            
            <Load v-if="is_loading" />
        </div>
    </section>
</template>

<style scoped lang="scss">
.section-dashboard{
    margin-block: 32px;
}
</style>