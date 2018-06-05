<template>

    <input type="file" name="files[]" id="documentUpload"/>

</template>

<script>

    export default {
        name: "client-product-documents",

        data() {
            return {
                documents: []
            }
        },

        mounted() {

            let that = this;
            this.$http.get('/admin/client/products/documents', {params: {idClientProduct: this.$store.state.client.currentProduct.id}})

                .then(res => {


                    this.documents = res.data;
                    $(this.$el).fileuploader({
                        addMore: true,
                        upload: {
                            url: '/admin/client/products/documents/upload',
                            data: {idClientProduct: this.$store.state.client.currentProduct.id},
                            type: 'POST',
                            enctype: 'multipart/form-data',
                            start: true,
                            synchron: true,
                            chunk: false,
                            onSuccess: function (data, item, listEl, parentEl, newInputEl, inputEl, textStatus, jqXHR) {

                                item.data.id = data;

                                item.html.find('.column-actions').append(
                                    '<a class="fileuploader-action fileuploader-action-remove fileuploader-action-success" title="Remove"><i></i></a>'
                                );

                                setTimeout(function () {
                                    item.html.find('.progress-bar2').fadeOut(400);
                                }, 400);
                            },

                            onError: function (item, listEl, parentEl, newInputEl, inputEl, jqXHR, textStatus, errorThrown) {

                                var progressBar = item.html.find('.progress-bar2');
                                if (progressBar.length > 0) {
                                    progressBar.find('span').html(0 + "%");
                                    progressBar.find('.fileuploader-progressbar .bar').width(0 + "%");
                                    item.html.find('.progress-bar2').fadeOut(400);
                                }

                                item.upload.status != 'cancelled' && item.html.find('.fileuploader-action-retry').length == 0 ? item.html.find('.column-actions').prepend(
                                    '<a class="fileuploader-action fileuploader-action-retry" title="Retry"><i></i></a>'
                                ) : null;
                            },

                            onProgress: function (data, item, listEl, parentEl, newInputEl, inputEl) {
                                var progressBar = item.html.find('.progress-bar2');

                                if (progressBar.length > 0) {
                                    progressBar.show();
                                    progressBar.find('span').html(data.percentage + "%");
                                    progressBar.find('.fileuploader-progressbar .bar').width(data.percentage + "%");
                                }
                            }
                        },

                        files: this.documents,
                        captions: {
                            button: function (options) {
                                return 'Añadir documentos';
                            },
                            feedback: function (options) {
                                return 'Puedes arrastrar archivos a la pantalla para adjuntarlos';
                            },
                            feedback2: function (options) {
                                return options.length + ' ' + 'documentos';
                            },
                            confirm: 'Confirmar',
                            cancel: 'Cancelar',
                            name: 'Nombre',
                            type: 'Tipo',
                            size: 'Peso',
                            dimensions: 'Tamaños',
                            duration: 'Duración',
                            crop: 'Recortar',
                            rotate: 'Rotar',
                            download: 'Download',
                            remove: 'Borrar',
                            drop: 'Suelta los archivos que quieras adjuntar',
                            paste: '<div class="fileuploader-pending-loader"><div class="left-half" style="animation-duration: ${ms}s"></div><div class="spinner" style="animation-duration: ${ms}s"></div><div class="right-half" style="animation-duration: ${ms}s"></div></div> Pasting a file, click here to cancel.',
                            removeConfirmation: '¿Estás seguro? El documento no podrá ser recuperado ',
                            errors: {
                                filesLimit: 'Only ${limit} files are allowed to be uploaded.',
                                filesType: 'Only ${extensions} files are allowed to be uploaded.',
                                fileSize: '${name} is too large! Please choose a file up to ${fileMaxSize}MB.',
                                filesSizeAll: 'Files that you chose are too large! Please upload files up to ${maxSize} MB.',
                                fileName: 'File with the name ${name} is already selected.',
                                folderUpload: 'You are not allowed to upload folders.'
                            }
                        },

                        onRemove: function (item, listEl, parentEl, newInputEl, inputEl) {

                            that.$http.post('/admin/client/products/documents/delete', {idDocument: item.data.id});
                            return true;
                        },
                    });

                });


        }
    }
</script>

<style scoped>

</style>