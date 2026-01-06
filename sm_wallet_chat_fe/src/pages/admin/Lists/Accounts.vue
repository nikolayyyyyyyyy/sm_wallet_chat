<script setup lang="ts">
import Button from '@/components/Button.vue';
import GoToArrow from '@/components/GoToArrow.vue';
import Load from '@/components/Load.vue';
import { _delete } from '@/crud/delete';
import get from '@/crud/get';
import { onMounted, ref } from 'vue';
import { useRouter } from 'vue-router';

const accounts = ref([]);
const is_loading = ref(false);
const router = useRouter();
const { getData } = get();
const { deleteItem } = _delete();

const deleteData = async (id) => {
    await deleteItem('accounts', id);

    accounts.value = accounts.value.filter(a => a.id != id);
};

onMounted(async () => {
    if(!localStorage.getItem('token')){
        router.push('/login');
        return;
    }

    is_loading.value = true;
    accounts.value = await getData('accounts');
    is_loading.value = false;
});
</script>

<template>
    <section class="section-accounts">
        <div class="section__inner shell">
            <div class="section__title">
                <GoToArrow nav-to="/" />

                <h1>Сметки</h1>
            </div>

            <div v-if="!is_loading && accounts" class="section__accounts">
                <div v-for="account in accounts" class="section__account custom-form">
                    <p class="section__account-title">Номер на сметка:<span>{{ account.account_number }}</span></p>
                    <p class="section__account-title">Наличност:<span>{{ account.amount }}</span></p>
                    <p class="section__account-title">Лихва:<span>{{ account.interest }}%</span></p>
                    <p class="section__account-title">Валута:<span>{{ account.currency.currency }}</span></p>
                    <p class="section__account-title">Тип сметка:<span>{{ account.account_type.account_type }}</span></p>
                    <p class="section__account-title">Картодържач:<span>{{ account.user.username }}</span></p>

                    <div class="section__buttons">
                        <RouterLink :to="{name: 'account.update', params: {id: account.id}}" class="update__btn">
                            <Button text="Промени" />
                        </RouterLink>

                        <Button @click="deleteData(account.id)" text="Изтрий" :delete_btn="true" />
                    </div>
                </div>
            </div>

            <Load v-else />
        </div>
    </section>
</template>

<style scoped lang="scss">
.section-accounts{
    margin-block: 32px;

    .section__buttons{
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .update__btn{
        background: transparent;
        width: 100%;
    }

    .section__account{
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .section__inner{
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    .section__account-title{
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

    .section__title{
        display: grid;
        grid-template-columns: 1fr auto 1fr;
        align-items: center;
    }

    .section__accounts{
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        align-items: center;
        gap: 20px;
    }

    @media screen and (max-width: 1220px) {
        .section__accounts{
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media screen and (max-width: 915px) {
        .section__accounts{
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media screen and (max-width: 645px) {
        .section__accounts{
            grid-template-columns: 1fr;
        }
    }
}
</style>