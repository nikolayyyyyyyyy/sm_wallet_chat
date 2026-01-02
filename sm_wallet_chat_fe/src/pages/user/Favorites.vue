<script setup lang="ts">
import GoToArrow from '@/components/GoToArrow.vue';
import Load from '@/components/Load.vue';
import NoResultFount from '@/components/NoResultFount.vue';
import User from '@/components/User.vue';
import { onMounted, ref } from 'vue';
const liked_users = ref([]);
const is_loading = ref(false);

onMounted(async () => {
    is_loading.value = true;
    liked_users.value = await (await fetch('http://127.0.0.1:8000/api/favorites-all', {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'Authorization': `Bearer ${localStorage.getItem('token')}`
        }
    })).json();
    is_loading.value = false;
});
</script>

<template>
    <section class="section-favorite-users">
        <div class="section__inner shell">
            <div class="section__title">
                <GoToArrow nav-to="/"/>

                <h1>Харесани потребители</h1>
            </div>

            <div class="section__content">
                <div v-if="liked_users.length > 0 && !is_loading" class="section__users">
                    <User v-for="user in liked_users" :chat-icon="true" :user/>
                </div>

                <Load v-if="is_loading" />

                <NoResultFount v-if="!is_loading && liked_users.length == 0" text="Не сте добавили никой в харесани." />
            </div>
        </div>
    </section>
</template>

<style scoped lang="scss">
.section-favorite-users{
    margin-block: 32px;

    .section__inner{
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .section__content{
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 20px;
    }

    .section__title{
        display: grid;
        grid-template-columns: 1fr auto 1fr;
        align-items: center;
        
        h1{
            cursor: default;
        }
    }
}
</style>