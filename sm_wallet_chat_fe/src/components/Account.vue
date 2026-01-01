<script setup>
defineProps({
    account: {
        type: Object,
        required: true
    }
});
</script>

<template>
    <div class="section__account">
        <div class="account__top">
            <div class="account__top-text">
                <p>Тип сметка:</p>

                <p>{{ account.account_type.account_type }}</p>
            </div>

            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                <g clip-path="url(#clip0_1_29)">
                    <path
                        d="M13.3333 3.33334H2.66668C1.9303 3.33334 1.33334 3.9303 1.33334 4.66668V11.3333C1.33334 12.0697 1.9303 12.6667 2.66668 12.6667H13.3333C14.0697 12.6667 14.6667 12.0697 14.6667 11.3333V4.66668C14.6667 3.9303 14.0697 3.33334 13.3333 3.33334Z"
                        stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M1.33334 6.66666H14.6667" stroke="white" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                </g>
                <defs>
                    <clipPath id="clip0_1_29">
                        <rect width="16" height="16" fill="white" />
                    </clipPath>
                </defs>
            </svg>
        </div>

        <div class="section__currency">
            <p>Валута:</p>
            <p> {{ account.currency.currency }}</p>
        </div>

        <div class="section__amount">
            <p>Наличност</p>
            <p>${{ account.amount }}</p>
        </div>

        <div class="section__interest">
            <p>Лихва</p>
            <p>{{ account.interest }}$</p>
        </div>

        <div class="section__account_number">
            <p>Номер на сметка</p>
            <p>{{ account.account_number }}</p>
        </div>
    </div>
</template>

<style scoped lang="scss">
.section__account {
    display: flex;
    flex-direction: column;
    gap: 14px;
    font-size: 14px;
    font-weight: 400;
    color: var(--c-white);
    flex: 0 0 calc((100% - 40px) / 4);
    box-sizing: border-box;
    padding: 16px;
    border-radius: 12px;
    min-width: 300px;
    border: 1px solid var(--c-gray);

    .section__account_number,
    .section__interest,
    .section__amount,
    .section__currency,
    .account__top-text {
        display: flex;
        gap: 8px;
    }

    .section__account_number {
        font-size: 14px;
    }

    .account__top {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
}

.light {
    background: linear-gradient(90deg, #4F46E5 0%, #9333EA 100%);
}

.gray {
    border: 1px solid #475569;
    background: linear-gradient(90deg, #334155 0%, #1E293B 100%);
}
</style>