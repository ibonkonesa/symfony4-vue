<template>
    <div class="container">

        <h2>{{ company.name }} </h2>
        <br>

        <el-row :gutter="20">
            <el-col :span="12">

                <el-tabs v-model="activeTab" @tab-click="dealTabClick()">
                    <el-tab-pane name="general" label="General">
                        <company-profile-form v-if="company.id !== -1"></company-profile-form>
                    </el-tab-pane>
                    <el-tab-pane name="products" label="Productos">

                        <company-product-list v-if="company.id !== -1"></company-product-list>

                    </el-tab-pane>
                </el-tabs>

            </el-col>
            <el-col :span="12">

                <div :is="currentView"></div>

            </el-col>
        </el-row>
    </div>
</template>

<script>
    import {mapState} from 'vuex'
    import CompanyProfileForm from "./company-profile-form";
    import CompanyProductList from "./products/company-product-list";
    import CompanyProductTabs from "./products/tabs/company-product-tabs";

    export default {
        components: {
            CompanyProductList,
            CompanyProfileForm,
            CompanyProductTabs
        },
        name: "company",
        props: {
            id: String,
        },
        data() {
            return {
                activeTab: 'general'
            }
        },
        methods: {
            dealTabClick: function () {
                this.$store.commit('company/setCurrentView', null);
            }
        },

        computed: mapState({
            currentView: state => state.company.currentView,
            company: state => state.company.current
        }),

        created() {
            if (this.$store.state.company.current.id === -1) {

                console.log('NO TENGO!');

                this.$http.get('/admin/company', {params: {idCompany: this.id}})
                    .then(res => {
                        this.$store.commit('company/setCurrentCompany', res.data);
                    })
            }
        }
    }
</script>

<style scoped>

</style>