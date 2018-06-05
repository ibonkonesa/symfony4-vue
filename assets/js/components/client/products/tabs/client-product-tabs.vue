<template>
    <el-tabs>
        <el-tab-pane label="General">

            <client-product-form></client-product-form>

        </el-tab-pane>
        <el-tab-pane label="Documentos">

            <client-product-documents></client-product-documents>

        </el-tab-pane>
        <el-tab-pane label="Comparador">

            <h1>TODO</h1>


        </el-tab-pane>
    </el-tabs>
</template>

<script>

    import ClientProductForm from "../client-product-form";
    import ClientProductDocuments from "./client-product-documents";

    export default {

        components: {
            ClientProductDocuments,
            ClientProductForm},
        name: "client-product-tabs"
    }
</script>

<style scoped>

</style>