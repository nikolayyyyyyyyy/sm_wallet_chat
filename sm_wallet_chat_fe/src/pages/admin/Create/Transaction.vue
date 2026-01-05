<script setup lang="ts">
import Button from '@/components/Button.vue';
import GoToArrow from '@/components/GoToArrow.vue';
import InputComponent from '@/components/InputComponent.vue';
import Load from '@/components/Load.vue';
import Select from '@/components/Select.vue';
import TextArea from '@/components/TextArea.vue';
import { store } from '@/crud/create';
import get from '@/crud/get';
import { onMounted, ref } from 'vue';
import { useRouter } from 'vue-router';
const router = useRouter();
const errors = ref();
const { create } = store();
const transaction = ref({
    account_sender_number: '',
    account_receiver_number: '',
    amount: '',
    note: '',
    transaction_type_id: ''
});
const transaction_types = ref([]);
const is_loading = ref(false);
const { getData } = get();
const is_fetching = ref(false);
const success_message = ref(false);
const other_err = ref(false);
const other_err_text = ref();

const store_transaction = async () => {
    if(is_fetching.value) return;

    try{
        is_fetching.value = true;
        await create(transaction.value, 'transactions');
        errors.value = [];
        Object.keys(transaction.value).forEach(t => transaction.value[t] = '');
        success_message.value = true;

        setTimeout(() => {
            success_message.value = false;
        }, 3000);
    }catch(err){
        if(JSON.parse(err.message).errors){
            errors.value = JSON.parse(err.message).errors;
        }else if(JSON.parse(err.message).same_account){
            other_err.value = true;
            other_err_text.value = JSON.parse(err.message).same_account;

            setTimeout(() => {
                other_err.value = false
            }, 3000);
        }else if(JSON.parse(err.message).not_enought_money){
            other_err.value = true;
            other_err_text.value = JSON.parse(err.message).not_enought_money;

            setTimeout(() => {
                other_err.value = false;
            }, 3000);
        }
    }finally{
        is_fetching.value = false;
    }
}

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
    <section class="section-create-transaction">
        <div class="section__inner shell">
            <div class="section__title">
                <GoToArrow nav-to="/" />

                <h1>Добавяне на транзакция</h1>
            </div>

            <form @submit.prevent="store_transaction" v-if="!is_loading" class="section__transaction custom-form">
                <InputComponent label="сметка на изпращач" v-model="transaction.account_sender_number" :error="errors?.account_sender_number?.[0]"/>

                <InputComponent label="сметка на получател" v-model="transaction.account_receiver_number" :error="errors?.account_receiver_number?.[0]"/>

                <InputComponent label="сума" v-model="transaction.amount" :error="errors?.amount?.[0]"/>

                <TextArea label="бележка" v-model="transaction.note" :error="errors?.note?.[0]"/>

                <Select label="тип транзакция" :options="transaction_types" v-model="transaction.transaction_type_id" id="transaction-type-select" :error="errors?.transaction_type_id?.[0]"/>

                <Button type="submit" class="btn" text="Добави" />
            </form>

            <Load v-else />

            <p v-if="success_message" class="success__message">Успешно направена транзакция.</p>
            <p v-if="other_err" class="error__message">{{ other_err_text }}</p>
        </div>
    </section>
</template>

<style scoped lang="scss">
.section-create-transaction{
    margin-block: 32px;

    .btn{
        width: 120px;
    }

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

    .section__transaction{
        display: flex;
        flex-direction: column;
        gap: 12px;
        width: 320px;
        align-self: center;
    }
}
</style>