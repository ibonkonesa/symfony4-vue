<template>

    <div class="container">

        <h2>Nuevo cliente</h2>


        <br>

        <client-profile-form></client-profile-form>


    </div>


</template>

<script>
    import ClientProfileForm from "./profile/client-profile-form";

    export default {
        components: {
            ClientProfileForm
        },
        name: "new-client",

        created() {

            this.$store.commit('client/setCurrentClient', {id: -1});

        }

    }
</script>

<style scoped>


</style>