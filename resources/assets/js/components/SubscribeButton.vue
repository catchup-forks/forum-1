<template>
    <button :class="classes" @click="subscribe"><span class="glyphicon glyphicon-ok" v-if="isActive"></span> {{ buttonText }}</button>
</template>
<script>
    export default {
        props: ['active'],

        data() {
            return {
                isActive: this.active
            }
        },

        computed: {
            classes() {
                return ['btn', this.isActive ? 'btn-success' : 'btn-primary'];
            },
            buttonText() {
                return this.isActive ? lang['Subscribed'] : lang['Subscribe'];
            }
        },

        methods: {
            subscribe() {
                let method = this.isActive ? 'delete' : 'post';
                axios[method](location.pathname + '/subscriptions').then(response => {
                    this.isActive = !this.isActive;
                });
            }
        }
    }
</script>