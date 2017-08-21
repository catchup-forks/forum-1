<template>
    <button :class="classes" type="submit" @click="toggle">
        <span class="glyphicon glyphicon-heart"></span>
        <span v-text="count"></span>
    </button>
</template>
<script>
    export default {
        props: ['reply'],

        data() {
            return {
                count: this.reply.favoritesCount,
                active: this.reply.isFavorited
            }
        },

        computed: {
            classes() {
                return ['btn', this.active ? 'btn-primary' : 'btn-default'];
            },
            endpoint() {
                return '/replies/' + this.reply.id + '/favorite';
            }
        },

        methods: {
            toggle() {
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