<template>

    <div v-if="role !== null">

        <h1 v-if="role.id !== null">Editar rol</h1>
        <h1 v-if="role.id === null">Nuevo rol</h1>


        <el-form :model="role" ref="roleForm">

            <el-form-item prop="name" label="Nombre del rol" :rules="$store.state.constants.requiredValidator">

                <el-input v-model="role.name"></el-input>

            </el-form-item>


            <el-form-item v-for="permission in $store.state.constants.permissionOptions" :key="permission.name"
                          :label="permission.label">

                <el-switch v-model="role.permissions[permission.name]"></el-switch>

            </el-form-item>


            <el-form-item>


                <el-button @click="saveRol" :loading="isSaving" type="primary">Guardar rol</el-button>

            </el-form-item>

        </el-form>


    </div>


</template>

<script>

    import {EventBus} from '../../../event-bus.js';


    export default {
        name: "administration-roles-details",
        props: {
            id: String | Number,
        },
        data() {

            return {
                role: null,
                isSaving: false
            }

        },

        methods: {

            saveRol: function () {

                this.$refs['roleForm'].validate((valid) => {

                    if (valid) {

                        this.isSaving = true;

                        this.$http.post('/admin/administration/roles/save', this.role)
                            .then(res => {

                                this.isSaving = false;
                                this.$refs['roleForm'].clearValidate();
                                this.$router.push({name: 'RoleDetails', params: {id: res.data.id}})
                                EventBus.$emit('reloadTable');
                            })

                    } else {

                        return false;
                    }

                });
            },


            getRole: function () {

                this.$http.get('/admin/administration/roles/' + this.id)
                    .then(res => {
                        this.role = res.data;
                        setTimeout(() => this.$refs['roleForm'].clearValidate(), 1);

                    })
            }
        },

        watch: {

            id: function () {
                this.getRole();


            }

        },

        created() {
            this.getRole();

        }
    }
</script>

<style scoped>

</style>