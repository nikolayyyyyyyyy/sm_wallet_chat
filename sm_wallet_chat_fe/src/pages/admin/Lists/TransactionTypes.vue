<script setup lang="ts">
import Button from '@/components/Button.vue';
import GoToArrow from '@/components/GoToArrow.vue';
import Load from '@/components/Load.vue';
import { _delete } from '@/crud/delete';
import get from '@/crud/get';
import { onMounted, ref } from 'vue';
import { useRouter } from 'vue-router';
const transaction_types = ref();
const { getData } = get();
const is_loading = ref(false);
const { deleteItem } = _delete();
const router = useRouter();

const handleDelete = async (id) => {
    await deleteItem('transaction-types', id);

    transaction_types.value = transaction_types.value.filter(t => t.id != id);
};

onMounted(async () => {
    if(!localStorage.getItem('token')){
        router.push('/login');
        return;
    }
    is_loading.value = true;
    transaction_types.value = await getData('transaction-types');
    is_loading.value = false;
});
</script>

<template>
    <section class="section-transaction-types">
        <div class="section__inner shell">
            <div class="section__title">
                <GoToArrow nav-to="/" />

                <h1>Типове транзакции</h1>
            </div>

            <div v-if="!is_loading" class="section__transactions">
                <div v-for="transaction_type in transaction_types" class="section__transaction custom-form">
                    <p class="transaction_type_title">Валута:<span>{{ transaction_type.text }}</span></p>

                    <div class="section__buttons">
                        <RouterLink class="update__link" :to="{name: 'transaction_type.update', params: {id: transaction_type.id}}">
                            <Button text="Промени" />
                        </RouterLink>

                        <Button @click="handleDelete(transaction_type.id)" text="Изтрий" :delete_btn="true"/>
                    </div>
                </div>
            </div>

            <Load v-else />
        </div>
    </section>
</template>

<style scoped lang="scss">
.section-transaction-types{
    margin-block: 32px;

    .section__inner{
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .section__transactions{
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
    }

    .transaction_type_title{
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

    .update__link{
        background: transparent;
        width: 100%;
    }

    .section__buttons{
        display: flex;
        gap: 20px;
    }

    @media (max-width: 1024px) {
        .section__transactions {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (max-width: 768px) {
        .section__transactions {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 480px) {
        .section__transactions {
            grid-template-columns: 1fr;
        }
    }

    .section__title{
        display: grid;
        grid-template-columns: 1fr auto 1fr;
        align-items: center;
    }
}
</style>