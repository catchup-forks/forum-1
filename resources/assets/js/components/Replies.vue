<template>
    <div>
        <div v-for="(reply, index) in items" :key="reply.id">
            <reply :data="reply" @deleted="remove(index)"></reply>
        </div>

        <paginator :dataSet="dataSet" @changed="fetch"></paginator>

        <new-reply :endpoint="endpoint" @created="add"></new-reply>
    </div>
</template>

<script>
    import NewReply from './NewReply.vue';
    import collection from './../mixins/collection';

    export default {
        components: {NewReply},

        mixins: [collection],

        created() {
            this.fetch();
        },

        data() {
            return {
                endpoint: location.pathname,
                dataSet: []
            }
        },

        methods: {
            fetch(page) {
                axios.get(this.url(page)).then(this.refresh);
            },

            url(page) {
                if (!page) {
                    let query = location.search.match(/page=(\d+)/);

                    page = query ? query[1] : 1;
                }

                return this.endpoint + '/replies?page=' + page;
            },

            refresh({data}) {
                this.dataSet = data;
                this.items = data.data;

                window.scrollTo(0,0);
            }
        }
    }
</script>