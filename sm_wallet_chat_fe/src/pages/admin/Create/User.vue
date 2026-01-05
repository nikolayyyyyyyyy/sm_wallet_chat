<script setup lang="ts">
import Button from '@/components/Button.vue';
import GoToArrow from '@/components/GoToArrow.vue';
import InputComponent from '@/components/InputComponent.vue';
import Load from '@/components/Load.vue';
import Select from '@/components/Select.vue';
import { store } from '@/crud/create';
import { onMounted, ref } from 'vue';
import { useRouter } from 'vue-router';
const router = useRouter();
const { create } = store();
const errors = ref();
const success_message = ref(false);
const roles = ref([{id: 1, text: 'Админ'}, {id: 2, text: 'Потребител'}]);
const is_loading = ref();
const user = ref({
    username: '',
    email: '',
    password: '',
    role_id: ''
});

const is_fetching = ref(false);
const storeUser = async () => {
    if(is_fetching.value) return;

    try{
        is_fetching.value = true;
        await create(user.value, 'users');
        errors.value = [];
        Object.keys(user.value).forEach(u => user.value[u] = '');
        success_message.value = true;

        setTimeout(() => {
            success_message.value = false;
        }, 3000);
    }catch(err){
        errors.value = JSON.parse(err.message).errors;
    }finally{
        is_fetching.value = false;
    }
}

onMounted(() =>{
    if(!localStorage.getItem('token')){
        router.push('/login');
        return;
    }
});
</script>

<template>
    <section class="section-create-user">
        <div class="section__inner shell">
            <div class="section__title">
                <GoToArrow nav-to="/" />

                <h1>Добавяне на потребител</h1>
            </div>

            <form @submit.prevent="storeUser" v-if="!is_loading" class="section__user custom-form">
                <InputComponent label="username" v-model="user.username" :error="errors?.username?.[0]"/>

                <InputComponent label="имейл" v-model="user.email" :error="errors?.email?.[0]"/>

                <InputComponent label="парола" v-model="user.password" :error="errors?.password?.[0]"/>

                <Select :options="roles" label="роля" v-model="user.role_id" id="role-select" :error="errors?.role_id?.[0]"/>

                <Button type="submit" text="Добави" class="btn" />
            </form>

            <Load v-else />

            <p v-if="success_message" class="success__message">Успешно добавен потребител.</p>
        </div>
    </section>
</template>

<style scoped lang="scss">
.section-create-user{
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

    .section__user{
        display: flex;
        flex-direction: column;
        gap: 12px;
        align-self: center;
        width: 320px;
    }

    .btn{
        width: 120px;
    }
}
</style>