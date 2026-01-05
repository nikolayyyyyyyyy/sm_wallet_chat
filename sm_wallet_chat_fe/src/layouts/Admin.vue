<template>
    <section class="section-admin">
        <h1 class="section__title">Администраторски панел</h1>

        <div class="section__actions">
            <div class="section__create__actions custom-form">
                <RouterLink to="/currency" class="link">Добавяне на валута</RouterLink>
                <RouterLink to="/account-type" class="link">Добавяне тип на сметка</RouterLink>
                <RouterLink to="/transaction-type" class="link">Добавяне тип на транзакция</RouterLink>
                <RouterLink to="/user" class="link">Добавяне на потребители</RouterLink>
                <RouterLink to="/account" class="link">Добавяне на сметка</RouterLink>
                <RouterLink to="/transaction" class="link">Добави транзакция</RouterLink>
            </div>

            <div class="section__create__actions custom-form">
                <RouterLink to="/currencies" class="link">Валути</RouterLink>
                <RouterLink to="/account-types" class="link">Типове сметки</RouterLink>
                <RouterLink to="/transaction-types" class="link">Типове транзакции</RouterLink>
                <RouterLink to="/users" class="link">Потребители</RouterLink>
                <RouterLink to="/accounts" class="link">Сметки</RouterLink>
                <RouterLink to="/transactions" class="link">Транзакции</RouterLink>
            </div>
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
        gap: 30px;
        justify-content: center;
    }

    .section__create__actions{
        display: flex;
        flex-direction: column;
        gap: 12px;
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