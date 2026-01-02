<script setup>
import Account from '@/components/Account.vue';
import Button from '@/components/Button.vue';
import FavoritePopup from '@/components/FavoritePopup.vue';
import InputComponent from '@/components/InputComponent.vue';
import Load from '@/components/Load.vue';
import NoResultFount from '@/components/NoResultFount.vue';
import UserActions from '@/components/UserActions.vue';
import MyAccounts from '@/sections/MyAccounts.vue';
import User from '@/components/User.vue';
import { ref } from 'vue';
defineProps({
    user:{
        type: Object,
        required: true
    }
});

const is_loading = ref(false);
const is_fetching = ref(false);
const show_popup = ref(false);
const search_user = ref({
    email: ''
});
const error = ref('');
const found_user = ref(null);
const findUser = async () => {
    if(is_fetching.value) return;
    is_fetching.value = true;
    is_loading.value = true;

    const response = await fetch(`http://127.0.0.1:8000/api/users/check-email`, {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${localStorage.getItem('token')}`
        },
        body: JSON.stringify({ email: search_user.value.email })
    });

    if(response.ok){
        found_user.value = await response.json();
        error.value = '';
    }else {
        const err = await response.json();
        error.value = err.errors;
    }
    is_loading.value = false;
    is_fetching.value = false;
};

function clearForm(){
    found_user.value = null;
    search_user.value.email = '';
    error.value = '';
}
</script>

<template>
    <section class="section-user">
        <div class="section__inner shell">
            <div class="user__info custom-form">
                <figure class="user__image image-fit">
                    <img :src="user.profile_photo ?? '/avatar.png'" >
                </figure>
                <p>{{ user.username }}</p>
            </div>

            <MyAccounts v-if="user.accounts.length > 0"
                :total_price="user.accounts.reduce((t, c) => t + Number(c.amount), 0)">
                <Account v-for="(account, index) in user.accounts"
                     :account :class="{ light: index % 2 == 0, gray: index % 2 == 1 }"/>
            </MyAccounts>

            <NoResultFount v-else class="err" text="Нямате акаунти за момента." />

            <UserActions v-model="show_popup" />

            <FavoritePopup @empty-model-value="clearForm" v-model="show_popup" title="Намери приятели">
                <InputComponent v-if="!is_loading" class="search_input_user" label="имейл" v-model="search_user.email" />

                <User v-if="found_user && !is_loading && !error" :user="found_user" />
                
                <p v-if="error?.email && !is_loading" class="error__message">{{ error.email[0] }}</p>

                <Button v-if="!is_loading" @click="findUser" class="search_btn" text="Намери"/>

                <Load v-if="is_loading" />
            </FavoritePopup>
        </div>
    </section>
</template>

<style scoped lang="scss">
.section__inner{
    display: flex;
    flex-direction: column;
    gap: 20px;

    .error__message{
        font-size: 12px;
        color: var(--c-red);
        font-weight: 600;
    }

    .user__info{
        display: flex;
        align-items: center;
        gap: 10px;
        color: var(--c-gray);

        .user__image{
            width: 50px;
            aspect-ratio: 1 / 1;
            border: 1px solid var(--c-base);
            border-radius: 10px;
        }

        p{
            cursor: default;
        }
    }
    .err{
        margin-block: 32px;
    }

    .search_input_user{
        width: 60%;
    }

    .search_btn{
        width: 300px;
        margin-top: 10px;
    }
}
</style>