<template>

    <el-form :model="product" ref="productForm">

        <el-form-item label="Numero de póliza"
                      :rules="$store.state.constants.requiredValidator"
                      prop="policy">
            <el-input v-model="product.policy" auto-complete="off"></el-input>
        </el-form-item>

        <el-form-item label="Compañía" prop="companyId" :rules="$store.state.constants.requiredValidator">


            <el-select @change="getProductsByCompany()" style="width: 100%" v-model="product.companyId">
                <el-option
                        v-for="item in companies"
                        :key="item.value"
                        :label="item.label"
                        :value="item.value">
                </el-option>
            </el-select>

        </el-form-item>

        <el-form-item label="Producto" prop="productId" :rules="$store.state.constants.requiredValidator">

            <el-select ref="productSelect" clearable
                       style="width: 100%" v-model="product.productId">
                <el-option
                        v-for="item in products"
                        :key="item.value"
                        :label="item.label"
                        :value="item.value">
                </el-option>
            </el-select>

        </el-form-item>

        <el-form-item label="Condiciones particulares" prop="conditions"
                      :rules="$store.state.constants.requiredValidator">

            <br>
            <wysiwyg v-model="product.conditions"></wysiwyg>

        </el-form-item>

        <el-form-item>

            <el-button v-loading="isSaving" type="primary" @click="saveProduct()">Guardar</el-button>
            <el-button v-if="$store.state.client.currentProduct.id !== -1" type="danger" @click="deleteProduct()">
                Eliminar
            </el-button>

        </el-form-item>


    </el-form>
</template>

<script>
    import ElFormItem from "element-ui/packages/form/src/form-item";
    import {EventBus} from '../../../event-bus.js';


    export default {
        components: {ElFormItem},
        name: "client-product-form",

        data() {

            return {

                product: null,
                companies: [],
                products: [],
                isSaving: false
            }
        },

        methods: {

            saveProduct: function () {


                this.$refs['productForm'].validate((valid) => {
                    if (valid) {

                        this.isSaving = true;
                        this.$http.post('/admin/client/products/save', this.product)
                            .then(res => {
                                this.isSaving = false;

                                this.$refs['productForm'].clearValidate();
                                this.$store.commit('client/setClientNewProductModalVisibility', false);

                                EventBus.$emit('reloadTable');

                            });

                    } else {
                        return false;
                    }
                });


            },

            deleteProduct: function () {

                this.$confirm('El producto y toda la información relacionada será eliminada por completo. ¿Estás seguro?', 'Warning', {
                    confirmButtonText: 'OK',
                    cancelButtonText: 'Cancelar',
                    title: 'Atención',
                    type: 'warning'
                }).then(() => {

                    const uri = '/admin/client/products/delete';
                    this.$http.post(uri, {id: this.product.id})
                        .then(res => {

                            EventBus.$emit('reloadTable');
                            this.$store.commit('client/setClientView', null);

                            this.$message({
                                type: 'success',
                                message: 'Producto eliminado'
                            });

                        })
                });

            },

            getProductsByCompany: function () {

                this.$http.get('/admin/company/products/options', {
                    params: {
                        idProduct: this.product.id,
                        idClient: this.$store.state.client.currentClient.id,
                        idCompany: this.product.companyId
                    }
                })
                    .then(res => {

                        if (this.product.companyId === this.$store.state.client.currentProduct.companyId)
                            this.product.productId = this.$store.state.client.currentProduct.productId;
                        else
                            this.product.productId = null;

                        this.products = res.data;
                    });
            },


            loadProduct: function () {

                this.product = JSON.parse(JSON.stringify(this.$store.state.client.currentProduct));
                this.product.idClient = this.$store.state.client.currentClient.id;

                this.$http.get('/admin/company/options')
                    .then(res => {
                        this.companies = res.data;
                        if (this.product.companyId !== null) this.getProductsByCompany();

                    })

            }

        },

        created() {

            this.loadProduct();

            EventBus.$on('reloadClientProduct', x => {
                this.loadProduct();
            });

        }
    }
</script>

<style scoped>

    .editr {
        width: 99% !important;
    }

</style>