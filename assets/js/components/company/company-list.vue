<template>

    <div class="container">

        <el-button type="primary" style="float: right" @click="showNewCompanyDialog">Nueva aseguradora</el-button>

        <h2>Aseguradoras</h2>
        <br>

        <paginated-table :row-click-function="showCompany"
                         uri="/admin/company/list" :columns="columns"></paginated-table>


        <el-dialog :visible.sync="newCompanyDialog" title="Nueva aseguradora">
            <company-profile-form></company-profile-form>
        </el-dialog>


    </div>

</template>

<script>
    import PaginatedTable from "../layout/paginated-table";
    import ElFormItem from "element-ui/packages/form/src/form-item";
    import CompanyProfileForm from "./company-profile-form";

    export default {
        components: {
            CompanyProfileForm,
            ElFormItem,
            PaginatedTable
        },
        name: "companies",
        data() {
            return {
                newCompanyDialog: false,
                columns: [
                    {prop: 'name', label: 'Nombre'},
                    {prop: 'email', label: 'Email'}]
            }
        },

        methods: {

            showNewCompanyDialog() {
                this.$store.commit('company/setCurrentCompany', {id: -1});
                this.newCompanyDialog = true;
            },

            showCompany(row) {
                this.$store.commit('company/setCurrentCompany', row);
                this.$router.push({name: 'Company', params: {id: String(row.id)}});
            }
        }
    }
</script>

<style scoped>

</style>