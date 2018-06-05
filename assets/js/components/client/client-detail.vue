<template>

    <div class="container">

        <h2>{{ $store.state.client.currentClient.name }} {{ $store.state.client.currentClient.lastName }}</h2>

        <br>

        <el-row :gutter="20">
            <el-col :span="12">

                <el-tabs v-model="activeTab" @tab-click="dealTabClick()"
                         v-if="$store.state.client.currentClient.id !== -1">
                    <el-tab-pane name="products" label="Seguros">

                        <client-product-list></client-product-list>

                    </el-tab-pane>
                    <el-tab-pane name="profile" label="Ficha cliente">

                        <client-profile-form></client-profile-form>

                    </el-tab-pane>
                    <el-tab-pane label="Recibos">


                    </el-tab-pane>
                </el-tabs>

            </el-col>
            <el-col :span="12">

                <div :is="$store.state.client.currentView"></div>

            </el-col>
        </el-row>

    </div>


</template>

<script>

    import ClientProductList from "./products/client-product-list";
    import ClientProductTabs from "./products/tabs/client-product-tabs"
    import ClientProfileForm from "./profile/client-profile-form";
    import ClientProfileTabs from "./profile/tabs/client-profile-tabs";

    export default {
        components: {
            ClientProfileForm,
            ClientProductList, ClientProductTabs, ClientProfileTabs
        },
        name: "client",
        props: {
            id: String,
        },
        data() {
            return {

                activeTab: 'products'

            }
        },
        methods: {


            dealTabClick: function () {

                if (this.activeTab === 'profile') {
                    this.$store.commit('client/setClientView', 'ClientProfileTabs');

                } else {
                    this.$store.commit('client/setClientView', null);
                }
            }

        },


        created() {

            this.$store.commit('client/setClientView', null);

            if (this.$store.state.client.currentClient.id === -1) {
                this.$http.get('/admin/client', {params: {idClient: this.id}})
                    .then(res => {
                        this.$store.commit('client/setCurrentClient', res.data);
                    })
            }
        }
    }

</script>

<style scoped></style>