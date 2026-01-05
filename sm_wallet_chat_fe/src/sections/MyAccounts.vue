<script setup>
const props = defineProps({
    total_price: {
        type: Number,
        required: true
    }
});
</script>

<template>
    <section class="section-my-accounts custom-form">
        <div class="section__head">
            <p class="section__text">Total Balance:</p>

            <p class="section__amount">{{ total_price }}</p>
        </div>

        <div class="section__accounts">
            <slot />
        </div>
    </section>
</template>

<style scoped lang="scss">
.section-my-accounts {
    display: flex;
    flex-direction: column;
    gap: 20px;

    .section__accounts {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
        align-items: stretch;
    
        & > * {
            flex: 0 0 calc((100% - 60px) / 4);
            box-sizing: border-box;
        }
    }

    .section__head {
        display: flex;
        flex-direction: column;
    }

    .section__text {
        color: var(--c-gray);
        font-size: 15px;
        font-weight: 400;
        cursor: default;
    }

    .section__amount {
        font-size: 25px;
        color: var(--c-white);
        font-weight: 500;
        cursor: default;
    }
}
</style>