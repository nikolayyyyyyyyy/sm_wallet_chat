<script setup>
defineProps({
    text: {
        String,
        required: true
    },
    delete_btn: {
        type: Boolean,
        required: false
    },
    type: {
        type: String,
        required: false
    }
});
</script>

<template>
    <button class="btn" :type :class="{ 'btn--delete': delete_btn }">
        {{ text }}
    </button>
</template>

<style scoped>
.btn {
    width: 100%;
    align-self: center;
    font-size: 16px;
    color: var(--c-white);
    border-radius: 9999px;
    background: var(--c-blue);
    padding-block: 15px;
    border: 0;
    cursor: pointer;
}

.btn--delete {
    background-color: var(--c-red);
}
</style>