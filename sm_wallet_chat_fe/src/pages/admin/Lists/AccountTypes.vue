<script setup lang="ts">
import Button from '@/components/Button.vue';
import GoToArrow from '@/components/GoToArrow.vue';
import Load from '@/components/Load.vue';
import { _delete } from '@/crud/delete';
import get from '@/crud/get';
import { onMounted, ref } from 'vue';
import { useRouter } from 'vue-router';
const account_types = ref([]);
const is_loading = ref(false);
const { getData } = get();
const { deleteItem } = _delete();
const router = useRouter();
const handleDelete = async (id) => {
    await deleteItem('account-types', id);

    account_types.value = account_types.value.filter(a => a.id != id);
};

onMounted(async () => {
    if(!localStorage.getItem('token')){
        router.push('/login');
        return;
    }
    is_loading.value = true;
    account_types.value = await getData('account-types');
    is_loading.value = false;
})
</script>

<template>
    <section class="section-account-types">
        <div class="section__inner shell">
            <div class="section__title">
                <GoToArrow nav-to="/" />

                <h1>Типове сметки</h1>
            </div>

            <div v-if="!is_loading" class="section__account__types">
                <div v-for="account_type in account_types" class="section__account__type custom-form">
                    <p class="account__type__title">Тип сметка:<span>{{ account_type.account_type }}</span></p>

                    <div class="section__buttons">
                        <RouterLink class="update__link" :to="{name: 'account_type.update', params: {id: account_type.id}}">
                            <Button text="Промени" />
                        </RouterLink>

                        <Button @click="handleDelete(account_type.id)" text="Изтрий" :delete_btn="true"/>
                    </div>
                </div>
            </div>

            <Load v-else />
        </div>
    </section>
</template>


<style scoped lang="scss">
.section-account-types{
    margin-block: 32px;

    .section__inner{
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    .section__account__types{
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
    }

    .account__type__title{
        display: flex;
        align-items: flex-end;
        gap: 3px;
        color: var(--c-base);
        font-weight: 600;

        span{
            color: var(--c-gray);
            font-size: 15px;
            font-weight: 700;
        }
    }

    .section__buttons{
        display: flex;
        gap: 20px;
    }

    .section__title{
        display: grid;
        grid-template-columns: 1fr auto 1fr;
        align-items: center;
    }

    @media (max-width: 1024px) {
        .section__account__types {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (max-width: 768px) {
        .section__account__types {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 480px) {
        .section__account__types {
            grid-template-columns: 1fr;
        }
    }
}
</style>