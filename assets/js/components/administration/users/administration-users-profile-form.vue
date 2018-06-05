<template>

    <div>

        <h1 v-if="userObject.id !== null">Editar usuario</h1>
        <h1 v-if="userObject.id === null">Nuevo usuario</h1>

        <el-form :model="userObject" ref="userForm">


            <el-row :gutter="20">

                <el-col :span="12">


                    <el-form-item label="Usuario"
                                  :rules="usernameValidator"
                                  prop="username">
                        <el-input v-model="userObject.username" auto-complete="off"></el-input>
                    </el-form-item>

                </el-col>


                <el-col :span="12">

                    <el-form-item label="Password"
                                  :rules="user.id === null ?  $store.state.constants.requiredValidator : {}"
                                  prop="password">
                        <el-input v-model="userObject.password" type="password" auto-complete="off"></el-input>
                    </el-form-item>

                </el-col>

            </el-row>

            <el-row :gutter="20">

                <el-col :span="12">

                    <el-form-item label="Nombre"
                                  :rules="$store.state.constants.requiredValidator"
                                  prop="name">
                        <el-input v-model="userObject.name" auto-complete="off"></el-input>
                    </el-form-item>


                    <el-form-item label="Primer apellido"
                                  :rules="$store.state.constants.requiredValidator"
                                  prop="firstSurname">
                        <el-input v-model="userObject.firstSurname" auto-complete="off"></el-input>
                    </el-form-item>

                    <el-form-item label="Segundo apellido"
                                  :rules="$store.state.constants.requiredValidator"
                                  prop="secondSurname">
                        <el-input v-model="userObject.secondSurname" auto-complete="off"></el-input>
                    </el-form-item>

                    <el-form-item label="Dni"
                                  :rules="$store.state.constants.requiredValidator"
                                  prop="dni">
                        <el-input v-model="userObject.dni" auto-complete="off"></el-input>
                    </el-form-item>


                    <el-form-item label="Email"
                                  :rules="{required:true, type:'email', trigger:'submit', 'message':'Campo obligatorio'}"
                                  prop="email">
                        <el-input v-model="userObject.email" auto-complete="off"></el-input>
                    </el-form-item>


                </el-col>


                <el-col :span="12">

                    <el-form-item label="Dirección"
                                  :rules="$store.state.constants.requiredValidator"
                                  prop="address">
                        <el-input v-model="userObject.address" auto-complete="off"></el-input>
                    </el-form-item>


                    <el-form-item label="Teléfono"
                                  :rules="$store.state.constants.requiredValidator"
                                  prop="phone">
                        <el-input v-model="userObject.phone" auto-complete="off"></el-input>
                    </el-form-item>


                    <el-form-item label="Cuenta bancaria"
                                  :rules="$store.state.constants.requiredValidator"
                                  prop="bankAccount">
                        <el-input v-model="userObject.bankAccount" auto-complete="off"></el-input>
                    </el-form-item>


                    <el-form-item label="Fecha de alta"
                                  :rules="$store.state.constants.requiredValidator"
                                  prop="created">

                        <br>
                        <el-date-picker style="width:  100%"
                                        v-model="userObject.created"
                                        type="date"
                                        format="dd/MM/yyyy"
                                        value-format="yyyy-MM-dd"
                                        placeholder="Fecha de alta">
                        </el-date-picker>

                    </el-form-item>

                </el-col>


            </el-row>


            <el-button :loading="isSaving" type="primary" @click="submit">Guardar</el-button>


        </el-form>


    </div>

</template>

<script>

    import {EventBus} from '../../../event-bus.js';


    export default {
        name: "administration-users-profile-form",
        props: {

            user: Object

        },

        data() {

            let validateUsername = (rule, value, callback) => {


                if (value == null || (value !== null && value.length === 0))
                    return callback(new Error('El campo es obligatorio'));

                this.$http.post('/admin/administration/users/checkUsername', {

                    id: this.userObject.id,
                    username: value

                })

                    .then(res => {
                        if (res.data) callback();
                        else callback(new Error('El nombre de usuario ya está siendo utilizado'));
                    })
            };


            return {

                userObject: this.user,
                usernameValidator: {validator: validateUsername, required: true, trigger: 'submit'},
                isSaving: false

            }
        },

        methods: {


            submit() {

                this.$refs['userForm'].validate(valid => {


                    if (valid) {

                        this.isSaving = true;
                        this.$http.post('/admin/administration/users/save', this.userObject)
                            .then(res => {

                                this.userObject = res.data;
                                this.isSaving = false;
                                this.$refs['userForm'].clearValidate();
                                EventBus.$emit('reloadTable');


                            });


                    } else {

                        return false;
                    }


                })

            }


        },


        watch: {

            user: function () {

                this.userObject = this.user;
                this.$refs['userForm'].clearValidate();

            }


        }


    }
</script>

<style scoped>

</style>