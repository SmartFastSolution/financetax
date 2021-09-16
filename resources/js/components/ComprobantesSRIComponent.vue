<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 text-center">
                                <div v-show="!ocultarDropZone">
                                    <h6>Haga click en el recuadro, o arrastre el archivo .txt</h6>
                                    <hr>
                                    <vue-dropzone ref="dropzone" id="dropzone"
                                        :options="dropzoneOptions"
                                        @vdropzone-success="archivoProcesado"
                                        @vdropzone-processing="inicioEnvio"
                                        @vdropzone-complete="cargaCompleta">
                                    </vue-dropzone>
                                </div>
                                <div class="alert alert-success" v-show="!ocultarCarga">
                                    <span class="h4">Procesando archivo, espere </span>
                                    <div class="spinner-grow spinner-grow-sm"></div>
                                    <div class="spinner-grow spinner-grow-sm"></div>
                                    <div class="spinner-grow spinner-grow-sm"></div>
                                </div>
                                <table class="table table-striped table-condensed table-bordered table-sm table-hover" v-show="!ocultarTabla">
                                    <thead>
                                        <th>N°</th>
                                        <th>Fecha Emisión</th>
                                        <th>RUC</th>
                                        <th>Total Sin Impuesto</th>
                                        <th>Importe Total</th>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(item,index) in comprobantes" :key="item.key">
                                            <td>{{ index + 1 }}</td>
                                            <td>{{ item.fechaEmision }}</td>
                                            <td>{{ item.ruc }}</td>
                                            <td>{{ item.totalSinImpuestos }}</td>
                                            <td>{{ item.importeTotal }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import vue2Dropzone from 'vue2-dropzone';
    import 'vue2-dropzone/dist/vue2Dropzone.min.css';

    export default {
        data(){
            return {
                dropzoneOptions: {
                    url: '/admin/procesarComprobanteSRI',
                    thumbnailWidth: 150,
                    maxFilesize: 1,
                    maxFiles: 1,
                    parallelUploads: 1,
                    dictDefaultMessage: 'Solo se permite archivo .txt',
                    dictRemoveFile: 'Quitar',
                    dictMaxFilesExceeded: 'Solo 1 archivo',
                    dictFileTooBig: 'Archivo excede el tamaño permitido',
                    uploadMultiple: false,
                    acceptedFiles: "text/plain",
                    autoProcessQueue: true,
                    addRemoveLinks: true,
                    headers: {
                        "X-CSRF-TOKEN": document.head.querySelector("[name=csrf-token]").content
                    },
                },
                comprobantes: [],
                ocultarDropZone: false,
                ocultarCarga: true,
                ocultarTabla: true,
            }
        },
        components: {
            vueDropzone: vue2Dropzone,
        },
        mounted() {

        },
        methods: {
            archivoProcesado: async function (response) {
                let resp = JSON.parse(response.xhr.response);
                if(resp != 0){
                    this.comprobantes = resp;
                    this.ocultarDropZone = true;
                    this.ocultarCarga = true;
                    this.ocultarTabla = false;
                }else{
                    this.$toast.error('Error!', 'Se ha producido un error, vuelva a intentar');
                    this.ocultarDropZone = false;
                    this.ocultarCarga = true;
                    this.ocultarTabla = true;
                }
            },
            inicioEnvio: function(){
                this.ocultarDropZone = true;
                this.ocultarCarga = false;
            },
            resetDropZone: function(file){
                this.$refs.dropzone.removeFile(file);
                this.ocultarDropZone = true;
                this.ocultarCarga = true;
                this.ocultarTabla = false;
            },
            cargaCompleta(file){
                this.$refs.dropzone.removeFile(file);
            }
        }
    }
</script>
