<script setup>
const props = defineProps({
    user: {
        type: Object,
        required: true
    },
    chatIcon: {
        type: Boolean,
        required: false
    }
});
import LikeStar from './LikeStar.vue';
</script>

<template>
    <div class="user" :class="{ 'row-reverse': chatIcon }">
        <div class="user__inner">
            <div class="user__content">
                <figure class="content__image image-fit">
                    <img :src="user.profile_photo ?? '/avatar.png'" />
                </figure>

                <div class="content">
                    <p class="content__title">
                        {{ user.username }}
                    </p>

                    <p class="content__text">
                        {{ user.email }}
                    </p>
                </div>
            </div>

            <LikeStar :element-id="user.id" :is-liked="user.is_favorited" />
        </div>

        <RouterLink v-if="chatIcon" :to="{name: 'users.chat', params: { id: user.id }}">
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
        </RouterLink>
    </div>
</template>

<style scoped lang="scss">
.user {
    padding: 20px;
    border-radius: 10px;
    background: var(--c-blue);
    width: 300px;
    border: 1px solid var(--c-white);
    display: flex;
    align-items: center;

    svg {
        flex-shrink: 0;
    }

    .user__inner {
        display: flex;
        gap: 10px;
        width: 100%;
        justify-content: space-between;
        align-items: center;
    }

    .content__image {
        width: 50px;
        aspect-ratio: 1 / 1;
        border-radius: 100%;
        display: flex;
    }

    .user__content {
        display: flex;
        align-items: center;
        gap: 12px;
        color: var(--c-gray);
    }

    .content__text,
    .content__title {
        font-weight: 400;
        cursor: default;
    }

    .content__title {
        font-size: 18px;
    }

    .content__text {
        font-size: 15px;
    }

    svg {
        cursor: pointer;
    }
}

a{
    background: transparent;
}

.row-reverse .user__inner {
    display: flex;
    flex-direction: row-reverse;
    justify-content: flex-end;
}
</style>