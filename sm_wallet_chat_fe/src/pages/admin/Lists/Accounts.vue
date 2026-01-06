<script setup lang="ts">
import GoToArrow from '@/components/GoToArrow.vue';

</script>

<template>
    <section class="section-accounts">
        <div class="section__inner shell">
            <div class="section__title">
                <GoToArrow nav-to="/" />

                <h1>Сметки</h1>
            </div>
        </div>
    </section>
</template>

<style scoped lang="scss">
.section-accounts{
    margin-block: 32px;

    .section__inner{
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    .section__title{
        display: grid;
        grid-template-columns: 1fr auto 1fr;
        align-items: center;
    }
}
</style>