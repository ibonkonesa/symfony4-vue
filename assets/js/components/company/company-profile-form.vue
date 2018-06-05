<template>
    <el-form :model="company" ref="companyForm">

        <el-form-item label="Nombre"
                      :rules="$store.state.constants.requiredValidator"
                      prop="name">
            <el-input v-model="company.name" auto-complete="off"></el-input>
        </el-form-item>


        <el-form-item label="Correo electrónico"
                      :rules="[$store.state.constants.requiredValidator,{ type: 'email', message: 'El correo electrónico debe ser una dirección email válida', trigger: 'blur,change' }]"
                      prop="email">
            <el-input v-model="company.email" auto-complete="off"></el-input>
        </el-form-item>


        <el-form-item>
            <el-button v-loading="isLoading" type="primary" @click="saveCompany">Guardar</el-button>
        </el-form-item>

    </el-form>

</template>

<script>
    export default {
        name: "company-profile-form",

        data() {
            return {
                company: null,
                isLoading: false
            }
        },

        methods: {
            saveCompany: function () {
                this.$refs['companyForm'].validate((valid) => {
                    if (valid) {

                        this.isLoading = true;
                        this.$http.post('/admin/company/save', this.company).then(res => {
                            this.isLoading = false;
                            this.$store.commit('company/setCurrentCompany', res.data);
                            this.$router.push({name: 'Company', params: {id: String(res.data.id)}});
                        });

                    } else {
                        return false;
                    }
                });
            }
        },

        created() {

            this.company = Object.assign({}, this.$store.state.company.current);

        }
    }
</script>

<style scoped>

</style>