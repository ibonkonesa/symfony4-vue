<template>
    <el-tabs v-if="user !== null" v-model="activeTab">

        <el-tab-pane name="general" label="General">

            <administration-users-profile-form :user="user"></administration-users-profile-form>

        </el-tab-pane>

        <el-tab-pane name="permissions" label="Permisos">

            <administration-users-permissions :user="user"></administration-users-permissions>

        </el-tab-pane>

    </el-tabs>

</template>


<script>
    import AdministrationUsersProfileForm from "./administration-users-profile-form";
    import AdministrationUsersPermissions from "./administration-users-permissions";

    export default {
        components: {
            AdministrationUsersPermissions,
            AdministrationUsersProfileForm
        },
        name: "administration-users-details",

        props: {
            id: String | Number,
        },

        data() {
            return {
                user: null,
                activeTab: null
            }
        },

        methods: {

            getUser: function () {
                this.$http.get('/admin/administration/users/' + this.id)
                    .then(res => {
                        this.user = res.data;
                        this.activeTab = 'general';
                    })
            }
        },

        watch: {
            id: function () {
                this.getUser();
            }
        },

        created() {
            this.getUser();
        }


    }
</script>

<style scoped>

</style>