<template>

    <el-row :gutter="30">

        <el-col :span="10" style="padding:1vw">

            <el-button @click="$router.push({name: 'UserDetails', params: {id: 'new'}})" type="primary">Nuevo usuario
            </el-button>
            <br><br>

            <paginated-table uri="/admin/administration/users" :row-click-function="showDetails"
                             :columns="columns"></paginated-table>

        </el-col>

        <el-col :span="14">

            <router-view></router-view>

        </el-col>

    </el-row>

</template>

<script>
    import PaginatedTable from "../../layout/paginated-table";

    export default {
        components: {PaginatedTable},
        name: "administration-users",
        data() {
            return {

                columns: [

                    {prop: 'fullName', label: ' Nombre'},
                    {prop: 'dni', label: ' Dni'},

                ],

            }
        },

        methods: {

            showDetails(row) {

                this.$router.push({name: 'UserDetails', params: {id: row.id}});

            }

        }
    }
</script>

<style scoped>

</style>