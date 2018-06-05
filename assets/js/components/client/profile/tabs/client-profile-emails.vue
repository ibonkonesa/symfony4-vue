<template>
    <div>

        <el-button @click="newEmailDialog = true" type="warning">Redactar email</el-button>
        <br><br>

        <paginated-table :row-click-function="showEmail" :extra-params="extraParams"
                         uri="/admin/client/emails" :columns="columns"></paginated-table>

        <el-dialog :visible.sync="showEmailDialog">

            <span slot="title" class="dialog-title">
               <h4>Asunto: {{ currentEmail.subject }}</h4>

                <ul v-if="currentEmail.attachments.length > 0">

                <li v-for="attachment in currentEmail.attachments ">
                    <a :href="attachment.link"
                       target="_blank"> {{ attachment.name }}</a>
                </li>

            </ul>

            </span>

            <span v-html="currentEmail.body"> </span>


            <span slot="footer" class="dialog-footer">

                <el-button type="primary" @click="showEmailDialog = false">Cerrar</el-button>
                <el-button v-if="currentEmail.typeId === 1" type="primary" @click="answerEmail">Responder</el-button>

            </span>

        </el-dialog>

        <el-dialog :visible.sync="newEmailDialog" title="Enviar correo">


            <el-form :model="newEmailForm" ref="emailForm">

                <el-form-item label="Para"
                              :rules="[$store.state.constants.requiredValidator,{ type: 'email', message: 'El destinatario debe ser una dirección email válida', trigger: 'submit' }]"
                              prop="to">
                    <el-input v-model="newEmailForm.to" auto-complete="off"></el-input>
                </el-form-item>


                <el-form-item label="Asunto"
                              :rules="$store.state.constants.requiredValidator"
                              prop="subject">
                    <el-input v-model="newEmailForm.subject" auto-complete="off"></el-input>
                </el-form-item>


                <el-form-item label="Contenido" prop="body"
                              :rules="$store.state.constants.requiredValidator">
                    <br>
                    <wysiwyg v-model="newEmailForm.body"></wysiwyg>

                </el-form-item>


                <el-form-item label="Adjuntos" prop="attachments">

                    <el-upload
                            action="/"
                            multiple
                            ref="attachments"
                            :auto-upload="false">
                        <el-button slot="trigger" size="small" type="primary">Seleccionar arhivos</el-button>
                    </el-upload>

                </el-form-item>

            </el-form>


            <span slot="footer" class="dialog-footer">
                <el-button v-loading="isSending" type="primary" @click="sendMail">Enviar</el-button>



            </span>

        </el-dialog>


    </div>
</template>

<script>
    import PaginatedTable from "../../../layout/paginated-table";
    import {EventBus} from '../../../../event-bus';

    export default {
        components: {
            PaginatedTable
        },
        name: "client-profile-emails",
        data() {
            return {

                newEmailForm: {
                    to: null,
                    subject: null,
                    body: null,
                    attachments: []

                },
                newEmailDialog: false,
                showEmailDialog: false,
                currentEmail: {
                    attachments: []
                },
                columns: [

                    {prop: 'type', label: 'Tipo'},
                    {prop: 'datetime', label: 'Fecha/Hora'},
                    {prop: 'subject', label: 'Asunto'}

                ],
                extraParams: {idClient: this.$store.state.client.currentClient.id},
                isSending: false
            }
        },


        methods: {

            answerEmail() {
                this.showEmailDialog = false;
                this.newEmailForm.to = this.currentEmail.from;
                this.newEmailForm.subject = 'Re: ' + this.currentEmail.subject;
                this.newEmailForm.body = 'En respuesta a: <br><br> ' + this.currentEmail.body;
                this.newEmailDialog = true;
            },
            sendMail() {

                this.$refs['emailForm'].validate((valid) => {
                    if (valid) {

                        this.isSending = true;
                        const formData = new FormData();

                        formData.append('idClient', this.$store.state.client.currentClient.id);
                        formData.append('to', this.newEmailForm.to);
                        formData.append('body', this.newEmailForm.body);
                        formData.append('subject', this.newEmailForm.subject);

                        this.$refs.attachments.uploadFiles.map(file => {
                            formData.append('files[]', file.raw);
                        });

                        this.$http.post('/admin/client/emails/send', formData)
                            .then(res => {

                                this.isSending = false;
                                this.$refs['emailForm'].resetFields();
                                this.$refs.attachments.clearFiles();
                                EventBus.$emit('reloadTable');
                                this.newEmailDialog = false;

                            });

                    } else {
                        return false;
                    }
                });


            },
            showEmail(email) {

                this.showEmailDialog = true;
                this.currentEmail = email;

            }

        }
    }
</script>

<style scoped>

</style>