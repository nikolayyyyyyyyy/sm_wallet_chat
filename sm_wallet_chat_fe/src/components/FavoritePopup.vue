<script setup>
import { onMounted, onBeforeUnmount } from 'vue'
const props = defineProps({
    modelValue: {
        type: Boolean,
        default: false
    },
    title: {
        type: String,
        required: false
    }
})

const emit = defineEmits(['update:modelValue', 'emptyModelValue'])

const close = () => {
    emit('update:modelValue', false)
    emit('emptyModelValue');
}

const handleKeydown = (e) => {
    const cropperOverlay = document.querySelector('.cropper-overlay')
    if (cropperOverlay) return;

    if (e.key === 'Escape') {
        close();
    }
}

const handleClickOutside = (e) => {
    const cropperOverlay = document.querySelector('.cropper-overlay')
    const popup = document.querySelector('.popup')

    if (cropperOverlay) return;

    if (popup && !popup.contains(e.target)) {
        close();
    }
}

onMounted(() => {
    document.addEventListener('keydown', handleKeydown)
    document.addEventListener('mousedown', handleClickOutside)
})

onBeforeUnmount(() => {
    document.removeEventListener('keydown', handleKeydown)
    document.removeEventListener('mousedown', handleClickOutside)
})
</script>

<template>
    <div class="popup" :class="{ open: props.modelValue, 'without-border': title == null }">
        <div class="popup__head">
            <div class="popup__head-inner">
                <h1 v-if="title">
                    {{ title }}
                </h1>

                <div class="popup__close" @click="close">
                    <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="20" height="20" viewBox="0 0 48 48">
                        <linearGradient id="hbE9Evnj3wAjjA2RX0We2a_OZuepOQd0omj_gr1" x1="7.534" x2="27.557" y1="7.534"
                            y2="27.557" gradientUnits="userSpaceOnUse">
                            <stop offset="0" stop-color="#f44f5a"></stop>
                            <stop offset=".443" stop-color="#ee3d4a"></stop>
                            <stop offset="1" stop-color="#e52030"></stop>
                        </linearGradient>
                        <path fill="url(#hbE9Evnj3wAjjA2RX0We2a_OZuepOQd0omj_gr1)"
                            d="M42.42,12.401c0.774-0.774,0.774-2.028,0-2.802L38.401,5.58c-0.774-0.774-2.028-0.774-2.802,0	L24,17.179L12.401,5.58c-0.774-0.774-2.028-0.774-2.802,0L5.58,9.599c-0.774,0.774-0.774,2.028,0,2.802L17.179,24L5.58,35.599	c-0.774,0.774-0.774,2.028,0,2.802l4.019,4.019c0.774,0.774,2.028,0.774,2.802,0L42.42,12.401z">
                        </path>
                        <linearGradient id="hbE9Evnj3wAjjA2RX0We2b_OZuepOQd0omj_gr2" x1="27.373" x2="40.507" y1="27.373"
                            y2="40.507" gradientUnits="userSpaceOnUse">
                            <stop offset="0" stop-color="#a8142e"></stop>
                            <stop offset=".179" stop-color="#ba1632"></stop>
                            <stop offset=".243" stop-color="#c21734"></stop>
                        </linearGradient>
                        <path fill="url(#hbE9Evnj3wAjjA2RX0We2b_OZuepOQd0omj_gr2)"
                            d="M24,30.821L35.599,42.42c0.774,0.774,2.028,0.774,2.802,0l4.019-4.019	c0.774-0.774,0.774-2.028,0-2.802L30.821,24L24,30.821z">
                        </path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="popup__inner">
            <slot />
        </div>
    </div>
</template>

<style scoped lang="scss">
.popup {
    position: fixed;
    display: none;
    flex-direction: column;
    left: 50%;
    top: 40%;
    transform: translate(-50%, -60%);
    background: var(--c-grayed);
    z-index: 9999;
    border-radius: 20px;
    width: 50%;
    box-shadow: 2px 2px 8px 0 rgba(0, 0, 0, 0.12);
    max-height: 90dvh;
    padding-block: 24px;
    min-width: 450px;
}

h1 {
    color: var(--c-gray);
}

.popup.open {
    display: flex;
    gap: 20px;
}

.popup__inner {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 5px;
    padding-inline: 24px;
}

.popup__head-inner {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding-inline: 24px;
}

.popup__head {
    padding-bottom: 10px;
    border-bottom: 1px solid #EEEEEE;
    box-shadow: 0 4px 6px -2px rgba(0, 0, 0, 0.15);
}

.popup__close {
    margin-left: auto;
    cursor: pointer;
}

.without-border .popup__head {
    padding-bottom: 0;
    border-bottom: 0;
    box-shadow: 0 0 0 0;
}
</style>