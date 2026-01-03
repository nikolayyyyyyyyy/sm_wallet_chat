<script setup>
defineProps({
    label: {
        type: String,
        reqired: true
    },
    id: {
        type: String,
        required: true
    },
    options: {
        type: Array,
        required: true
    },
    error: {
        type: String,
        required: false
    },
});

const model = defineModel();
</script>

<template>
    <div class="select-container">
        <label :for="id">{{ label }}</label>
        <select :id class="select" v-model="model">
            <option v-for="option in options" :value="option.id">
                {{ option.text }}
            </option>
        </select>

        <p v-if="error" class="input__error">{{ error }}</p>    
    </div>
</template>

<style scoped lang="scss">
.select-container {
    display: flex;
    flex-direction: column;
    gap: 3px;

    label {
        font-size: 13px;
        font-weight: 500;
        color: var(--c-white);
    }

    .select {
        border-radius: 8px;
        padding: 13px;
        flex-shrink: 0;
        border: 1px solid #475569;
        background: #334155;
        color: var(--c-white);
    }

    .input__error{
        font-size: 12px;
        color: var(--c-red);
        font-weight: 500;
    }
}
</style>