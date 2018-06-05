<template>

    <div>

        <el-input v-model="filterText" prefix-icon="el-icon-search"
                  placeholder="Escribe para buscar"></el-input>
        <br><br>

        <div v-if="!isLoading">
            <el-table
                    highlight-current-row
                    :stripe="true"
                    :data="items"
                    @row-click="dealRowClick"
                    row-class-name="clickableRow"
                    style="width: 100%">

                <el-table-column v-for="column in columns"
                                 :prop="column.prop"
                                 :label="column.label"
                                 :key="column.prop">

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


    import {EventBus} from '../../event-bus.js';


    export default {
        name: "paginated-table",
        props: {

            columns: Array,
            uri: String,
            rowClickFunction: Function,
            extraParams: Object

        },
        data() {
            return {
                items: [],
                filterText: '',
                maxResults: null,
                pageSize: null,
                currentPage: null,
                isLoading: true,
            }
        },

        methods: {

            dealRowClick: function (row) {
                if (this.rowClickFunction !== undefined) {


                    this.rowClickFunction(row);

                    /*


                    let functionName = this.rowClickFunction;
                    this.$parent[functionName](row);*/
                }
            },

            getData: function (page) {
                this.isLoading = true;
                let params = {page: page, filterText: this.filterText};

                if (this.extraParams !== undefined) {
                    params = Object.assign(params, this.extraParams);
                }

                this.$http.get(this.uri, {params: params})
                    .then(res => {
                        this.items = res.data.items;
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

            EventBus.$on('reloadTable', x => {
                this.getData(1);
            });

        }

    }
</script>

<style scoped>

</style>