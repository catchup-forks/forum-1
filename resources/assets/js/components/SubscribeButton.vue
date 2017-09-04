<template>
    <button :class="classes" :disabled="disabled" @click="subscribe"><span class="glyphicon glyphicon-ok" v-if="isActive"></span> {{ buttonText }}</button>
</template>
<script>
    export default {
        props: ['active', 'authorized'],

        data() {
            return {
                isActive: this.active,
                disabled: !this.authorized
            }
        },

        computed: {
            classes() {
                return ['btn', this.isActive ? 'btn-primary' : 'btn-default'];
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