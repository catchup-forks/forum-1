<template>
    <div class="panel panel-default">
        <div :id="'reply-'+data.id" class="panel-heading">
            <div class="level">
                <h5 class="flex">
                    <img class="mr-1 img-rounded" :src="data.owner.avatar_path" width="40">
                    <a :href="'/profile/' + data.owner.name">{{ data.owner.name }}</a> :
                    <span v-text="ago"></span>
                </h5>

                <div>
                    <favorite :reply="data" :authorized="true"></favorite>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <div v-if="editing">
                <div class="form-group">
                    <textarea class="form-control" v-model="body"></textarea>
                </div>
                <button class="btn btn-primary btn-xs" @click="update">{{ lang['Save'] }}</button>
                <button class="btn btn-link btn-xs" @click="editing = false">{{ lang['Cancel'] }}</button>
            </div>
            <article v-else v-text="body"></article>
        </div>
        <!--@can('update', $reply)-->
        <div class="panel-footer level" v-if="canUpdate">
            <button class="btn btn-default btn-xs mr-1" type="submit" @click="editing = true">
                {{ lang['Edit'] }}
            </button>
            <button class="btn btn-danger btn-xs" type="submit" @click="destroy">
                {{ lang['Delete'] }}
            </button>
        </div>
        <!--@endcan-->
    </div>
</template>

<script>
    import Favorite from './Favorite.vue';
    import moment from 'moment-timezone';

    export default {
        props: ['data'],

        components: {Favorite},

        data() {
            return {
                body: this.data.body,
                editing: false
            }
        },

        computed: {
            ago() {
                return moment.tz(this.data.created_at, window.forum.timezone).fromNow();
            },
            canUpdate() {
                return this.authorize(user => this.data.user_id === user.id);
            }
        },

        methods: {
            update() {
                axios.patch('/replies/' + this.data.id, {body: this.body});

                this.editing = false;

                flash('Your reply is updated!')
            },

            destroy() {
                axios.delete('/replies/' + this.data.id);

                this.$emit('deleted', this.data.id);

                /*$(this.$el).slideUp(300, () => {
                    flash('Your reply has been deleted!')
                });*/

            }
        }
    }
</script>