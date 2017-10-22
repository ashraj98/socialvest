<template>
    <div class="col-lg-12">
        <ul class="list-group" v-for="transaction in transactions">
            <li class="list-group-item d-flex justify-content-between align-items-center">
                {{ transaction.infoText }}
                <span class="badge badge-primary badge-pill">{{ transaction.amount }}</span>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        name: 'latestTransactions',
        data () {
            return {
                transactions: []
            }
        },
        mounted() {
            this.refreshTransactions();
            setInterval(function () {
                this.refreshTransactions();
            }.bind(this), 10000);
        },
        methods: {
            refreshTransactions() {
                axios.get("/transactions/latest")
                    .then(response => {
                        this.transactions = response.data;
                    }).catch(error => {
                    console.log(error);
                });
            }
        }
    }
</script>