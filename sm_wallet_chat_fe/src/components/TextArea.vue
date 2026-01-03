<script setup>
defineProps({
    label: {
        type: String,
        required: true
    },
    error: {
        type: String
    }
});

const model = defineModel();
</script>

<template>
    <div class="textarea-input">
        <label>
            <p class="section__title">{{ label }}</p>
        </label>

        <textarea v-model="model" name="note-textarea" rows="5" id="note-textarea"></textarea>

        <p v-if="error" class="input__error">{{ error }}</p>
    </div>
</template>

<style scoped lang="scss">
.textarea-input {
    width: 100%;
    display: flex;
    flex-direction: column;
    gap: 4px;

    .section__title {
        font-size: 13px;
        font-weight: 500;
        color: var(--c-gray);
    }

    textarea {
        color: var(--c-gray);
        background-color: #334155;
        border: 1px solid #475569;
        border-radius: 8px;
        padding: 13px;
        font-size: 15px;
        resize: none;
    }

    .input__error{
        font-size: 12px;
        color: var(--c-red);
        font-weight: 500;
    }
}
</style>