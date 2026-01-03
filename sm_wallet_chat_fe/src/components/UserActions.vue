<script setup>
const model = defineModel();
</script>

<template>
    <div class="section__user-link">
        <RouterLink to="/send-money" class="user__link">
            <div class="send-money-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path
                        d="M14.536 21.686C14.574 21.7807 14.64 21.8615 14.7253 21.9175C14.8105 21.9736 14.9108 22.0023 15.0128 21.9996C15.1148 21.997 15.2136 21.9633 15.2958 21.9029C15.3781 21.8426 15.4399 21.7585 15.473 21.662L21.973 2.662C22.005 2.5734 22.0111 2.47751 21.9906 2.38556C21.9701 2.29361 21.9238 2.2094 21.8572 2.14278C21.7906 2.07616 21.7064 2.0299 21.6144 2.00939C21.5225 1.98889 21.4266 1.995 21.338 2.027L2.33799 8.527C2.24148 8.5601 2.15741 8.62192 2.09706 8.70417C2.03671 8.78643 2.00296 8.88517 2.00035 8.98716C1.99773 9.08915 2.02638 9.18949 2.08245 9.27473C2.13851 9.35997 2.21931 9.42601 2.31399 9.464L10.244 12.644C10.4947 12.7444 10.7224 12.8945 10.9136 13.0852C11.1047 13.276 11.2552 13.5035 11.356 13.754L14.536 21.686Z"
                        stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M21.854 2.147L10.914 13.086" stroke="white" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
            </div>
            <p>Изпрати</p>
        </RouterLink>


        <div @click="model = true" class="user__link add-to-favorites">
            <div class="add-to-favorite-icon">
                <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32">
                    <path fill="#ffd54f" d="m16 24l10 6l-4-10l8-8l-10-.032L16 2l-4 10H2l8 8l-4 10Z" />
                </svg>
            </div>
            <p>Добави <br> в любими</p>
        </div>

        <RouterLink to="/favorites" class="user__link">
            <div class="send-message-icon">
                <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <g fill="none">
                        <path fill="url(#SVG14vC6sni)"
                            d="M10 2a8 8 0 1 1-3.613 15.14l-.121-.065l-3.645.91a.5.5 0 0 1-.62-.441v-.082l.014-.083l.91-3.644l-.063-.12a8 8 0 0 1-.83-2.887l-.025-.382L2 10a8 8 0 0 1 8-8" />
                        <path fill="url(#SVGsqanyJ7e)"
                            d="M10.5 11h-3l-.09.008a.5.5 0 0 0 0 .984L7.5 12h3l.09-.008a.5.5 0 0 0 0-.984zm2-3h-5l-.09.008a.5.5 0 0 0 0 .984L7.5 9h5l.09-.008a.5.5 0 0 0 0-.984z" />
                        <defs>
                            <linearGradient id="SVG14vC6sni" x1="2.571" x2="16.54" y1="5" y2="28.815"
                                gradientUnits="userSpaceOnUse">
                                <stop stop-color="#0FAFFF" />
                                <stop offset="1" stop-color="#CC23D1" />
                            </linearGradient>
                            <linearGradient id="SVGsqanyJ7e" x1="7.525" x2="7.974" y1="8.07" y2="12.414"
                                gradientUnits="userSpaceOnUse">
                                <stop stop-color="#FDFDFD" />
                                <stop offset="1" stop-color="#CCEAFF" />
                            </linearGradient>
                        </defs>
                    </g>
                </svg>
            </div>
            <p>Изпрати <br> съобщение</p>
        </RouterLink>
    </div>
</template>

<style scoped lang="scss">
.section__user-link{
    display: flex;
    align-items: center;
    justify-content: space-evenly;

    .user__link{
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 4px;
        color: var(--c-base);
        font-weight: 500;
        background: transparent;
        
        p{
            text-align: center;
        }
    }

    .send-message-icon,
    .add-to-favorite-icon,
    .send-money-icon{
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 10px;
        border-radius: 15px;
    }

    .send-message-icon,
    .send-money-icon{
        background: #4F46E5;
    }

    .add-to-favorite-icon{
        background: rgb(130, 130, 48);
    }

    .add-to-favorites{
        cursor: pointer;
    }
}
</style>