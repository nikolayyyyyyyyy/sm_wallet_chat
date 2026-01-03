<script setup lang="ts">
import Account from '@/components/Account.vue';
import GoToArrow from '@/components/GoToArrow.vue';
import Load from '@/components/Load.vue';
import get from '@/crud/get';
import { onMounted, ref } from 'vue';
import { useRoute } from 'vue-router';
const props = defineProps({
    id:{
        required: true
    }
});

const route = useRoute();
const account = ref();
const index = route.query.index;
const { getItem } = get();
const is_loading = ref(false);
const transactions = ref([]);

onMounted(async () => {
    is_loading.value = true;
    account.value = await getItem('accounts', props.id);

    transactions.value = await( await fetch(`http://127.0.0.1:8000/api/transactions/${props.id}/account`,{
        method: 'GET',
        headers:{
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${localStorage.getItem('token')}`
        }        
    })).json();
    is_loading.value = false;
});
</script>

<template>
    <section class="section-account-transactions">
        <div class="section__inner shell">
            <div class="section__title">
                <GoToArrow nav-to="/" />

                <h1>Транзакции по сметка</h1>
            </div>

            <div v-if="!is_loading && account && transactions" class="section__content">
                <Account class="account" :account :class="{'light': index % 2 == 0, 'gray': index % 2 != 0}" />
                
                <div v-if="transactions.length > 0" class="section__transactions custom-form">
                    <div v-for="transaction in transactions" class="section__transaction">
                        <svg v-if="transaction.account_sender_id == account.id" width="40px" height="40px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M3.23633 12H13.9447M21.0003 16H18.5003M20.0003 12H18.5003M19.5003 8H18.5003M14.0387 11.5104L14.9302 8.55143C15.2677 7.43124 15.4365 6.87115 15.2929 6.53669C15.1683 6.24631 14.9137 6.03194 14.6063 5.95852C14.2523 5.87396 13.7291 6.13556 12.6827 6.65877L4.86243 10.5689C3.94121 11.0295 3.48061 11.2598 3.3328 11.5715C3.20417 11.8427 3.20417 12.1573 3.3328 12.4285C3.48061 12.7402 3.94121 12.9705 4.86243 13.4311L12.6935 17.3466C13.737 17.8683 14.2587 18.1292 14.6124 18.045C14.9195 17.9719 15.174 17.758 15.299 17.4682C15.4429 17.1343 15.276 16.5754 14.9421 15.4576L14.0376 12.4299C13.9866 12.2589 13.961 12.1734 13.9509 12.0864C13.942 12.0091 13.9421 11.931 13.9512 11.8537C13.9615 11.7667 13.9873 11.6812 14.0387 11.5104Z" stroke="#E40006" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <svg v-else width="40px" height="40px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M20.7639 12H10.0556M3 8.00003H5.5M4 12H5.5M4.5 16H5.5M9.96153 12.4896L9.07002 15.4486C8.73252 16.5688 8.56376 17.1289 8.70734 17.4633C8.83199 17.7537 9.08656 17.9681 9.39391 18.0415C9.74792 18.1261 10.2711 17.8645 11.3175 17.3413L19.1378 13.4311C20.059 12.9705 20.5197 12.7402 20.6675 12.4285C20.7961 12.1573 20.7961 11.8427 20.6675 11.5715C20.5197 11.2598 20.059 11.0295 19.1378 10.5689L11.3068 6.65342C10.2633 6.13168 9.74156 5.87081 9.38789 5.95502C9.0808 6.02815 8.82627 6.24198 8.70128 6.53184C8.55731 6.86569 8.72427 7.42461 9.05819 8.54246L9.96261 11.5701C10.0137 11.7411 10.0392 11.8266 10.0493 11.9137C10.0583 11.991 10.0582 12.069 10.049 12.1463C10.0387 12.2334 10.013 12.3188 9.96153 12.4896Z" stroke="#25b700" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>

                        <div class="transaction__content">
                            <div class="content__account__receiver">
                                <p><span>Сметка на получател:</span> {{ transaction.receiver_account.account_number }}</p>
                                <p><span>Вид на сметка:</span> {{ transaction.receiver_account.account_type.account_type }}</p>
                                <p><span>Валута: </span> {{ transaction.receiver_account.currency.currency }}</p>
                                <p><span>Име на картодържач: </span> {{ transaction.receiver_account.user.username }}</p>
                            </div>

                            <div class="content__transaction_info">
                                <p><span>Сума по превод:</span> {{ transaction.amount }} {{ transaction.sender_account.currency.currency }}</p>
                                <p><span>Вид на превода:</span> {{ transaction.transaction_type.transaction_type }}</p>
                                <p><span>Основание за превод:</span> {{ transaction.note ?? 'няма бележка.' }}</p>
                            </div>

                            <div class="content__account__sender">
                                <p><span>Сметка на изпращач:</span> {{ transaction.sender_account.account_number }}</p>
                                <p><span>Вид на сметка:</span> {{ transaction.sender_account.account_type.account_type }}</p>
                                <p><span>Валута: </span> {{ transaction.sender_account.currency.currency }}</p>
                                <p><span>Име на картодържач: </span> {{ transaction.sender_account.user.username }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <p v-else class="error__message">Няма транзакции по сметката</p>
            </div>

            <Load v-if="is_loading" />
        </div>
    </section>
</template>

<style scoped lang="scss">
.section-account-transactions{
    margin-block: 32px;

    .content__account__receiver,
    .content__transaction_info,
    .content__account__sender{
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .section__inner{
        display: flex;
        flex-direction: column;
        gap: 32px;
    }

    .section__title{
        display: grid;
        grid-template-columns: 1fr auto 1fr;
        align-items: center;
    }

    .account{
        align-self: center;
        cursor: default;
    }

    .section__content{
        display: flex;
        flex-direction: column;
        gap: 30px;
    }

    .section__transactions{
        display: flex;
        flex-direction: column;
        gap: 20px;
        color: var(--c-gray);
        cursor: default;
    }

    .section__transaction{
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .transaction__content{
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
    }

    span{
        font-size: 14px;
        font-weight: 500;
    }
    
    p{
        font-size: 12px;
        font-weight: 400;
    }

    svg{
        flex-shrink: 0;
    }
}
</style>