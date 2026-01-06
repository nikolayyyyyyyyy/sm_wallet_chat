<script setup lang="ts">
import Button from '@/components/Button.vue';
import GoToArrow from '@/components/GoToArrow.vue';
import Load from '@/components/Load.vue';
import { _delete } from '@/crud/delete';
import get from '@/crud/get';
import { onMounted, ref } from 'vue';
import { useRouter } from 'vue-router';

const router = useRouter();
const users = ref([]);
const is_loading = ref(false);
const { getData } = get();
const { deleteItem } = _delete();

const handleDelete = async (id) => {
    await deleteItem('users', id);

    users.value = users.value.filter(u => u.id != id);
};

onMounted(async () => {
    if(!localStorage.getItem('token')){
        router.push('/login');
        return;
    }

    is_loading.value = true;
    users.value = await getData('users');
    is_loading.value = false;
});
</script>

<template>
    <section class="section-users">
        <div class="section__inner shell">
            <div class="section__title">
                <GoToArrow nav-to="/" />

                <h1>Потребители</h1>
            </div>

            <div v-if="!is_loading && users.length > 0" class="section__users">
                <div v-for="user in users" class="section__user custom-form">
                    <div class="section__user-content">
                        <figure class="section__image image-fit">
                            <img :src="user.profile_photo ?? '/avatar.png'" alt="">
                        </figure>

                        <div class="section__contetn">
                            <p class="section__title">Потребител: <span>{{ user.username }}</span></p>
                            <p class="section__title">Имейл: <span>{{ user.email }}</span></p>
                        </div>
                    </div>

                    <div class="section__buttons">
                        <RouterLink class="update__link" :to="{name: 'user.update', params: {id: user.id}}">
                            <Button text="Промени"/>
                        </RouterLink>

                        <Button @click="handleDelete(user.id)" text="Изтрий" :delete_btn="true" />
                    </div>
                </div>
            </div>

            <Load v-else />
        </div>
    </section>
</template>

<style scoped lang="scss">
.section-users{
    margin-block: 32px;

    .section__image{
        width: 200px;
        aspect-ratio: 1 / 1;
        border: 2px solid var(--c-base);
        border-radius: 30px;
    }

    .section__inner{
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    .section__buttons{
        display: flex;
        gap: 20px;
    }

    .update__link{
        width: 100%;
    }

    .section__contetn{
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .section__title{
        display: flex;
        gap: 3px;
        color: var(--c-base);
        font-weight: 600;

        span{
            color: var(--c-gray);
            font-size: 15px;
            font-weight: 700;
        }
    }

    .section__user{
        display: flex;
        flex-direction: column;
        gap: 18px;
    }

    .section__user-content{
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 20px;
    }

    .section__title{
        display: grid;
        grid-template-columns: 1fr auto 1fr;
        align-items: center;
    }

    .section__users{
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 10px;
    }

    @media screen and (max-width: 830px) {
        .section__users{
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media screen and (max-width: 550px) {
        .section__users{
            grid-template-columns: 1fr;
        }
    }
}
</style>