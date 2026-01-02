<script setup>
import { ref } from 'vue';
const props = defineProps({
    elementId: {
        type: Number,
        required: true
    },
    isLiked: {
        type: Boolean,
        required: false
    }
});
const isLikeFilled = ref(props.isLiked);
const isFetchLoading = ref(false);

const likeElement = async () => {
    if (isFetchLoading.value) {
        return;
    }

    const wasLiked = isLikeFilled.value;
    isLikeFilled.value = !isLikeFilled.value;
    isFetchLoading.value = true;

    try {
        await fetch('http://127.0.0.1:8000/api/favorites', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${localStorage.getItem('token')}`
            },
            body: JSON.stringify({
                liked_user_id: props.elementId
            })
        });

    } catch (err) {
        isLikeFilled.value = wasLiked;
    } finally {
        isFetchLoading.value = false;
    }
};

</script>

<template>
    <svg @click="likeElement" width="30" height="30" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32">
        <path :fill="isLikeFilled ? '#ffd54f' : 'transparent'" stroke="#FFF"
            d="m16 24l10 6l-4-10l8-8l-10-.032L16 2l-4 10H2l8 8l-4 10Z" />
    </svg>
</template>

<style scoped lang="scss">
svg {
    stroke: #FFF;
}
</style>