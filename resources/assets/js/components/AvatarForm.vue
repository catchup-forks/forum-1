<template>
    <div>
        <img class="img-rounded" :src="avatar" width="200">

        <form v-if="canUpdate" method="post" enctype="multipart/form-data">
            <image-upload style="width: 200px" name="avatar" @loaded="onLoaded"></image-upload>
        </form>
    </div>
</template>

<script>
    import ImageUpload from './ImageUpload.vue';

    export default {
        props: ['user'],

        components: {
            ImageUpload
        },

        computed: {
            canUpdate() {
                return this.authorize(user => user.id === this.user.id);
            }
        },

        data() {
            return {
                avatar: this.user.avatar_path
            }
        },

        methods: {

            onLoaded(avatar) {
                this.avatar = avatar.src;
                this.persist(avatar.file);
            },

            persist(avatar) {
                let data = new FormData();

                data.append('avatar', avatar);

                axios.post('/api/upload/avatar', data).then(() => flash('Your avatar has been updated!'));
            }
        }
    }
</script>