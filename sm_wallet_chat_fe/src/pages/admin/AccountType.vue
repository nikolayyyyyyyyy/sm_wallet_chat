<script setup lang="ts">
import Button from '@/components/Button.vue';
import GoToArrow from '@/components/GoToArrow.vue';
import InputComponent from '@/components/InputComponent.vue';
import { store } from '@/crud/create';
import { ref } from 'vue';

const account_type = ref();
const is_fetching = ref(false);
const success_message = ref(false);
const error = ref('');
const { create } = store();

const store_account_type = async () => {
    if(is_fetching.value) return;

    try{
        is_fetching.value = true;
        await create({account_type: account_type.value}, 'account-types');
        error.value = '';
        success_message.value = true;
        account_type.value = '';
        setTimeout(() => {
            success_message.value = false;
        }, 3000);
    }catch(err){
        error.value = JSON.parse(err.message).errors.account_type[0];
    }finally{
        is_fetching.value = false;
    }
};
</script>

<template>
    <section class="section-create-account-type">
        <div class="section__inner shell">
            <div class="section__title">
                <GoToArrow nav-to="/" />

                <h1>Добавяне на тип на сметка</h1>
            </div>

            <form @click.prevent="store_account_type" class="section__account__type custom-form">
                <InputComponent label="тип на сметка" v-model="account_type" :error/>

                <Button type="submit" text="Добави" class="btn" />
            </form>

            <p v-if="success_message" class="success__message">Успешно добавена тип транзакция.</p>
        </div>
    </section>
</template>

<style scoped lang="scss">
.section-create-account-type{
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

    .section__account__type{
        display: flex;
        flex-direction: column;
        gap: 12px;
        width: 320px;
        align-self: center;
    }

    .btn{
        width: 200px;
    }
}
</style>