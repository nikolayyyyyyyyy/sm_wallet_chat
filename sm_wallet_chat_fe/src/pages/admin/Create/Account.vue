<script setup lang="ts">
import Button from '@/components/Button.vue';
import GoToArrow from '@/components/GoToArrow.vue';
import InputComponent from '@/components/InputComponent.vue';
import Load from '@/components/Load.vue';
import Select from '@/components/Select.vue';
import { store } from '@/crud/create';
import get from '@/crud/get';
import { onMounted, ref } from 'vue';
import { useRouter } from 'vue-router';
const router = useRouter();
const { getData } = get();
const account = ref({
    account_number: '',
    amount: '',
    interest: '',
    currency_id: '',
    account_type_id: '',
    user_id: ''
});
const currencies = ref([]);
const account_types = ref([]);
const users = ref([]);
const errors = ref();
const is_fetching = ref();
const is_loading = ref();
const success_message = ref();
const { create } = store();

const storeAccount = async () => {
    if(is_fetching.value) return;

    try{
        is_fetching.value = true;
        await create(account.value, 'accounts');
        errors.value = [];
        Object.keys(account.value).forEach(a => account.value[a] = '');
        success_message.value = true;

        setTimeout(() => {
            success_message.value = false;
        }, 3000);
    }catch(err){
        errors.value = JSON.parse(err.message).errors;
    }finally{
        is_fetching.value = false;
    }
};

onMounted(async () =>{
    if(!localStorage.getItem('token')){
        router.push('/login');
        return;
    }

    is_loading.value = true;
    currencies.value = (await getData('currencies'))
        .map(c => { return { id: c.id, text: c.currency }; });

    account_types.value = (await getData('account-types'))
        .map(at => { return { id: at.id, text: at.account_type }; });

    users.value = (await getData('users'))
        .map(u => { return { id: u.id, text: `${u.username} ${u.email}` }; });
    is_loading.value = false;
});
</script>

<template>
    <section class="section-create-account">
        <div class="section__inner shell">
            <div class="section__title">
                <GoToArrow nav-to="/" />

                <h1>Добавяне на сметка</h1>
            </div>

            <form @submit.prevent="storeAccount" v-if="!is_loading" class="section__account custom-form">
                <InputComponent label="номер на сметка" v-model="account.account_number" :error="errors?.account_number?.[0]"/>

                <InputComponent label="наличност" v-model="account.amount" :error="errors?.amount?.[0]"/>

                <InputComponent label="лихва" v-model="account.interest" :error="errors?.interest?.[0]"/>

                <Select :options="currencies" label="валута" v-model="account.currency_id" id="currency-select" :error="errors?.currency_id?.[0]"/>

                <Select :options="account_types" label="тип на сметка" v-model="account.account_type_id" id="account-type-select" :error="errors?.account_type_id?.[0]"/>

                <Select :options="users" label="картодържач" v-model="account.user_id" id="users-select" :error="errors?.user_id?.[0]"/>

                <Button type="submit" class="btn" text="Добави"/>
            </form>

            <Load v-else />

            <p v-if="success_message" class="success__message">Успешно добавена сметка.</p>
        </div>
    </section>
</template>

<style scoped lang="scss">
.section-create-account{
    margin-block: 32px;

    .section__title{
        display: grid;
        grid-template-columns: 1fr auto 1fr;
        align-items: center;
    }

    .section__inner{
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    .section__account{
        display: flex;
        flex-direction: column;
        gap: 12px;
        width: 320px;
        align-self: center;
    }
}
</style>