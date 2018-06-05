<template>

    <el-form :model="product" ref="productForm">

        <el-form-item label="Nombre comercial"
                      :rules="$store.state.constants.requiredValidator"
                      prop="name">
            <el-input v-model="product.name" auto-complete="off"></el-input>
        </el-form-item>

        <el-form-item label="Familia de seguros" prop="family.id"
                      :rules="$store.state.constants.requiredValidator">


            <el-select @change="getBranchesByFamily()" style="width: 100%" v-model="product.family.id">
                <el-option
                        v-for="item in families"
                        :key="item.value"
                        :label="item.label"
                        :value="item.value">
                </el-option>
            </el-select>

        </el-form-item>

        <el-form-item label="Rama de seguros" prop="branch.id" :rules="$store.state.constants.requiredValidator">

            <el-select ref="branchesSelect" clearable
                       style="width: 100%" v-model="product.branch.id">
                <el-option
                        v-for="item in branches"
                        :key="item.value"
                        :label="item.label"
                        :value="item.value">
                </el-option>
            </el-select>

        </el-form-item>

        <el-form-item>

            <el-button v-loading="isSaving" type="primary" @click="saveProduct()">Guardar</el-button>
            <el-button v-if="$store.state.company.currentProduct.id !== -1" type="danger" @click="deleteProduct()">
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
        name: "company-product-form",

        data() {

            return {
                product: null,
                branches: [],
                families: [],
                isSaving: false
            }
        },

        methods: {


            saveProduct: function () {

                this.$refs['productForm'].validate((valid) => {
                    if (valid) {

                        this.isSaving = true;
                        this.$http.post('/admin/company/products/save', this.product)
                            .then(res => {

                                this.isSaving = false;
                                this.$refs['productForm'].clearValidate();
                                this.$store.commit('company/setNewProductModalVisibility', false);

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

                    const uri = '/admin/company/products/delete';
                    this.$http.post(uri, {id: this.product.id})
                        .then(res => {

                            EventBus.$emit('reloadTable');
                            this.$store.commit('company/setCurrentView', null);

                            this.$message({
                                type: 'success',
                                message: 'Producto eliminado'
                            });

                        })
                });

            },


            getBranchesByFamily: function () {

                this.$http.get('/admin/company/families/branches', {
                    params: {
                        idFamily: this.product.family.id
                    }
                })
                    .then(res => {

                        this.branches = res.data;
                    });
            },


            loadProduct: function () {

                this.product = JSON.parse(JSON.stringify(this.$store.state.company.currentProduct));
                this.product.idCompany = this.$store.state.company.current.id;

                this.$http.get('/admin/company/families')
                    .then(res => {
                        this.families = res.data;
                        if (this.product.family.id !== null) this.getBranchesByFamily();

                    })
            }

        },

        created() {

            this.loadProduct();

            EventBus.$on('reloadCompanyProduct', x => {
                this.loadProduct();
            });

        }
    }
</script>
:rules="{required: false, message: '', trigger: 'blur'}"
<style scoped>

    .editr {
        width: 99% !important;
    }

</style>