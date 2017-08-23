<template>
    <button :class="classes" type="submit" @click="toggle" :disabled="this.disabled">
        <span class="glyphicon glyphicon-heart"></span>
        <span v-text="count"></span>
    </button>
</template>
<script>
    export default {
        props: ['reply','authorized'],

        data() {
            return {
                count: this.reply.favoritesCount,
                active: this.reply.isFavorited,
                disabled: !this.authorized
            }
        },

        computed: {
            classes() {
                return ['btn', (this.active && !this.disabled) ? 'btn-primary' : 'btn-default'];
            },
            endpoint() {
                return '/replies/' + this.reply.id + '/favorite';
            }
        },

        methods: {
            toggle() {
                if (this.disabled) return;
                this.active ? this.unfavorite() : this.favorite();
            },

            unfavorite() {
                axios.delete(this.endpoint);

                this.active = false;
                this.count--;
            },

            favorite() {
                axios.post(this.endpoint);

                this.active = true;
                this.count++;
            }
        }
    }
</script>