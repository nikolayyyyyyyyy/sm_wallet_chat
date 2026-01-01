<script setup>
const props = defineProps({
    label:{
        type: String,
        required: true
    },
    error:{
        type: String,
        required: false
    }
});

const model = defineModel();
</script>

<template>
    <div class="input">
        <label class="input__title" for="input">
            {{ label }}
        </label>

        <input type="text" class="input__content" v-model="model">

        <p v-if="error" class="input__error">{{ error }}</p>
    </div>
</template>

<style scoped lang="scss">
.input{
    display: flex;
    flex-direction: column;
    gap: 3px;
    color: var(--c-white);

    .input__title{
        font-size: 14px;
    }

    .input__error{
        font-size: 12px;
        color: var(--c-red);
        font-weight: 500;
    }

    .input__content {
        border-radius: 8px;
        padding: 13px;
        border: 2px solid #475569;
        background: #334155;
        color: var(--c-white);
    }
}
</style>