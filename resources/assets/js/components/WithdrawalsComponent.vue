<template>
    <div>
        <select class="form-control" v-model="currentId" @change="getWithdrawals()">
            <option v-for="account in accounts" v-bind:value="account._id">
                {{ account.nickname + " - $" + account.balance }}
            </option>
        </select>
        <table class="table">
            <thead>
            <tr>
                <th>Date</th>
                <th>Status</th>
                <th>Amount</th>
                <th>Description</th>
            </tr>
            </thead>
            <tbody>
                <tr v-for="withdrawal in withdrawals">
                    <td>{{ withdrawal.transaction_date }}</td>
                    <td>{{ withdrawal.status }}</td>
                    <td>{{ withdrawal.amount }}</td>
                    <td>{{ withdrawal.description }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        name: 'withdrawals',
        props: ['cap_one_id'],
        data () {
            return {
                withdrawals: [],
                accounts: [],
                isIDSet: false,
                currentId: 0
            }
        },
        mounted() {
            this.updateAccounts();
        },
        methods: {
            updateAccounts() {
                axios.get("http://api.reimaginebanking.com/customers/" + this.cap_one_id + "/accounts?key=d675ed2cf7224244143cd980b5bf1e46")
                    .then(response => {
                        this.accounts = response.data;
                        this.isIDSet = true
                    }).catch(error => {
                    console.log(error);
                    this.isIDSet = false
                });
            },
            getWithdrawals() {
                axios.get("http://api.reimaginebanking.com/accounts/" + this.currentId + "/withdrawals?key=d675ed2cf7224244143cd980b5bf1e46")
                    .then(response => {
                        this.withdrawals = response.data;
                    })
            }
        }
    }
</script>