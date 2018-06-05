<template>

    <div>
        <div style="padding: 2vw">

            <el-button @click="loadNewProduct" type="warning">Nuevo producto</el-button>
            <br><br>

            <paginated-table :row-click-function="loadProductView" :extra-params="extraParams"
                             uri="/admin/company/products" :columns="columns"></paginated-table>

        </div>

        <el-dialog :before-close="()=> {$store.commit('company/setNewProductModalVisibility', false)}"
                   v-if="$store.state.company.showNewProductModal"
                   title="Nuevo producto"
                   :visible.sync="$store.state.company.showNewProductModal">

            <company-product-form></company-product-form>

        </el-dialog>

    </div>

</template>

<script>

    import {mapState} from 'vuex'
    import PaginatedTable from "../../layout/paginated-table";
    import {EventBus} from '../../../event-bus.js';
    import CompanyProductForm from "./company-product-form";

    export default {
        components: {
            CompanyProductForm,
            PaginatedTable
        },
        name: "company-product-list",
        data() {
            return {

                columns: [
                    {prop: 'id', label: 'Nombre comercial'},
                    {prop: 'family.name', label: 'Familia de seguros'}
                ],
                extraParams: {idCompany: this.$store.state.company.current.id},
            }
        },

        methods: {

            loadProductView: function (product) {

                this.$store.commit('company/setCurrentView', 'CompanyProductTabs');
                this.$store.commit('company/setCurrentProduct', product);
                EventBus.$emit('reloadCompanyProduct');
            },

            loadNewProduct: function () {

                let product = {
                    id: -1,
                    name: null,
                    branch: {id: null},
                    family: {id: null}

                };

                this.$store.commit('company/setCurrentProduct', product);
                this.$store.commit('company/setNewProductModalVisibility', true);

            },

        },

        computed: mapState({

            company: state => state.company.current

        })
    }
</script>

<style scoped>

</style>