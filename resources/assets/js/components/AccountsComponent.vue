<template>
    <div class="col-sm-12">
        <h3>
            Accounts
        </h3>
        <div class="col-md-6" v-if="isIDSet" v-for="account in accounts">
            <div class="card">
                <span class="glyphicon glyphicon glyphicon-credit-card center" v-if="account.type == 'Credit Card'"></span>
                <span class="glyphicon glyphicon glyphicon-ok center" v-else-if="account.type == 'Checking'"></span>
                <span class="glyphicon glyphicon glyphicon-piggy-bank center" v-else></span>
                <div class="container">
                    <h4><b>{{ account.nickname }}</b></h4>
                    <p>${{ account.balance }}</p>
                    <p>{{ account.rewards }} Points</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'accounts',
        props: ['caponeid'],
        data () {
            return {
                accounts: [],
                isIDSet: false
            }
        },
        mounted() {
            this.updateAccounts();
        },
        methods: {
            updateAccounts() {
                axios.get("http://api.reimaginebanking.com/customers/" + this.caponeid + "/accounts?key=d675ed2cf7224244143cd980b5bf1e46")
                    .then(response => {
                        this.accounts = response.data;
                        this.isIDSet = true
                    }).catch(error => {
                        console.log(error);
                        this.isIDSet = false
                    });
            }
        }
    }
</script>

<style scoped>
    .card {
        box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
        transition: 0.3s;
        width: 250px;
    }

    .card:hover {
        box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
    }

    .card span {
        font-size: 200px;
        text-align: center;
        width: 100%;
    }

    .center {
        margin: 0 auto !important;
        float: none !important;
    }
</style>