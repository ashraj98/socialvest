<template>
    <gmap-map :center="{lat:currentLocation.lat, lng:currentLocation.lng}" :zoom="15" style="width: 100%; height: 800px">
        <gmap-info-window :options="infoOptions" :position="infoWindowPos" :opened="infoWinOpen" @closeclick="infoWinOpen=false">
            {{infoContent}}
        </gmap-info-window>

        <gmap-marker :key="i" v-for="(m,i) in markers" :position="m.position" :clickable="true" @click="toggleInfoWindow(m,i)"></gmap-marker>
    </gmap-map>
</template>

<script>
    export default {
        name: 'gMap',
        data () {
            return {
                currentLocation : { lat : 0, lng : 0},
                searchAddressInput: '',
                infoContent: '',
                infoWindowPos: {
                    lat: 0,
                    lng: 0
                },
                infoWinOpen: false,
                currentMidx: null,
                //optional: offset infowindow so it visually sits nicely on top of our marker
                infoOptions: {
                    pixelOffset: {
                        width: 0,
                        height: -35
                    }
                },
                markers: []
            }
        },
        mounted : function() {
            this.geolocation();
        },
        methods: {
            toggleInfoWindow: function(marker, idx) {

                this.infoWindowPos = marker.position;
                this.infoContent = marker.infoText;

                //check if its the same marker that was selected if yes toggle
                if (this.currentMidx == idx) {
                    this.infoWinOpen = !this.infoWinOpen;
                }
                //if different marker set infowindow to open and reset current marker index
                else {
                    this.infoWinOpen = true;
                    this.currentMidx = idx;

                }
            },
            geolocation : function() {
                navigator.geolocation.getCurrentPosition((position) => {
                    this.currentLocation = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude,
                    };
                    axios.post("/transactions/map", {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    }).then(response => {
                        console.log(response.data);
                        this.markers = response.data;
                    }).catch(error => {
                        console.log(error);
                    });
                });
            }

        }
    }
</script>
