<template>
    <div>
        <select class="form-control" v-model="currentId" @change="getDeposits()">
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
                <tr v-for="deposit in deposits">
                    <td>{{ deposit.transaction_date }}</td>
                    <td>{{ deposit.status }}</td>
                    <td>{{ deposit.amount }}</td>
                    <td>{{ deposit.description }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        name: 'deposits',
        props: ['cap_id'],
        data () {
            return {
                deposits: [],
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
                axios.get("http://api.reimaginebanking.com/customers/" + this.cap_id + "/accounts?key=d675ed2cf7224244143cd980b5bf1e46")
                    .then(response => {
                        this.accounts = response.data;
                        this.isIDSet = true
                    }).catch(error => {
                    console.log(error);
                    this.isIDSet = false
                });
            },
            getDeposits() {
                axios.get("http://api.reimaginebanking.com/accounts/" + this.currentId + "/deposits?key=d675ed2cf7224244143cd980b5bf1e46")
                    .then(response => {
                        this.deposits = response.data;
                    })
            }
        }
    }
</script>