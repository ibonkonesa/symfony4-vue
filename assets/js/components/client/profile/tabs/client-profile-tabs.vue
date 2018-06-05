<template>


    <el-tabs>
        <el-tab-pane label="Gestiones"></el-tab-pane>
        <el-tab-pane label="Historial"></el-tab-pane>
        <el-tab-pane label="Siniestralidad"></el-tab-pane>
        <el-tab-pane label="Comunicado"></el-tab-pane>
        <el-tab-pane label="Correo electrónico">


            <client-profile-emails></client-profile-emails>

        </el-tab-pane>

    </el-tabs>

</template>

<script>
    import ClientProfileEmails from "./client-profile-emails";

    export default {
        components: {ClientProfileEmails},
        name: "client-profile-tabs"
    }
</script>

<style scoped>

</style>