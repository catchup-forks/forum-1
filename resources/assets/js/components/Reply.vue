<script>
    export default {
        props: ['attributes'],

        created() {
            console.log(lang)
        },

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
            }
        }
    }
</script>