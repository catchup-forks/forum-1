<template>
    <div>
        <img class="img-rounded" :src="avatar" width="200">

        <form v-if="canUpdate" method="post" enctype="multipart/form-data">
            <input style="width: 200px" type="file" name="avatar" accept="image/*" @change="onChange">
        </form>
    </div>
</template>

<script>
    export default {
        props: ['user'],

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
            onChange(e) {
                if (!e.target.files.length) return;
                let avatar = e.target.files[0];

                let reader = new FileReader();

                reader.readAsDataURL(avatar);

                reader.onload = e => {
                    this.avatar = e.target.result;
                };

                this.persist(avatar);
            },

            persist(avatar) {
                let data = new FormData();

                data.append('avatar', avatar);

                axios.post('/api/upload/avatar', data).then(() => flash('Your avatar has been updated!'));
            }
        }
    }
</script>