<script setup lang="ts">
import Button from '@/components/Button.vue';
import InputComponent from '@/components/InputComponent.vue';
import auth from '@/crud/auth';
import { onMounted, ref } from 'vue';
import { useRouter } from 'vue-router';

const { register } = auth();
const router = useRouter();
const user = ref({
    username: '',
    email: '',
    password: ''
});
const errors = ref();
const registerUser = async () => {
    try{
        await register(user.value);
        errors.value = [];
        router.push('/login');
    }catch(err){
        errors.value = JSON.parse(err.message).errors;
    }
}

onMounted(() => {
    if(localStorage.getItem('token')){
        router.push('/');
        return;
    }
});
</script>

<template>
    <section class="section-register">
        <div class="section__head">
            <h1 class="section__title">FinTech</h1>

            <p class="section__subtitle">Регистрация в системата.</p>
        </div>

        <form @submit.prevent="registerUser" class="section__register custom-form">
            <InputComponent label="username" v-model="user.username" :error="errors?.username?.[0]"/>

            <InputComponent label="имейл" v-model="user.email" :error="errors?.email?.[0]"/>

            <InputComponent label="парола" v-model="user.password" :error="errors?.password?.[0]"/>

            <div class="form-bottom">
                    <p class="text">Имаш акаунт?</p>
                    <a @click.prevent="router.push('/login')" class="text-colored">Вход.</a>
            </div>

            <Button text="Регистрация" class="btn" />
        </form>
    </section>
</template>

<style scoped lang="scss">
.section-register{
    display: flex;
    flex-direction: column;
    gap: 30px;
    margin-block: 32px;

    .btn{
        width: 200px;
    }

    .section__head{
        display: flex;
        flex-direction: column;
        gap: 4px;
        cursor: default;
        color: var(--c-gray);
        align-items: center;
    }

    .section__register{
        display: flex;
        flex-direction: column;
        gap: 10px;
        width: 350px;
        margin: 0 auto;
    }
}
</style>