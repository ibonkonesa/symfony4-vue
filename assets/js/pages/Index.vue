<template>
    <div>
        <h1>Hello null</h1>
        <Loader v-if="isWorking"></Loader>
        <h1 v-if="firsTime">Welcome to my app</h1>
        <h1 v-else>Nice to see you again</h1>

    </div>
</template>

<script>
    import Loader from "../components/layout/loader";

    export default {
        name: "Index",
        data() {
            return {
                isWorking: false,
                firsTime: false

            }
        },
        components: {Loader},
        created() {
            this.isWorking = true;
            this.$http.get('/hello').then(response => {
                this.isWorking = false;
                this.firsTime = response.data;
            });
        }
    }
</script>

<style scoped>

</style>
