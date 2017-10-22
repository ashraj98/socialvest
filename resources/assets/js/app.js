
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Vue.component('example-component', require('./components/ExampleComponent.vue'));
import * as VueGoogleMaps from 'vue2-google-maps'
import Accounts from './components/AccountsComponent.vue';
import BuyStock from './components/BuyStockComponent.vue';
import Deposits from './components/DepositsComponent.vue';
import GMap from './components/MapComponent.vue';
import LatestTransactions from './components/LatestTransactionsComponent.vue';
import Positions from './components/PositionsComponent.vue';
import Withdrawals from './components/WithdrawalsComponent.vue';

Vue.use(VueGoogleMaps, {
    load: {
        key: 'AIzaSyCIjMYKySe3HRBZZW90nLWvZr4fS6qqlSo',
        libraries: 'places', // This is required if you use the Autocomplete plugin
        // OR: libraries: 'places,drawing'
        // OR: libraries: 'places,drawing,visualization'
        // (as you require)
    }
});

new Vue({
    el: '#capitalOne',
    components: {
        Accounts,
        BuyStock,
        Deposits,
        GMap,
        LatestTransactions,
        Positions,
        Withdrawals
    }
});
