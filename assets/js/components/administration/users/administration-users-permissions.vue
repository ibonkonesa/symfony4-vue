<template>

    <div>

        <h3>Configurar permisos</h3>

        <el-row :gutter="20">

            <el-col :span="8">

                <el-select @change="loadSwitch" v-model="mode">

                    <el-option value="role" label="Predefinido"></el-option>
                    <el-option value="custom" label="Personalizado"></el-option>

                </el-select>

            </el-col>


            <el-col :span="8" v-if="mode ==='role'">

                <el-select @change="savePermissions" v-model="userObject.role.id">

                    <el-option v-for="role in roles" :value="role.id" :key="role.id" :label="role.name"></el-option>

                </el-select>

            </el-col>


        </el-row>


        <br><br><br>


        <el-form :model="userObject">

            <el-form-item v-for="permission in $store.state.constants.permissionOptions" :key="permission.name"
                          :label="permission.label">

                <el-switch :disabled="mode === 'role'" @change="savePermissions"
                           v-model="permissions[permission.name]"></el-switch>

            </el-form-item>

        </el-form>


    </div>

</template>

<script>
    export default {
        name: "administration-users-permissions",
        props: {

            user: Object

        },

        data() {

            return {

                roles: [],
                mode: null,
                userObject: this.user,
                permissions: []


            }


        },


        methods: {

            loadSwitch: function () {

                this.permissions = this.mode === 'custom' ? this.userObject.permissions : this.userObject.role.permissions;

            },

            loadSelect: function () {

                this.mode = this.userObject.role.id === null ? 'custom' : 'role';
                this.loadSwitch();

            },

            savePermissions: function () {

                let payload = Object.assign({}, this.userObject);
                payload.mode = this.mode;

                this.$http.post('/admin/administration/users/permissions', payload)
                    .then(res => {

                        this.userObject = res.data;

                        this.loadSelect();

                    });
            }

        },

        watch: {

            user: function () {

                this.userObject = this.user;
                this.loadSelect();

            }

        },

        created() {

            this.$http.post('/admin/administration/roles/all')
                .then(res => {
                    this.roles = res.data;
                    this.loadSelect();
                })

        }
    }

</script>

<style scoped>

</style>