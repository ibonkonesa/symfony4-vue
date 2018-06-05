<template>

    <div class="container">

        <h2>Administración</h2>

        <br>

        <el-tabs :value="activeTab" @tab-click="dealTabClick">

            <el-tab-pane name="Roles" label="Roles"></el-tab-pane>

            <el-tab-pane name="Users" label="Usuarios"></el-tab-pane>

        </el-tabs>

        <router-view></router-view>

    </div>

</template>

<script>
    import AdministrationRoles from "./roles/administration-roles";

    export default {
        components: {AdministrationRoles},
        name: "administration",

        data() {

            return {}
        },

        methods: {

            dealTabClick(tab) {

                this.$router.push({name: tab.paneName});

            }

        },

        computed: {

            activeTab: function () {

                return this.$router.currentRoute.matched[1].name;

            }

        }
    }

</script>

<style scoped>

</style>