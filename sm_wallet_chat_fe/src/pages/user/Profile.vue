<script setup>
import Button from '@/components/Button.vue';
import GoToArrow from '@/components/GoToArrow.vue';
import InputComponent from '@/components/InputComponent.vue';
import Load from '@/components/Load.vue';
import auth from '@/crud/auth';
import { _delete } from '@/crud/delete';
import { update } from '@/crud/update';
import { onMounted, ref } from 'vue';
import { useRouter } from 'vue-router';

const user = ref();
const is_loading = ref(false);
const new_password = ref();
const is_fetching = ref(false);
const { updateData } = update();
const file_upload = ref();
const file_image_url = ref();
const errors = ref([]);
const success_message = ref(false);
const { deleteItem } = _delete();
const { logout } = auth();
const router = useRouter();

const deleteUSer = async () => {
    await deleteItem('users', user.value.id);
    await logout();
    router.push('/login');
}

function changeImage(e){
    const file = e.target.files[0];
    file_upload.value = file;
    file_image_url.value = URL.createObjectURL(file);
}

function removeImage(){
    file_upload.value = null;
    file_image_url.value = null;
}

const updateInfo = async () => {
    if(is_fetching.value) return;
    const form_data = new FormData();
    form_data.append('username', user.value.username);
    form_data.append('email', user.value.email);
    if (new_password.value) {
        form_data.append('password', new_password.value);
    }

    if (file_upload.value) {
        form_data.append('profile_picture', file_upload.value);
    }

    is_fetching.value = true;
    try{
        await updateData(form_data, 'users', user.value.id);
        errors.value = [];
        success_message.value = true;

        setTimeout(() => {
            success_message.value = false;
        }, 4000);
    }catch(err){
        errors.value = JSON.parse(err.message).errors;
    }finally{
        is_fetching.value = false;
        new_password.value = '';
    }
};

onMounted(async () => {
    if(!localStorage.getItem('token')){
        router.push('/login');
        return;
    }
    
    is_loading.value = true;
    user.value = await (await fetch('http://127.0.0.1:8000/api/user',{
        method: 'GET',
        headers:{
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${localStorage.getItem('token')}`
        }
    })).json();
    file_image_url.value = user.value.profile_photo;
    is_loading.value = false;
});
</script>

<template>
    <section class="section-update-profile">
        <div class="section__inner shell">
            <div class="section__title">
                <GoToArrow nav-to="/"/>

                <h1>Промяна на профила</h1>
            </div>

            <div v-if="!is_loading && user" class="section__user">
                <label for="user_image" class="user__profile__photo">
                    <figure class="section__image image-fit">
                        <img :src="file_image_url ?? '/avatar.png'" alt="">
                    </figure>
                    <p v-if="file_image_url" @click.stop.prevent="removeImage" class="remove__photo">X</p>

                    <input @change="changeImage" type="file" id="user_image" hidden>
                </label>

                <div class="user__info">
                    <InputComponent :error="errors?.username?.[0]" label="username" v-model="user.username" />

                    <InputComponent :error="errors?.email?.[0]" label="Имейл" v-model="user.email" />

                    <InputComponent :error="errors?.password?.[0]" label="нова парола" v-model="new_password" />

                    <div class="info__buttons">
                        <Button @click="updateInfo" text="Промени" />

                        <Button @click="deleteUSer" text="Изтрий профил" :delete_btn="true" />
                    </div>
                </div>
            </div>

            <Load v-else />

            <p v-if="success_message" class="success__message">Успешно променихте профила</p>
        </div>
    </section>
</template>

<style scoped lang="scss">
.section-update-profile{
    margin-block: 32px;

    .info__buttons{
        display: flex;
        align-items: center;
        gap:30px;
    }

    .user__info{
        display: flex;
        flex-direction: column;
        gap: 8px;
        width: 40%;
    }

    .section__inner{
        display: flex;
        flex-direction: column;
        gap: 32px;
    }

    .section__title{
        display: grid;
        grid-template-columns: 1fr auto 1fr;
        align-items: center;
    }

    .section__user{
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 40px;
    }

    .user__profile__photo{
        position: relative;
        width: 20%;

        .remove__photo{
            position: absolute;
            top: 10px;
            right: 10px;
            background: var(--c-base);
            padding: 5px 10px;
            border-radius: 50%;
            cursor: pointer;
        }
    }

    .section__image{
        width: 100%;
        aspect-ratio: 1 / 1;
        border: 2px solid var(--c-base);
        border-radius: 10px;
    }
}
</style>