<script setup>
import Button from '@/components/Button.vue';
import InputComponent from '@/components/InputComponent.vue';
import auth from '@/crud/auth';
import { onMounted, ref } from 'vue';
import { useRouter } from 'vue-router';
const router = useRouter();

const user = ref({});
const { login } = auth();
const errors = ref([]);
const invalid_credentials = ref(false);

const loginUser = async () => {
    try{
        await login(user.value);
        errors.value = [];
        router.push('/');
    }catch(err){
        if(JSON.parse(err.message).errors){
            errors.value = JSON.parse(err.message).errors;
        }else {
            errors.value = [];
            invalid_credentials.value = true;
            setTimeout(() =>{
                invalid_credentials.value = false;
            }, 5000)
        }
    }
};

onMounted(() => {
    if(localStorage.getItem('token')){
        router.push('/');
        return;
    }
});
</script>

<template>
    <section class="section-login">
        <div class="section__head">
            <h1 class="section__title">FinTech</h1>
            <p class="section__subtitle">Вход в системата.</p>
        </div>

        <form @submit.prevent="loginUser" class="section__form custom-form">
            <InputComponent label="имейл" v-model="user.email" :error="errors?.email?.[0]" />
            
            <InputComponent label="парола" v-model="user.password" :error="errors?.password?.[0]"/>

            <div class="form-bottom">
                    <p class="text">Нямаш акаунт?</p>
                    <a @click.prevent="router.push('/register')" class="text-colored">Регистрирай се.</a>
            </div>

            <Button class="btn" text="Влез" />
        </form>

        <p v-if="invalid_credentials" class="invavalid_credentials_err">
            Невалидни данни.
        </p>
    </section>
</template>

<style scoped lang="scss">
.section-login{
    display: flex;
    flex-direction: column;
    gap: 30px;
    margin-block: 32px !important;

    .section__head{
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 3px;
        color: var(--c-gray);
        cursor: default;
    }

    .section__form{
        display: flex;
        flex-direction: column;
        gap: 10px;
        width: 350px;
        margin: 0 auto;
    }

    .invavalid_credentials_err{
        width: fit-content;
        background: var(--c-red);
        padding: 10px;
        border-radius: 10px;
        color: var(--c-white);
        align-self: center;
    }

    .btn{
        width: 150px;
    }

    .form-bottom {
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 11.9px;
        font-weight: 400;
        gap: 3px;

        .text {
            color: #94A3B8;
        }

        .text-colored {
            color: #818CF8;
        }

        .text-colored:hover {
            cursor: pointer;
        }
    }
}
</style>