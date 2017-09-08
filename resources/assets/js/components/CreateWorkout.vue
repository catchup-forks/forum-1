<template>
    <form v-on:submit.prevent="submitWorkout">

        <div class="alert alert-info">
            {{ lang['workout.create_explanation'] }}
        </div>

        <div class="alert alert-danger" v-if="form.errors.any()">
            <p><strong>{{ lang["validation.whoops_something_went_wrong"] }}</strong></p>
            <ul>
                <li v-for="(key, value, index) in form.errors.errors">{{ lang[key] }}</li>
            </ul>
        </div>

        <div class="form-group" :class="{ 'has-error': this.form.errors.has('tempo') }">
            <label>{{ lang["workout.expected_tempo"] }}</label>
            <div class="row">
                <div class="col-xs-5">
                    <div class="input-group">
                        <select class="form-control" v-model="tempoMinutes">
                            <option :selected="minutes == tempoMinutes" :value="minutes"
                                    v-for="minutes in tempo.minutes">{{ minutes }}
                            </option>
                        </select>
                        <div class="input-group-addon">{{ lang["minute_short"] }}</div>
                    </div>
                </div>
                <div class="col-xs-5">
                    <div class="input-group">

                        <select class="form-control" v-model="tempoSeconds">
                            <option :selected="seconds == tempoSeconds" :value="seconds"
                                    v-for="seconds in tempo.seconds">{{ seconds }}
                            </option>
                        </select>
                        <div class="input-group-addon">{{ lang["second_short"] }}</div>

                    </div>
                </div>
                <div class="col-xs-2">
                    /km
                </div>
            </div>
        </div>
        <div class="form-group" :class="{ 'has-error': this.form.errors.has('distance') }">
            <label>{{ lang["workout.expected_distance"] }}</label>

            <div class="input-group">

                <select class="form-control" v-model="form.distance">
                    <option :selected="form.distance == distance" :value="runDistance"
                            v-for="runDistance in distances">{{ runDistance }}
                    </option>
                </select>
                <div class="input-group-addon">km</div>

            </div>

        </div>
        <div class="form-group" :class="{ 'has-error': this.form.errors.has('starting') }">
            <label>{{ lang["workout.when"] }}</label>

            <div class="row">
                <div class="col-xs-6">
                    <input type="date" class="form-control" v-model="date" :value="date">
                </div>
                <div class="col-xs-6">
                    <div class="input-group">
                        <div class="input-group-addon">{{ lang["time_prefix"] }}</div>
                        <select class="form-control" v-model="workoutHour">
                            <option :selected="hour == workoutHour" :value="hour" v-for="hour in hours">{{ hour }}
                            </option>
                        </select>
                        <div class="input-group-addon">:00</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label>{{ lang["workout.description"] }}</label>
            <textarea class="form-control" rows="3" v-model="form.description"></textarea>
        </div>
        <div class="form-group" v-if="form.latitude == null || form.longitude == null">
            <span v-if="latitude != null">{{ lang["found_your_location"] }}</span>
            <span v-if="findingLocation">{{ lang["loading"] }}</span>
            <button v-if="!form.latitude || !form.longitude" :disabled="findingLocation" type="button" @click="getMyLocation" class="btn btn-default">
                {{ lang["find_my_location"] }}
            </button>
        </div>
        <button v-if="form.latitude != null && form.longitude != null"
                class="btn btn-primary btn-lg">{{ lang["workout.find_people_to_run_with"] }}
        </button>

    </form>

</template>

<script>
    export default {
        mounted() {
            let date = new Date();
            let month = (date.getMonth() + 1 < 10) ? '0' + (date.getMonth() + 1) : date.getMonth() + 1;
            let day = (date.getDate() < 10) ? '0' + date.getDate() : date.getDate();
            this.date = date.getFullYear() + '-' + month + '-' + day
            this.workoutHour = date.getHours() + 2
        },
        data() {
            return {
                lang: window.lang,
                tempoMinutes: 5,
                tempoSeconds: 0,
                distance: 5,
                date: null,
                workoutHour: null,
                latitude: null,
                longitude: null,
                form: new Form({
                    tempo: 300,
                    distance: 5,
                    starting: null,
                    latitude: null,
                    longitude: null,
                    description: ''
                }),
                getLocationAutomatically: true,
                findingLocation: false,
                tempo: {
                    minutes: [2, 3, 4, 5, 6, 7, 8, 9, 10],
                    seconds: [0, 15, 30, 45]
                },
                distances: [5, 10, 15, 20, 25, 30, 40, 50, 75, 100],
                hours: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23]
            }
        },
        methods: {
            getMyLocation() {
                this.findingLocation = true
                if ("geolocation" in navigator) {
                    navigator.geolocation.getCurrentPosition(position => {
                        this.form.latitude = position.coords.latitude;
                        this.form.longitude = position.coords.longitude;
                        this.findingLocation = false;

                        localStorage.setItem('myLocation', JSON.stringify({
                            latitude: this.form.latitude,
                            longitude: this.form.longitude
                        }));

                        axios.post('/my-position', {
                            latitude: position.coords.latitude,
                            longitude: position.coords.longitude
                        });
                    });
                }
            },

            submitWorkout() {

                axios.post('/workout', this.form)
                    .then(({data}) => {
                        flash('Your workout has been published!');
                    }).catch(error => {
                        flash('Something went wrong when trying to publish your workout!');
                    });

                /*this.form.submit('post', '/api/workout').then(response => {
                 if (typeof response.data !== 'undefined' && typeof response.data.id !== 'undefined') {
                 window.user_workout = response.data.id;
                 }
                 //window.location.href = "/";
                 });*/
            }
        },
        watch: {
            tempoMinutes: function (val) {
                this.form.tempo = (val * 60) + this.tempoSeconds
            },
            tempoSeconds: function (val) {
                this.form.tempo = (this.tempoMinutes * 60) + val
            },
            date: function (val) {
                this.form.starting = val + ' ' + this.workoutHour + ':00:00'
            },
            workoutHour: function (val) {
                this.form.starting = this.date + ' ' + val + ':00:00'
            }
        }
    }
</script>
