<template>
    <div class="alert alert-warning alert-flash" role="alert" v-show="show">
        {{ body }}
    </div>
</template>

<script>
    export default {
        props: ['message'],
        data() {
            return {
                body: this.message,
                show: false
            }
        },
        created() {
            if (this.message) {
                this.flash(this.message);
            }

            window.events.$on('flash', message => this.flash(message));
        },
        methods: {
            flash(message) {
                let flashMessage = message;
                if (window.lang[message]) {
                    flashMessage = window.lang[message];
                }

                this.body = flashMessage;
                this.show = true;

                this.hide();
            },
            hide() {
                setTimeout(() => {
                    this.show = false
                }, 3000)
            }
        }
    }
</script>

<style>
    .alert-flash {
        position: fixed;
        bottom: 25px;
        right: 25px;
    }
</style>