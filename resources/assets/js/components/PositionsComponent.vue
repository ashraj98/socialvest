<template>
    <div class="col-lg-12">
        <ul class="list-group" v-for="position in positions">
            <li class="list-group-item d-flex justify-content-between align-items-center">
                {{ position.stock.name + ', ' + position.amount + ' shares @ $' + position.curPrice }}
                <span v-bind:class="position.yield > 0 ? 'badge badge-pill badge-success' : 'badge badge-pill badge-danger'">{{ position.yield }}%</span>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        name: 'positions',
        data () {
            return {
                positions: []
            }
        },
        mounted() {
            this.refreshPositions();
            setInterval(function () {
                this.refreshPositions();
            }.bind(this), 10000);
        },
        methods: {
            refreshPositions() {
                axios.get("/user/positions")
                    .then(response => {
                        this.positions = response.data;
                    }).catch(error => {
                    console.log(error);
                });
            }
        }
    }
</script>