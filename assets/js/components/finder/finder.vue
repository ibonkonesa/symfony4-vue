<template>

    <div class="container">

        <h2>Buscador</h2>

        <br>

        <el-input v-model="filterText" prefix-icon="el-icon-search"
                  placeholder="Introduce cualquier palabra y buscaremos en todo el sistema"></el-input>
        <br><br>

        <div v-if="!isLoading">
            <el-table
                    :stripe="true"
                    :data="clients"
                    row-class-name="clickableRow"
                    @row-click="showClient"
                    style="width: 100%">
                <el-table-column
                        prop="name"
                        label="Nombre">
                </el-table-column>

                <el-table-column
                        prop="lastName"
                        label="Apellidos">
                </el-table-column>

                <el-table-column
                        prop="dni"
                        label="DNI">
                </el-table-column>

                <el-table-column
                        prop="email"
                        label="Email">
                </el-table-column>

                <el-table-column
                        prop="phone"
                        label="Teléfono">
                </el-table-column>

                <el-table-column
                        prop="postalCode"
                        label="Código Postal">
                </el-table-column>

                <el-table-column
                        prop="town"
                        label="Población">
                </el-table-column>

            </el-table>

            <br><br>

            <el-pagination
                    style="text-align:center"
                    v-if="maxResults > 0"
                    @current-change="getData"
                    :current-page="currentPage"
                    background
                    layout="prev, pager, next"
                    :total="maxResults"
                    :page-size="pageSize"
            >
            </el-pagination>

        </div>
        <Loader v-else="isLoading"></Loader>


    </div>

</template>

<script>


    export default {
        name: "finder",
        data() {
            return {
                clients: [],
                filterText: '',
                maxResults: null,
                pageSize: null,
                currentPage: null,
                isLoading: true,
            }
        },

        methods: {
            showClient(row) {

                this.$store.commit('client/setCurrentClient', row);
                this.$router.push({name: 'Client', params: {id: String(row.id)}});
            },

            getData: function (page) {
                this.isLoading = true;
                const uri = '/admin/find';
                this.$http.get(uri, {params: {page: page, filterText: this.filterText}})
                    .then(res => {

                        this.clients = res.data.items;
                        this.maxResults = res.data.maxResults;
                        this.pageSize = res.data.pageSize;
                        this.currentPage = page;
                    })
                    .catch((err) => {
                        console.warn('error during http call', err)
                    })
                    .then(() => {
                        this.isLoading = false
                    })
            },

        },

        watch: {
            filterText: function () {
                this.getData(1)
            }
        },

        created() {
            this.getData(1);
        }

    }
</script>

<style scoped>

</style>