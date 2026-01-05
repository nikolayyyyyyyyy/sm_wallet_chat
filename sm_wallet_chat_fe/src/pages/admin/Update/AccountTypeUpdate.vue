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
const router = useRouter();
const account_type = ref();
const is_loading = ref(false);
const is_fetching = ref(false);
const { getItem } = get();
const error = ref('');
const success_message = ref(false);
const { updateData } = update();

const handleUpdate = async () => {
    if(is_fetching.value) return;

    const form_data = new FormData();
    form_data.append('account_type', account_type.value.account_type);

    try{
        is_fetching.value = true;
        await updateData(form_data, 'account-types', props.id);
        error.value = '';
        success_message.value = true;

        setTimeout(() => {
            success_message.value = false;
        }, 3000);
    }catch(err){
        error.value = JSON.parse(err.message).errors.account_type[0];
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
    account_type.value = await getItem('account-types', props.id);
    is_loading.value = false;
});
</script>

<template>
    <section class="section-account-type-update">
        <div class="section__inner shell">
            <div class="section__title">
                <GoToArrow nav-to="/account-types" />

                <h1>Промени тип смека</h1>
            </div>

            <form @submit.prevent="handleUpdate" v-if="!is_loading && account_type" class="section__account__type__update custom-form">
                <InputComponent label="тип сметка" v-model="account_type.account_type" :error/>

                <Button text="Промени" class="update__btn" />
            </form>

            <Load v-else />

            <p v-if="success_message" class="success__message">Успешно променена тип сметка.</p>
        </div>
    </section>
</template>

<style scoped lang="scss">
.section-account-type-update{
    margin-block: 32px;

    .section__inner{
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    .update__btn{
        width: 120px;
    }

    .section__title{
        display: grid;
        grid-template-columns: 1fr auto 1fr;
        align-items: center;
    }

    .section__account__type__update{
        display: flex;
        flex-direction: column;
        gap: 12px;
        width: 320px;
        align-self: center;
    }
}
</style>