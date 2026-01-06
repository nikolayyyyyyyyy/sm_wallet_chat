<script setup lang="ts">
import Button from '@/components/Button.vue';
import GoToArrow from '@/components/GoToArrow.vue';
import Load from '@/components/Load.vue';
import { _delete } from '@/crud/delete';
import get from '@/crud/get';
import { onMounted, ref } from 'vue';
import { useRouter } from 'vue-router';

const transactions = ref([]);
const is_loading = ref(false);
const router = useRouter();
const { getData } = get();
const { deleteItem } = _delete();

const deleteData = async (id) => {
    await deleteItem('transactions', id);

    transactions.value = transactions.value.filter(t => t.id != id);
};

onMounted(async () => {
    if(!localStorage.getItem('token')){
        router.push('/login');
        return;
    }

    is_loading.value = true;
    transactions.value = await getData('transactions');
    is_loading.value = false;
});
</script>

<template>
    <section class="section-transactions">
        <div class="section__inner shell">
            <div class="section__title">
                <GoToArrow nav-to="/" />

                <h1>Транзакции</h1>
            </div>

            <div v-if="!is_loading && transactions" class="section__transactions">
                <div v-for="transaction in transactions" class="section__transaction custom-form">
                    <p class="section__title-text">Изпращач:<span>{{ transaction.sender_account.account_number }}</span></p>
                    <p class="section__title-text">Получател:<span>{{ transaction.receiver_account.account_number }}</span></p>
                    <p class="section__title-text">Изпращач:<span>{{ transaction.amount }} {{ transaction.sender_account.currency.currency }}</span></p>
                    <p class="section__title-text">Изпращач:<span>{{ transaction.note ?? 'няма.' }}</span></p>
                    <p class="section__title-text">Изпращач:<span>{{ transaction.transaction_type.transaction_type }}</span></p>
                
                    <div class="section__btns">
                        <RouterLink class="update__link" :to="{name: 'transaction.update', params: {id: transaction.id}}">
                            <Button text="Промени" class="update__btn" />
                        </RouterLink>

                        <Button @click="deleteData(transaction.id)" text="Изтрий" :delete_btn="true" />
                    </div>
                </div>
            </div>

            <Load v-else />
        </div>
    </section>
</template>

<style scoped lang="scss">
.section-transactions{
    margin-block: 32px;

    .update__link{
        padding: 0;
        background: transparent;
    }

    .section__btns{
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .section__title{
        display: grid;
        grid-template-columns: 1fr auto 1fr;
        align-items: center;
    }

    .section__transaction{
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .section__title-text{
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

    .section__inner{
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    .section__transactions{
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        align-items: center;
        gap: 15px;
    }

    @media screen and (max-width: 1140px) {
        .section__transactions{
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media screen and (max-width: 900px) {
        .section__transactions{
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media screen and (max-width: 675px) {
        .section__transactions{
            grid-template-columns: 1fr;
        }
    }
}
</style>