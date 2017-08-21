<script>
    import Favorite from './Favorite.vue';

    export default {
        props: ['attributes'],

        components: { Favorite },

        data() {
            return {
                body: this.attributes.body,
                editing: false
            }
        },

        methods: {
            update() {
                axios.patch('/replies/' + this.attributes.id, {body: this.body});

                this.editing = false;

                flash('Your reply is updated!')
            },

            destroy() {
                axios.delete('/replies/' + this.attributes.id);

                $(this.$el).fadeOut(300, () => {
                    flash('Your reply is deleted!')
                });

            }
        }
    }
</script>