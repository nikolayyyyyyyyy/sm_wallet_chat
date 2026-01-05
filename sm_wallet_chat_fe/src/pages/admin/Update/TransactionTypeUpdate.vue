<script setup lang="ts">
import Button from '@/components/Button.vue';
import GoToArrow from '@/components/GoToArrow.vue';
import InputComponent from '@/components/InputComponent.vue';
import Load from '@/components/Load.vue';
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
const transaction_type = ref();
const is_loading = ref(false);
const router = useRouter();
const { getItem } = get();
const { updateData } = update();
const is_fetching = ref(false);
const error = ref('');
const success_message = ref(false);

const handleUpdate = async () => {
    if(is_fetching.value) return;
    const form_data = new FormData();
    form_data.append('transaction_type', transaction_type.value.transaction_type);

    try{
        is_fetching.value = true;
        await updateData(form_data, 'transaction-types', props.id);
        error.value = '';
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

onMounted(async () => {
    if(!localStorage.getItem('token')){
        router.push('/login');
        return;
    }

    is_loading.value = true;
    transaction_type.value = await getItem('transaction-types', props.id);
    is_loading.value = false;
});
</script>

<template>
    <section class="section-transaction-type-update">
        <div class="section__inner shell">
            <div class="section__title">
                <GoToArrow nav-to="/transaction-types" />

                <h1>Промени тип на транзакция</h1>
            </div>

            <form @submit.prevent="handleUpdate" v-if="!is_loading && transaction_type" class="section__update__transaction__type custom-form">
                <InputComponent label="тип транзакция" v-model="transaction_type.transaction_type" :error/>

                <Button type="submit" text="Промени" class="btn"/>
            </form>

            <Load v-else />

            <p v-if="success_message" class="success__message">Успешно променена тип транзакция.</p>
        </div>
    </section>
</template>

<style scoped lang="scss">
.section-transaction-type-update{
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

    .btn{
        width: 120px;
        align-self: center;
    }

    .section__update__transaction__type{
        display: flex;
        flex-direction: column;
        gap: 12px;
        width: 320px;
        align-self: center;
    }
}
</style>