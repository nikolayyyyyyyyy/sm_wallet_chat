<script setup lang="ts">
import Button from '@/components/Button.vue';
import GoToArrow from '@/components/GoToArrow.vue';
import InputComponent from '@/components/InputComponent.vue';
import Load from '@/components/Load.vue';
import Select from '@/components/Select.vue';
import get from '@/crud/get';
import { update } from '@/crud/update';
import { onMounted, ref } from 'vue';
import { useRouter } from 'vue-router';
const props = defineProps({
    id:{
        type: String,
        required: true
    }
});

const router = useRouter();
const account = ref();
const is_loading = ref(false);
const { getItem, getData } = get();
const currencies = ref([]);
const account_types = ref([]);
const users = ref([]);
const is_fetching = ref(false);
const { updateData } = update();
const errors = ref();
const success_message = ref(false);

const submitAccount = async () => {
    if(is_fetching.value) return;
    const form_data = new FormData();
    form_data.append('account_number', account.value.account_number);
    form_data.append('amount', account.value.amount);
    form_data.append('interest', account.value.interest);
    form_data.append('currency_id', account.value.currency_id);
    form_data.append('account_type_id', account.value.account_type_id);
    form_data.append('user_id', account.value.user_id);

    try{
        is_fetching.value = true;
        await updateData(form_data, 'accounts', props.id);
        errors.value = [];
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

onMounted(async () => {
    if(!localStorage.getItem('token')){
        router.push('/login');
        return;
    }

    is_loading.value = true;
    account.value = await getItem('accounts', props.id);

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
    <section class="section-update-account">
        <div class="section__inner shell">
            <div class="section__title">
                <GoToArrow nav-to="/accounts" />

                <h1>Промяна на смека</h1>
            </div>

            <form @submit.prevent="submitAccount" v-if="!is_loading && account" class="section__update__account custom-form">
                <InputComponent label="номер на сметка" v-model="account.account_number" :error="errors?.account_number?.[0]"/>

                <InputComponent label="наличност" v-model="account.amount" :error="errors?.amount?.[0]"/>

                <InputComponent label="лихва" v-model="account.interest" :error="errors?.interest?.[0]"/>

                <Select :options="currencies" label="валута" v-model="account.currency_id" id="select-currency"/>

                <Select :options="account_types" label="тип сметка" v-model="account.account_type_id" id="select-account-type"/>

                <Select :options="users" label="картодържач" v-model="account.user_id" id="select-user"/>

                <Button type="submit" text="Промени" class="update__btn" />
            </form>

            <Load v-else />

            <p v-if="success_message" class="success__message">Успешно променена сметка.</p>
        </div>
    </section>
</template>

<style scoped lang="scss">
.section-update-account{
    margin-block: 32px;

    .update__btn{
        width: 120px;
    }

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
    
    .section__update__account{
        display: flex;
        flex-direction: column;
        gap: 12px;
        width: 320px;
        align-self: center;
    }
}
</style>