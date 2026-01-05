<script setup lang="ts">
import Button from '@/components/Button.vue';
import GoToArrow from '@/components/GoToArrow.vue';
import InputComponent from '@/components/InputComponent.vue';
import { store } from '@/crud/create';
import { onMounted, ref } from 'vue';
import { useRouter } from 'vue-router';
const router = useRouter();
const currency = ref();
const error = ref();
const success_message = ref(false);
const is_fetching = ref(false);
const { create } = store();

const storeCurrency = async () => {
    if(is_fetching.value) return;

    try{
        is_fetching.value = true;
        await create({currency: currency.value}, 'currencies');
        error.value = '';
        success_message.value = true;
        currency.value = '';
        setTimeout(() => {
            success_message.value = true;
        }, 3000);
    }catch(err){
        error.value = JSON.parse(err.message).errors.currency[0];
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
    <section class="section-create-currency">
        <div class="section__inner shell">
            <div class="section__title">
                <GoToArrow nav-to="/" />

                <h1>Добавяне на валута</h1>
            </div>

            <form @submit.prevent="storeCurrency" class="section__currency custom-form">
                <InputComponent label="валута" v-model="currency" :error/>

                <Button type="submit" text="Добави" class="btn" />
            </form>

            <p v-if="success_message" class="success__message">
                Успешно добавена валута.
            </p>
        </div>
    </section>
</template>

<style scoped lang="scss">
.section-create-currency{
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

    .section__currency{
        display: flex;
        flex-direction: column;
        gap: 12px;
        width: 320px;
        align-self: center;
    }

    .btn{
        width: 200px;
        align-self: center;
    }
}
</style>