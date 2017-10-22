<template>
    <div class="col-sm-12">
        <h3>
            Purchase Stock
        </h3>
        <div v-if="this.caponeid = ''">
            <div class="alert alert-danger">You must connect to a Capital One account first!</div>
        </div>
        <div v-else>
            <div class="alert alert-danger" v-if="!validSymbol">Current stock symbol is not valid!</div>
            <div class="alert alert-success" v-else>The current price of {{ symbol }} is ${{ stock['Time Series (1min)'][stock['Meta Data']['3. Last Refreshed']]['4. close'] }}.</div>
            <form action="/purchase/shares" method="POST">
                <label for="symbol">Symbol:</label>
                <input type="text" name="symbol" id="symbol" class="form-control" v-model="symbol" @change="getRealtimeQuote()">
                <label for="account">Select Account:</label>
                <select name="account" id="account" class="form-control">
                    <option v-for="account in accounts" v-bind:value="account._id">
                        {{ account.nickname + " - $" + account.balance }}
                    </option>
                </select>
                <label for="numShares" class="control-label">Number Of Shares</label>
                <input type="number" name="numShares" id="numShares" class="form-control"/>
                <input v-if="validSymbol" type="hidden" name="price" id="price" v-bind:value="stock['Time Series (1min)'][stock['Meta Data']['3. Last Refreshed']]['4. close']"/>
                <button v-if="validSymbol" type="submit" class="btn btn-warning btn-block">Submit Trade</button>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'buy-stock',
        props: ['coid'],
        data () {
            return {
                stock: [],
                accounts: [],
                symbol: '',
                isIDSet: false,
                validSymbol: false
            }
        },
        mounted() {
            this.updateAccounts();
        },
        methods: {
            updateAccounts() {
                axios.get("http://api.reimaginebanking.com/customers/" + this.coid + "/accounts?key=d675ed2cf7224244143cd980b5bf1e46")
                    .then(response => {
                        console.log(response);
                        this.accounts = response.data;
                        this.isIDSet = true
                    }).catch(error => {
                    console.log(error);
                    this.isIDSet = false
                });
            },
            getRealtimeQuote() {
                axios.get("https://www.alphavantage.co/query?function=TIME_SERIES_INTRADAY&symbol=" + this.symbol + "&interval=1min&apikey=3IF3IW1LBN2W7OGI")
                    .then(response => {
                        this.stock = response.data;
                        console.log(Object.keys(this.stock)[0]);
                        this.validSymbol = this.stock[Object.keys(this.stock)[0]] !== 'Error Message';
                    })
            }
        }
    }
</script>