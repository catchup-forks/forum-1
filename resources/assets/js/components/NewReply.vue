<template>
    <div>
        <div class="form-group">
            <textarea
                    v-model="body"
                    name="body"
                    id="body"
                    class="form-control"
                    :placeholder="lang['Have something to say?']"
                    required
            ></textarea>
        </div>

        <button type="submit" class="btn btn-default" @click="addReply">{{ lang['Post'] }}</button>

    </div>
</template>

<script>
    export default {
        props: ['endpoint'],

        data() {
            return {
                body: ''
            }
        },

        methods: {
            addReply() {
                axios.post(this.endpoint + '/replies', {body: this.body})
                    .then(({data}) => {
                        this.body = '';

                        flash('Your reply has been published!');

                        this.$emit('created', data);
                    });
            }
        }
    }
</script>