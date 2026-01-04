<template>
    <section class="section-admin">
        <h1 class="section__title">Администраторски панел</h1>

        <div class="section__actions custom-form">
            <RouterLink to="/currency" class="link">Добавяне на валута</RouterLink>
            <RouterLink to="/account-type" class="link">Добавяне тип на сметка</RouterLink>
            <RouterLink to="/transaction-type" class="link">Добавяне тип на транзакция</RouterLink>
            <RouterLink to="/users" class="link">Добавяне на потребители</RouterLink>
            <RouterLink to="/accounts" class="link">Добавяне на сметка</RouterLink>
            <RouterLink to="/transactions" class="link">Добави транзакция</RouterLink>
        </div>
    </section>
</template>

<style scoped lang="scss">
.section-admin{
    display: flex;
    flex-direction: column;
    gap: 24px;

    .section__title{
        text-align: center;
    }

    .section__actions{
        display: flex;
        flex-direction: column;
        align-self: center;
        gap: 12px;
        padding-block: 20px;
        width: 300px;
    }

    .link{
        align-self: center;
        text-align: center;
        font-weight: 500;
        width: 100%;
    }
}
</style>