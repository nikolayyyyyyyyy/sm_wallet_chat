<script setup lang="ts">
import Button from '@/components/Button.vue';
import GoToArrow from '@/components/GoToArrow.vue';
import InputComponent from '@/components/InputComponent.vue';
import Load from '@/components/Load.vue';
import Select from '@/components/Select.vue';
import TextArea from '@/components/TextArea.vue';
import get from '@/crud/get';
import { update } from '@/crud/update';
import { onMounted, ref } from 'vue';
import { useRouter } from 'vue-router';
const props = defineProps({
    id:{
        type:String,
        required: true
    }
});
const transaction = ref();
const is_loading = ref(false);
const router = useRouter();
const { getItem, getData } = get();
const transaction_types = ref();

const is_fetching = ref(false);
const errors = ref();
const success_message = ref(false);
const { updateData } = update();
const other_err = ref(false);
const other_err_text = ref('');

const updateTransaction = async () => {
    if(is_fetching.value) return;
    const form_data = new FormData();
    form_data.append('account_sender_number', transaction.value.sender_account.account_number);
    form_data.append('account_receiver_number', transaction.value.receiver_account.account_number);
    form_data.append('transaction_type_id', transaction.value.transaction_type_id);
    form_data.append('amount', transaction.value.amount);
    form_data.append('note', transaction.value.note);

    try{
        is_fetching.value = true;
        await updateData(form_data, 'transactions', props.id);
        errors.value = [];
        success_message.value = true;

        setTimeout(() => {
            success_message.value = false;
        }, 3000);
    }catch(err){
        if(JSON.parse(err.message).errors){
            errors.value = JSON.parse(err.message).errors;
        }else if(JSON.parse(err.message).same_account || JSON.parse(err.message).not_enought_money){
            other_err_text.value = JSON.parse(err.message).same_account ? JSON.parse(err.message).same_account : JSON.parse(err.message).not_enought_money;
            other_err.value = true;

            setTimeout(() => {
                other_err.value = false;
            }, 3000);
        }

    }finally{
        is_fetching.value = false;
    }
};

onMounted(async () => {
    if(!localStorage.getItem('token')){
        router.push('/login');
        return;
    }

    is_loading.value = true;
    transaction.value = await getItem('transactions', props.id);
    transaction_types.value = await getData('transaction-types');
    is_loading.value = false;
});
</script>

<template>
    <section class="section-update-transaction">
        <div class="section__inner shell">
            <div class="section__title">
                <GoToArrow nav-to="/transactions" />

                <h1>Промяна на транзация</h1>
            </div>

            <form @submit.prevent="updateTransaction" v-if="!is_loading && transaction" class="section__update__transaction">
                <InputComponent label="изпращач" v-model="transaction.sender_account.account_number" />

                <InputComponent label="получател" v-model="transaction.receiver_account.account_number" />

                <InputComponent label="сума" v-model="transaction.amount" />

                <TextArea label="бележка" v-model="transaction.note" />
                
                <Select :options="transaction_types" v-model="transaction.transaction_type_id" id="select-transaction-type" />
            
                <Button type="submit" text="Промени" />
            </form>

            <Load v-else />

            <p v-if="success_message" class="success__message">Успешно променена транзакция.</p>

            <p v-if="other_err" class="error__message">{{ other_err_text }}</p>
        </div>
    </section>
</template>

<style scoped lang="scss">
.section-update-transaction{
    margin-block: 32px;

    .section__inner{
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    .section__update__transaction{
        display: flex;
        flex-direction: column;
        gap: 12px;
        width: 320px;
        align-self: center;
    }

    .section__title{
        display: grid;
        grid-template-columns: 1fr auto 1fr;
        align-items: center;
    }
}
</style>