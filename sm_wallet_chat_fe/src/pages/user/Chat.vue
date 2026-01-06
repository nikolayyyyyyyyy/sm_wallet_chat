<script setup>
import GoToArrow from '@/components/GoToArrow.vue';
import InputComponent from '@/components/InputComponent.vue';
import Load from '@/components/Load.vue';
import get from '@/crud/get';
import { onMounted, ref } from 'vue';
import { echo } from '@/echo';
import { useRouter } from 'vue-router';
import Button from '@/components/Button.vue';
const router = useRouter();
const props = defineProps({
    id:{
        required: true
    }
});

const messages = ref([]);
const message = ref();
const is_loading = ref();
const favorite_user = ref();
const { getItem } = get();
const current_user = ref();

const sendMessage = async () => {
    if(message.value == undefined || message.value == '') return;

    const response = await fetch('http://127.0.0.1:8000/api/messages/' + props.id,{
        method: 'POST',
        headers:{
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${localStorage.getItem('token')}`
        },
        body: JSON.stringify({message: message.value})
    })
    message.value = '';
    const new_message = await response.json();
    messages.value.push(new_message);
};

onMounted(async () => {
    if(!localStorage.getItem('token')){
        router.push('/login');
        return;
    }

    is_loading.value = true;

    favorite_user.value = await getItem('users', props.id);
    current_user.value = await (await fetch('http://127.0.0.1:8000/api/user',{
        method: 'GET',
        headers:{
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${localStorage.getItem('token')}`
        }
    })).json();

    const response = await fetch('http://127.0.0.1:8000/api/messages/' + props.id,{
        method: 'GET',
        headers:{
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${localStorage.getItem('token')}`
        },
    });

    messages.value = await response.json();
    echo.private(`chat.${current_user.value.id}`)
        .subscribed(() => {
            console.log('Successfully subscribed to chat channel');
        }).error((err) => {
            console.error('Subscription error:', err);
        }).listen('MessageSent', (e) => {
            messages.value.push(e.message);
        });

    is_loading.value = false;
});
</script>

<template>
    <section class="section-chat">
        <div class="section__inner shell">
            <GoToArrow nav-to="/favorites" />

            <div v-if="!is_loading && favorite_user && current_user" class="section__chat">
                <div class="section__chat__favorite__user custom-form">
                    <figure class="favorite__user__top__image image-fit">
                        <img :src="favorite_user.profile_photo ?? '/avatar.png'" alt="">
                    </figure>

                    <p>{{ favorite_user.username }}</p>
                </div>

                <div class="section__messages custom-form">
                    <div v-for="message in messages" class="message" :class="{ sender: message.sender_id == current_user.id, receiver: message.sender_id != current_user.id }">
                        <p>
                            {{ message.message }}
                        </p>

                        <p v-if="message.sender_id == current_user.id" class="date-sender">
                           send: {{ new Date(message.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }) }}
                        </p>
                        <p v-else class="date-receiver">
                           send: {{ new Date(message.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }) }}
                        </p>
                    </div>
                </div>

                <form class="send_message" @submit.prevent="sendMessage">
                    <InputComponent class="message_text" v-model="message"/>

                    <Button type="submit" text=">" :text_send_button="true" />
                </form>
            </div>

            <Load v-else />
        </div>
    </section>
</template>

<style scoped lang="scss">
.section-chat{
    margin-block: 32px;

    .typing-indicator {
        font-size: 12px;
        opacity: .7;
    }

    .date-sender,
    .date-receiver{
        font-size: 12px;
        color: var(--c-gray);
        opacity: 0.6;
    }

    .date-sender{
        margin-left: auto;
    }

    .send_message{
        display: flex;
        gap: 4px;

        .message_text{
            flex-grow: 1;
        }
    }

    .section__inner{
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    .section__chat{
        display: flex;
        flex-direction: column;
        gap: 12px;
        width: 60%;
        align-self: center;
    }

    .section__chat__favorite__user{
        display: flex;
        align-items: center;
        gap: 12px;
        color: var(--c-base);
        font-weight: 600;

        .favorite__user__top__image{
            width: 50px;
            aspect-ratio: 1 / 1;
            border: 2px solid var(--c-base);
            border-radius: 10px;
        }
    }

    .section__messages{
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        gap: 10px;
        height: 350px;

        .message{
            display: flex;
            flex-direction: column;
            padding: 3px 6px;
            justify-content: flex-end;
            width: fit-content;
            background: var(--c-blue);
            color: var(--c-white);
            font-size: 16px;
            font-weight: 300 !important;
        }

        .sender{
            border-radius: 10px 10px 0 10px;
            align-self: flex-end;
        }

        .receiver{
            border-radius: 10px 10px 10px 0;
        }
    }
}
</style>