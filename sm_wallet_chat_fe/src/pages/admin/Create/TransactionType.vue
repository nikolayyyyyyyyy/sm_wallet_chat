<script setup lang="ts">
import Button from '@/components/Button.vue';
import GoToArrow from '@/components/GoToArrow.vue';
import InputComponent from '@/components/InputComponent.vue';
import { store } from '@/crud/create';
import { onMounted, ref } from 'vue';
import { useRouter } from 'vue-router';
const router = useRouter();
const transaction_type = ref();
const error = ref();
const is_fetching = ref(false);
const success_message = ref(false);
const { create } = store();

const store_transaction_type = async () => {
    if(is_fetching.value) return;

    try{
        is_fetching.value = true;
        await create({transaction_type: transaction_type.value}, 'transaction-types');
        error.value = '';
        transaction_type.value = '';
        success_message.value = true;

        setTimeout(() => {
            success_message.value = false;
        }, 3000);
    }catch(err){
        error.value = JSON.parse(err.message).errors.transaction_type[0];
    }finally{
        is_fetching.value = false;
    }
};

onMounted(() => {
    if(!localStorage.getItem('token')){
        router.push('/login');
        return;
    }
});
</script>

<template>
    <section class="section-create-transaction-type">
        <div class="section__inner shell">
            <div class="section__title">
                <GoToArrow nav-to="/" />

                <h1>Добавяне на тип транзакция</h1>
            </div>

            <form @submit.prevent="store_transaction_type" class="section__transaction__type custom-form">
                <InputComponent label="тип на транзакция" v-model="transaction_type" :error />

                <Button type="submit" class="btn" text="Добави" />
            </form>

            <p v-if="success_message" class="success__message">Успешно добавена тип транзакция</p>
        </div>
    </section>
</template>

<style scoped lang="scss">
.section-create-transaction-type{
    margin-block: 32px;

    .section__inner{
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    .section__title{
        display: grid;
        grid-template-columns: 1fr auto 1fr;
        align-items: center;
    }

    .section__transaction__type{
        display: flex;
        flex-direction: column;
        gap: 12px;
        width: 320px;
        align-self: center;
    }

    .btn{
        width: 120px;
    }
}
</style>