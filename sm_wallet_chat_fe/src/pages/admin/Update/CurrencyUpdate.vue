<script setup>
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
        type: String,
        required: true
    }
});

const router = useRouter();
const currency = ref({
    currency: ''
});
const error = ref('');
const { getItem } = get();
const is_loading = ref(false);
const is_fetching = ref(false);
const { updateData } = update();
const success_message = ref(false);

const handleUpdate = async () => {
    if(is_fetching.value) return;

    const form_data = new FormData();
    form_data.append('currency', currency.value.currency);

    try{
        is_fetching.value = true;
        await updateData(form_data, 'currencies', props.id);
        error.value = '';
        success_message.value = true;

        setTimeout(() => {
            success_message.value = false;
        }, 3000);
    }catch(err){
        error.value = JSON.parse(err.message).errors.currency[0];
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
    currency.value = await getItem('currencies', props.id);
    is_loading.value = false;
});
</script>

<template>
    <section class="section-update-currency">
        <div class="section__inner shell">
            <div class="section__title">
                <GoToArrow nav-to="/currencies" />

                <h1>Промени валута</h1>
            </div>

            <form @submit.prevent="handleUpdate" v-if="!is_loading" class="section__currency custom-form">
                <InputComponent label="валута" v-model="currency.currency" :error/>

                <Button type="submit" text="Промени" class="update__btn" />
            </form>
            
            <Load v-else />
            
            <p v-if="success_message" class="success__message">Успешно промена валута.</p>
        </div>
    </section>
</template>

<style scoped lang="scss">
.section-update-currency{
    margin-block: 32px;

    .update__btn{
        width: 120px;
        align-self: center;
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

    .section__currency{
        display: flex;
        flex-direction: column;
        gap: 12px;
        width: 320px;
        align-self: center;
    }
}
</style>