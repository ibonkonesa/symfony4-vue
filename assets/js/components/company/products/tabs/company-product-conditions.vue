<template>


    <div>

        <el-button style="float:right" type="primary" @click="showNewConditionDialog">Añadir sección</el-button>


        <br><br><br><br>


        <draggable v-model="conditions" @end="order">


            <div v-for="condition in conditions" :key="condition.id" class="condition">

            <span style="float: right">
               <i @click="deleteCondition(condition.id)" class="el-icon-delete"></i>

            </span>

                <h3>{{ condition.title }}</h3>
                <p v-html="condition.content"></p>

                <p class="read-more"></p>


            </div>


        </draggable>


        <el-dialog
                v-if="newConditionDialogVisible"
                title="Añadir sección"
                :visible.sync="newConditionDialogVisible">


            <el-form :model="newCondition" ref="conditionForm">

                <el-form-item label="Título"
                              :rules="$store.state.constants.requiredValidator"
                              prop="title">
                    <el-input v-model="newCondition.title" auto-complete="off"></el-input>
                </el-form-item>


                <el-form-item label="Texto" prop="content"
                              :rules="$store.state.constants.requiredValidator">

                    <br>
                    <wysiwyg v-model="newCondition.content"></wysiwyg>

                </el-form-item>


                <el-form-item>
                    <el-button type="primary" @click="saveCondition()">Guardar</el-button>
                </el-form-item>


            </el-form>


        </el-dialog>


    </div>


</template>

<script>

    import {EventBus} from '../../../../event-bus.js';
    import ElButton from "element-ui/packages/button/src/button";
    import draggable from 'vuedraggable'


    export default {
        components: {ElButton, draggable},
        name: "company-product-conditions",

        data() {

            return {

                newCondition: null,
                conditions: [],
                newConditionDialogVisible: false

            }

        },

        methods: {


            order() {


                this.$http.post('/admin/company/products/conditions/order', this.conditions)

                    .then(res => {
                    });


            },

            deleteCondition(idCondition) {

                this.$confirm('La sección será eliminada. ¿Estás seguro?', 'Warning', {
                    confirmButtonText: 'OK',
                    cancelButtonText: 'Cancelar',
                    title: 'Atención',
                    type: 'warning'
                }).then(() => {

                    const uri = '/admin/company/products/conditions/delete';
                    this.$http.post(uri, {id: idCondition})
                        .then(res => {

                            this.getConditions();

                            this.$message({
                                type: 'success',
                                message: 'Sección eliminada'
                            });

                        })
                });


            },


            saveCondition() {


                this.$refs['conditionForm'].validate((valid) => {
                    if (valid) {

                        this.$http.post('/admin/company/products/conditions/save', this.newCondition)
                            .then(res => {
                                this.getConditions();
                                this.newConditionDialogVisible = false;
                            })


                    } else {

                        return false;
                    }

                })
            },


            showNewConditionDialog() {

                this.newConditionDialogVisible = true;
                this.newCondition = {
                    title: null,
                    content: null,
                    idProduct: this.$store.state.company.currentProduct.id
                }
            }
            ,

            getConditions() {

                this.$http.get('/admin/company/products/conditions', {params: {idProduct: this.$store.state.company.currentProduct.id}})

                    .then(res => {

                        this.conditions = res.data;

                    });

            }

        },

        created() {

            this.getConditions();

            EventBus.$on('reloadCompanyProduct', this.getConditions);

        },
    }
</script>

<style scoped lang="scss">

    .condition {
        border-radius: 15px;
        border: 1px solid darkgrey;
        margin-bottom: 2vh;
        background-color: white;
        cursor: pointer;
        height: 100px;
        position: relative;
        overflow: hidden;
        padding: 1.5vh;

        .read-more {
            position: absolute;
            bottom: 0;
            left: 0;
            border-radius: 15px;
            width: 100%;
            text-align: center;
            margin: 0;
            padding: 30px 0;
            background-image: linear-gradient(to bottom, transparent, white);
        }

    }

</style>