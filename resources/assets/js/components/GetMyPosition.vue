<template>
    <div>
        <span v-if="latitude != null">{{ lang["found_your_location"] }}</span>
        <span v-if="findingLocation">{{ lang["loading"] }}</span>
        <button style="margin-top: 30px" v-if="latitude == null && longitude == null" :disabled="findingLocation" type="button" @click="getMyLocation" class="btn btn-primary btn-lg">
            {{ lang["find_my_location"] }}
        </button>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                lang: window.lang,
                latitude: null,
                longitude: null,
                getLocationAutomatically: true,
                findingLocation: false,
            }
        },
        methods: {
            getMyLocation() {
                this.findingLocation = true
                if ("geolocation" in navigator) {
                    navigator.geolocation.getCurrentPosition(position => {
                        this.findingLocation = false;
                        this.latitude = position.coords.latitude;
                        this.longitude = position.coords.longitude;

                        localStorage.setItem('myLocation', JSON.stringify({
                            latitude: position.coords.latitude,
                            longitude: position.coords.longitude
                        }));

                        axios.post('/my-position', {
                            latitude: position.coords.latitude,
                            longitude: position.coords.longitude
                        });

                        window.location.href = '/workout/create';
                    });
                }
            }
        }
    }
</script>
