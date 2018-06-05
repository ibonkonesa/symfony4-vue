<template>

    <el-tabs>
        <el-tab-pane label="General">

            <company-product-form></company-product-form>

        </el-tab-pane>
        <el-tab-pane label="Tarifas">

            <h1>TODO</h1>

        </el-tab-pane>
        <el-tab-pane label="Condiciones generales">

            <company-product-conditions></company-product-conditions>

        </el-tab-pane>
    </el-tabs>

</template>

<script>
    import CompanyProductForm from "../company-product-form";
    import CompanyProductConditions from "./company-product-conditions";

    export default {
        components: {
            CompanyProductConditions,
            CompanyProductForm
        },
        name: "company-product-tabs"
    }
</script>

<style scoped>

</style>