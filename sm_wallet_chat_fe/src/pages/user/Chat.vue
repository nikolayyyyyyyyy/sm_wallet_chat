<!-- <script setup>
import { onMounted, ref } from 'vue';
import { echo } from '../../echo';
const messages = ref();
const user = ref();
const message = ref();
const receiver_id = ref();

const sendMessage = async () => {
    if(!message.value) return;
    
    await fetch('http://127.0.0.1:8000/api/messages',{
        method: 'POST',
        headers:{
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${localStorage.getItem('token')}`
        },
        body: JSON.stringify({message: message.value, receiver_id: receiver_id.value})
    })
};

onMounted( async () => {
    user.value = await( await fetch('http://127.0.0.1:8000/api/user',{
        method: 'GET',
        headers:{
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${localStorage.getItem('token')}`
        }
    })).json();

    const response = await fetch('http://127.0.0.1:8000/api/messages',{
        method: 'GET',
        headers:{
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${localStorage.getItem('token')}`
        },
    });

    messages.value = await response.json();
    receiver_id.value = messages.value[0].receiver_id;

    const channel = echo.private(`chat.${user.value.id}`);

    channel.subscribed(() => {
        console.log('Successfully subscribed to chat channel');
    });

    channel.error((err) => {
        console.error('Subscription error:', err);
    });

    channel.listen('MessageSent', (e) => {
        console.log('Received message:', e.message);
    });
});
</script>

<template>
    <div class="section-chat">
        <div v-for="message in messages" class="message">
            <p v-if="message.sender_id == user.id" class="sender">
                {{ message.message }}
            </p>
            <p v-else class="receiver">
                {{ message.message }}
            </p>
        </div>
        <form @submit.prevent="sendMessage">
            <input type="text" v-model="message">

            <input type="submit">
        </form>
    </div>
</template>

<style scoped lang="scss">
*{
    padding: 0;
    margin: 0;
}
.section-chat{
    display: flex;
    flex-direction: column;
    gap: 10px;
    width: 300px;
    background-color: cadetblue;

    .sender{
        display: flex;
        justify-content: flex-end;
    }
}
</style> -->