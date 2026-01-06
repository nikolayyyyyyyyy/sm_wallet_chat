<script setup lang="ts">
import Button from '@/components/Button.vue';
import GoToArrow from '@/components/GoToArrow.vue';
import InputComponent from '@/components/InputComponent.vue';
import Load from '@/components/Load.vue';
import Select from '@/components/Select.vue';
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
const user = ref({
    profile_photo: '',
    username: '',
    email: '',
    role_id: ''
});
const { getItem } = get();
const router = useRouter();
const is_loading = ref(false);
const roles = ref([{id: 1, text: 'Админ'}, {id: 2, text: 'Потребител'}]);
const new_password = ref('');
const image_file = ref('');
const image_upload = ref();

function handleChange(event){
    const file = event.target.files[0];
    image_upload.value = file;
    image_file.value = URL.createObjectURL(file);
};

function removeImage(){
    image_upload.value = null;
    image_file.value = null;
};

const is_fetching = ref(false);
const { updateData } = update();
const errors = ref();
const success_message = ref(false);

const updateUser = async () => {
    if(is_fetching.value) return;
    const form_data = new FormData();

    form_data.append('profile_photo', image_file.value);
    form_data.append('username', user.value.username);
    form_data.append('email', user.value.email);
    form_data.append('role_id', user.value.role_id);

    if (new_password.value) {
        form_data.append('password', new_password.value);
    }

    if (image_upload.value) {
        form_data.append('profile_picture', image_upload.value);
    }

    try{
        is_fetching.value = true;
        await updateData(form_data, 'users', props.id);
        errors.value = [];
        success_message.value = true;

        setTimeout(() => {
            success_message.value = false;
        }, 3000);
    }catch(err){
        errors.value = JSON.parse(err.message).errors;
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
    user.value = await getItem('users', props.id);
    image_file.value = user.value.profile_photo;
    is_loading.value = false;
});
</script>

<template>
    <section class="section-update-user">
        <div class="section__inner shell">
            <div class="section__title">
                <GoToArrow nav-to="/users" />

                <h1>Промени потребител</h1>
            </div>

            <form @submit.prevent="updateUser" v-if="!is_loading && user" class="section__update__user custom-form">
                <label for="image">
                    <figure class="section__image image-fit">
                        <img :src="image_file ?? '/avatar.png'" alt="">

                        <div @click.stop.prevent="removeImage" class="section__remove">
                            X
                        </div>
                    </figure>

                    <input @change="handleChange" type="file" id="image" :hidden="true">
                </label>

                <InputComponent label="потребителско име" v-model="user.username" :error="errors?.username?.[0]"/>
                <InputComponent label="имейл" v-model="user.email" :error="errors?.email?.[0]"/>

                <Select :options="roles" id="select-role" v-model="user.role_id" label="роля" :error="errors?.role_id?.[0]"/>
                <InputComponent label="нова парола" v-model="new_password" :error="errors?.password?.[0]"/>
                
                <Button type="submit" text="Промени" class="update_btn" />
            </form>

            <Load v-else />

            <p v-if="success_message" class="success__message">Успешно променен потребител.</p>
        </div>
    </section>
</template>

<style scoped lang="scss">
.section-update-user{
    margin-block: 32px;

    .section__inner{
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    .update_btn{
        width: 120px;
    }

    .section__title{
        display: grid;
        grid-template-columns: 1fr auto 1fr;
        align-items: center;
    }

    .section__update__user{
        display: flex;
        flex-direction: column;
        gap: 12px;
        width: 320px;
        align-self: center;
    }

    .section__image{
        width: 100px;
        aspect-ratio:  1 / 1;
        border: 2px solid var(--c-gray);
        border-radius: 10px;
    }

    .section__remove{
        position: absolute;
        top: 5px;
        right: 5px;
        background-color: var(--c-base);
        padding: 2px 5px;
        border-radius: 20px;
        display: flex;
        align-self: center;
        justify-content: center;
        cursor: pointer;
    }
}
</style>