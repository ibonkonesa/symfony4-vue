<template>

    <div>
        <div style="background-color: #e4eaec; padding: 2vw">

            <el-button @click="loadNewProduct" type="warning">Nuevo producto</el-button>
            <br><br>

            <paginated-table :row-click-function="loadProductView" :extra-params="extraParams"
                             uri="/admin/client/products" :columns="columns"></paginated-table>

        </div>


        <el-dialog
                v-if="$store.state.client.showNewProductModal"
                title="Nuevo producto"
                :visible.sync="$store.state.client.showNewProductModal">

            <client-product-form></client-product-form>


        </el-dialog>


    </div>

</template>

<script>
    import PaginatedTable from "../../layout/paginated-table";
    import ClientProductForm from "./client-product-form";
    import {EventBus} from '../../../event-bus.js';


    export default {
        components: {
            ClientProductForm,
            PaginatedTable
        },
        name: "client-product-list",
        data() {
            return {
                columns: [
                    {prop: 'policy', label: 'Nº Póliza'},
                    {prop: 'companyName', label: 'Compañía'},
                    {prop: 'productName', label: 'Producto contratado'}
                ],
                extraParams: {idClient: this.$store.state.client.currentClient.id},
            }
        },

        methods: {


            loadNewProduct: function () {

                let product = {

                    id: -1,
                    policy: null,
                    companyId: null,
                    productId: null,
                    conditions: null

                };

                this.$store.commit('client/setClientCurrentProduct', product);
                this.$store.commit('client/setClientNewProductModalVisibility', true);


            },

            loadProductView: function (product) {

                this.$store.commit('client/setClientView', 'ClientProductTabs');
                this.$store.commit('client/setClientCurrentProduct', product);
                EventBus.$emit('reloadClientProduct');
            }
        }
    }
</script>

<style scoped>

</style>