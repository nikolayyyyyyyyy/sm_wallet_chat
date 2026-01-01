<script setup>
import Account from '@/components/Account.vue';
import Button from '@/components/Button.vue';
import FavoritePopup from '@/components/FavoritePopup.vue';
import InputComponent from '@/components/InputComponent.vue';
import NoResultFount from '@/components/NoResultFount.vue';
import UserActions from '@/components/UserActions.vue';
import MyAccounts from '@/sections/MyAccounts.vue';
import { ref } from 'vue';

defineProps({
    user:{
        type: Object,
        required: true
    }
});
const show_popup = ref(false);
const search_user = ref();
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

            <FavoritePopup v-model="show_popup" title="Намери приятели">
                <InputComponent class="search_input_user" label="имейл" v-model="search_user" />

                <Button class="search_btn" text="Намери"/>
            </FavoritePopup>
        </div>
    </section>
</template>

<style scoped lang="scss">
.section__inner{
    display: flex;
    flex-direction: column;
    gap: 20px;
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
    }
    .err{
        margin-block: 32px;
    }

    .search_input_user{
        width: 60%;
    }

    .search_btn{
        width: 300px;
        margin-top: 30px;
    }
}
</style>