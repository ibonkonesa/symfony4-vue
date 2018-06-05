<template>
    <div>
        <el-form :model="client" ref="clientForm">


            <el-row :gutter="20">

                <el-col :span="12">

                    <el-form-item label="Nombre"
                                  :rules="$store.state.constants.requiredValidator"
                                  prop="name">
                        <el-input v-model="client.name" auto-complete="off"></el-input>
                    </el-form-item>

                </el-col>


                <el-col :span="12">

                    <el-form-item label="Apellidos"
                                  :rules="$store.state.constants.requiredValidator"
                                  prop="lastName">
                        <el-input v-model="client.lastName" auto-complete="off"></el-input>
                    </el-form-item>


                </el-col>


            </el-row>


            <el-row :gutter="20">

                <el-col :span="12">
                    <el-form-item label="DNI"
                                  :rules="dniValidator"
                                  prop="dni">
                        <el-input v-model="client.dni" :disabled="client.id !== -1" auto-complete="off"></el-input>
                    </el-form-item>

                </el-col>


                <el-col :span="12">
                    <el-form-item label="Correo electrónico"
                                  :rules="$store.state.constants.requiredValidator"
                                  prop="email">
                        <el-input v-model="client.email" auto-complete="off"></el-input>
                    </el-form-item>

                </el-col>


            </el-row>


            <el-row :gutter="20">

                <el-col :span="12">

                    <el-form-item label="Teléfono"
                                  :rules="$store.state.constants.requiredValidator"
                                  prop="phone">
                        <el-input v-model="client.phone" auto-complete="off"></el-input>
                    </el-form-item>

                </el-col>


                <el-col :span="12">

                    <el-form-item label="Localidad"
                                  :rules="$store.state.constants.requiredValidator"
                                  prop="location">
                        <el-input v-model="client.location" auto-complete="off"></el-input>
                    </el-form-item>


                </el-col>


            </el-row>


            <el-row :gutter="20">

                <el-col :span="12">

                    <el-form-item label="Población"
                                  :rules="$store.state.constants.requiredValidator"
                                  prop="town">
                        <el-input v-model="client.town" auto-complete="off"></el-input>
                    </el-form-item>

                </el-col>


                <el-col :span="12">

                    <el-form-item label="Empresa"
                                  :rules="$store.state.constants.requiredValidator"
                                  prop="company">
                        <el-input v-model="client.company" auto-complete="off"></el-input>
                    </el-form-item>


                </el-col>


            </el-row>

            <el-row :gutter="20">

                <el-col :span="12">

                    <el-form-item label="Código postal"
                                  :rules="$store.state.constants.requiredValidator"
                                  prop="postalCode">
                        <el-input v-model="client.postalCode" auto-complete="off"></el-input>
                    </el-form-item>

                </el-col>

                <el-col :span="12">
                    <el-form-item label="Profesión"
                                  :rules="$store.state.constants.requiredValidator"
                                  prop="occupation">
                        <el-input v-model="client.occupation" auto-complete="off"></el-input>
                    </el-form-item>

                </el-col>

            </el-row>

            <el-row :gutter="20">

                <el-col :span="12">

                    <el-form-item label="Género"
                                  :rules="$store.state.constants.requiredValidator"
                                  prop="gender">
                        <br>

                        <el-select style="width:  100%" v-model="client.gender" auto-complete="off">

                            <el-option :value="0" label="Hombre"></el-option>
                            <el-option :value="1" label="Mujer"></el-option>

                        </el-select>
                    </el-form-item>

                </el-col>


                <el-col :span="12">


                    <el-form-item label="Fecha de nacimiento"
                                  :rules="$store.state.constants.requiredValidator"
                                  prop="birthDate">


                        <br>
                        <el-date-picker style="width:  100%"
                                        v-model="client.birthDate"
                                        type="date"
                                        format="dd/MM/yyyy"
                                        value-format="yyyy-MM-dd"
                                        placeholder="Fecha de nacimiento">
                        </el-date-picker>

                    </el-form-item>


                </el-col>


            </el-row>

            <el-row :gutter="20">

                <el-col :span="12">

                    <el-form-item label="Tipo de cliente"
                                  :rules="$store.state.constants.requiredValidator"
                                  prop="type">

                        <br>

                        <el-select style="width:  100%" v-model="client.type" auto-complete="off">

                            <el-option :value="0" label="Particular"></el-option>
                            <el-option :value="1" label="PYME"></el-option>
                            <el-option :value="2" label="Gran empresa"></el-option>
                        </el-select>
                    </el-form-item>

                </el-col>

            </el-row>


            <el-form-item>

                <el-button v-loading="isSaving" type="primary" @click="saveClient()">Guardar</el-button>


            </el-form-item>


        </el-form>
    </div>
</template>

<script>

    export default {

        name: "client-profile-form",

        data() {

            let validateDni = (rule, value, callback) => {

                if (value == null || (value !== null && value.length === 0))
                    return callback(new Error('El campo es obligatorio'));
                this.$http.get('/admin/client/checkDni', {params: {id: this.client.id, dni: value}})

                    .then(res => {
                        if (res.data) callback();
                        else callback(new Error('El dni ya está siendo utilizado'));
                    })
            };

            return {
                dniValidator: {validator: validateDni, required: true},
                client: null,
                isSaving: false
            }
        },

        methods: {
            saveClient: function () {
                this.$refs['clientForm'].validate((valid) => {
                    if (valid) {

                        this.isSaving = true;
                        this.$http.post('/admin/client/save', this.client)
                            .then(res => {

                                this.isSaving = false;
                                this.$refs['clientForm'].clearValidate();
                                this.$store.commit('client/setCurrentClient', res.data);
                                this.$router.push({name: 'Client', params: {id: String(res.data.id)}});

                            });

                    } else {
                        return false;
                    }
                });
            }

        },

        created() {

            this.client = Object.assign({}, this.$store.state.client.currentClient);

        }

    }
</script>

<style scoped>

</style>