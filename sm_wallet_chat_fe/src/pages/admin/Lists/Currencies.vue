<script setup lang="ts">
import Button from '@/components/Button.vue';
import GoToArrow from '@/components/GoToArrow.vue';
import Load from '@/components/Load.vue';
import { _delete } from '@/crud/delete';
import get from '@/crud/get';
import { onMounted, ref } from 'vue';
import { useRouter } from 'vue-router';
const currencies = ref([]);
const { getData } = get();
const is_loading = ref(false);
const { deleteItem } = _delete();
const router = useRouter();
const handleDelete = async (id) => {
    await deleteItem('currencies', id);

    currencies.value = currencies.value.filter(c => c.id != id);
};

onMounted(async () => {
    if(!localStorage.getItem('token')){
        router.push('/login');
        return;
    }
    is_loading.value = true;
    currencies.value = await getData('currencies');
    is_loading.value = false;
});
</script>

<template>
    <section class="section-currencies">
        <div class="section__inner shell">
            <div class="section__title">
                <GoToArrow nav-to="/" />

                <h1>Валути</h1>
            </div>

            <div v-if="!is_loading" class="section__currencies">
                <div v-for="currency in currencies" class="section__currency custom-form">
                    <p class="currency_title">Валута:<span>{{ currency.currency }}</span></p>

                    <div class="section__buttons">
                        <RouterLink class="update__link" :to="{name: 'currency.update', params: {id: currency.id}}">
                            <Button text="Промени" />
                        </RouterLink>

                        <Button @click="handleDelete(currency.id)" text="Изтрий" :delete_btn="true"/>
                    </div>
                </div>
            </div>

            <Load v-else />
        </div>
    </section>
</template>

<style scoped lang="scss">
.section-currencies{
    margin-block: 32px;

    .section__inner{
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    .section__currency{
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .section__title{
        display: grid;
        grid-template-columns: 1fr auto 1fr;
        align-items: center;
    }

    .section__currencies{
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
    }

    .currency_title{
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

    @media (max-width: 1024px) {
        .section__currencies {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (max-width: 768px) {
        .section__currencies {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 480px) {
        .section__currencies {
            grid-template-columns: 1fr;
        }
    }
}
</style>