<script setup lang="ts">
import Account from '@/components/Account.vue';
import Button from '@/components/Button.vue';
import GoToArrow from '@/components/GoToArrow.vue';
import InputComponent from '@/components/InputComponent.vue';
import Load from '@/components/Load.vue';
import NoResultFount from '@/components/NoResultFount.vue';
import Select from '@/components/Select.vue';
import TextArea from '@/components/TextArea.vue';
import { store } from '@/crud/create';
import get from '@/crud/get';
import { onMounted, ref } from 'vue';

const user = ref();
const is_loading = ref();
const { getData } = get();
const transaction = ref({
    account_sender_id: '',
    account_receiver_number: '',
    amount: '',
    note: '',
    transaction_type_id: ''
});
const { create } = store();
const is_fetching = ref(false);
const transaction_types = ref([]);
const errors = ref();
const success_message = ref(false);
const same_account_err = ref(false);
const not_enought_money_err = ref(false);
const other_err = ref();

const sendMoney = async () => {
    if(is_fetching.value) return;

    try{
        is_fetching.value = true;
        await create(transaction.value, 'transactions');
        errors.value = null;
        is_loading.value = true;
        user.value = await (await fetch('http://127.0.0.1:8000/api/user',{
            method: 'GET',
            headers:{
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${localStorage.getItem('token')}`
            }
        })).json();
        is_loading.value = false;
        success_message.value = true;
        Object.keys(transaction.value).forEach(t => transaction.value[t] = '');
        other_err.value = '';
        setTimeout(() => {
            success_message.value = false;
        }, 5000);
    }catch(err){
        if(JSON.parse(err.message).errors){
            errors.value = JSON.parse(err.message).errors;
        } else if(JSON.parse(err.message).same_account){
            same_account_err.value = true;
            other_err.value = JSON.parse(err.message).same_account;
            setTimeout(() => {
                same_account_err.value = false
            }, 3000);
        } else{
            not_enought_money_err.value = true;
            other_err.value = JSON.parse(err.message).not_enought_money;
            setTimeout(() => {
                not_enought_money_err.value = false;
            }, 3000);
        }
    }finally{
        is_fetching.value = false;
    }
};

onMounted(async () => {
    is_loading.value = true;
    user.value = await (await fetch('http://127.0.0.1:8000/api/user',{
        method: 'GET',
        headers:{
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${localStorage.getItem('token')}`
        }
    })).json();

    if(user.value.accounts[0]){
        transaction.value.account_sender_id = user.value.accounts[0].id;
    }
    transaction_types.value = await getData('transaction-types');
    is_loading.value = false;
});
</script>

<template>
    <section class="section-send-money">
        <div class="section__inner shell">
            <div class="section__title">
                <GoToArrow nav-to="/" />

                <h1>Превод</h1>
            </div>

            <div v-if="!is_loading && user && user?.accounts?.length > 0" class="section__content">
                <div class="section__cards custom-form">
                    <label class="content__card" v-for="(account, index) in user.accounts" :key="account.id" :for="'card-' + account.id">
                        <div class="section__radio-btn" :class="{ selected: transaction.account_sender_id === account.id }">
                            <svg v-if="account.id != transaction.account_sender_id" xmlns="http://www.w3.org/2000/svg" width="21"
                                height="20" viewBox="0 0 21 20" fill="none">
                                <circle cx="10.5" cy="10" r="8.935" stroke="#6784C1" stroke-width="2.13" />
                            </svg>

                            <svg v-else xmlns="http://www.w3.org/2000/svg" width="21" height="22" viewBox="0 0 22 24"
                                fill="none">
                                <circle cx="12.5" cy="12" r="8.935" stroke="#6784C1" stroke-width="2.13" />
                                <circle cx="12.5" cy="12" r="3.935" fill="#6784C1" stroke="#6784C1" stroke-width="2.13" />
                            </svg>
                        </div>
                        
                        <input type="radio" name="card" :id="'card-' + account.id" v-model="transaction.account_sender_id" :value="account.id" hidden>

                        <Account :account :class="{ 'light': index % 2 == 0, 'gray': index % 2 == 1 }" />
                    </label>
                </div>

                <form @submit.prevent="sendMoney" class="section__account__info">
                    <div class="account__info-top">
                        <InputComponent :error="errors?.account_receiver_number?.[0]" label="сметка на получател" v-model="transaction.account_receiver_number"/>

                        <InputComponent :error="errors?.amount?.[0]" label="сума" v-model="transaction.amount" />
                    </div>

                    <TextArea :error="errors?.note?.[0]" label="бележка" v-model="transaction.note" />

                    <Select :error="errors?.transaction_type_id?.[0]" v-model="transaction.transaction_type_id" :options="transaction_types" id="transaction-types" label="вид транзакция" />

                    <Button class="btn" type="submit" text="направи транзакция" />
                </form>
            </div>

            <NoResultFount class="empty" v-if="user?.accounts?.length == 0 && !is_loading" text="Нямате сметки." />
            <p v-if="success_message" class="success__message">Успешна транзакция</p>
            <p v-if="same_account_err" class="error__message">{{ other_err }}</p>
            <p v-if="not_enought_money_err" class="error__message">{{ other_err }}</p>
            <Load v-if="is_loading" />
        </div>
    </section>
</template>

<style scoped lang="scss">
.section-send-money{
    margin-block: 32px;

    .btn{
        width: 200px;
    }

    .section__inner{
        display: flex;
        flex-direction: column;
        gap: 32px;
    }

    .section__title{
        display: grid;
        grid-template-columns: 1fr auto 1fr;
        align-items: center;
    }

    .section__content{
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 50px;
    }

    .section__cards{
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .content__card{
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .section__account__info{
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .account__info-top{
        display: flex;
        gap: 20px;
    }

    .empty{
        align-self: center;
    }
}
</style>