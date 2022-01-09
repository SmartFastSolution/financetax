<template>
<div>
    <button @click="modalNuevoRegistro = true,resetForm()" class="btn btn-primary btn-sm mb-2" style="width: fit-content;">Nuevo Registro</button>
    <div class="card">
        <div class="card-body">
            <div class="col-lg-12 col-md-10">
                <div class="row justify-content-left">
                    <button class="floated btn btn-success btn-sm" @click="mostrarElementos('tblTransacciones_wrapper')">
                        Detalle &nbsp;<i class="fas fa-table"></i>
                    </button>
                    &nbsp;&nbsp;
                    <button class="floated btn btn-success btn-sm" id="btnGraficos" @click="mostrarElementos('divGraficos')">
                        Gr&aacute;ficos &nbsp;<i class="fas fa-chart-bar"></i>
                    </button>
                </div></br>
                <div class="row justify-content-center">
                    <div class="form-group col-6 col-md-3">
                        <label><b>Filtrar por fecha: </b></label>
                        <div class="input-group input-group-sm">
                            <input type="text" class="form-control form-control-sm inputDateRange">
                            <div class="input-group-prepend">
                                <button class="btn btn-outline-info resetDateFilter" type="button">
                                    <i class="fa fa-retweet"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <table id="tblTransacciones" class="table table-striped table-bordered table-sm" style="width:100%;">
                    <thead style="font-size:9.0pt;">
                        <tr>
                            <th class="text-center" style="width:100px;">Fecha de creaci&oacute;n</th>
                            <th style="width:150px;">Tipo Transacci&oacute;n</th>
                            <th class="text-center">Categor&iacute;a </th>
                            <th class="text-center">Detalle</th>
                            <th class="text-center" style="width:60px;">IVA</th>
                            <th class="text-center" style="width:60px;">Importe</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item in transacciones" :key="item.id">
                            <td class="text-center">{{ item.fecha }}</td>
                            <td v-if="item.tipo == 'EGRESOS'">
                                <i class="fas fa-minus-square" style="color: red;"></i>&nbsp;&nbsp;{{ item.tipo }}
                            </td>
                            <td v-if="item.tipo == 'INGRESOS'">
                                <i class="fas fa-plus-square" style="color: green;"></i>&nbsp;&nbsp;{{ item.tipo }}
                            </td>
                            <td>{{ item.categoria }}</td>
                            <td>{{ item.detalle }}</td>
                            <td class="text-right pr-4">${{ item.iva }}</td>
                            <td class="text-right pr-4">${{ item.importe }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row justify-content-center" id="divGraficos" style="display:none;">
            <div class="col-10">
                <highcharts :options="chartOptions"></highcharts>
            </div>
            </br>
            </br>
            <div class="col-10">
                <highcharts :options="chartOptionsPie"></highcharts>
            </div>
        </div>

        <!-- Modal Nuevo Registro -->
        <div class="modal" :class="{mostrar:modalNuevoRegistro}">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Registrar Comprobante</h4>
                        <button @click="cerrarModal()" type="button" class="close" >&times;</button>
                    </div>
                    <!-- Modal body -->
                    <form @submit.prevent="storeService" enctype="multipart/form-data" ref="form">
                    <div class="modal-body">
                        <div class="form-group row mb-2">
                            <label for="fecha" class="col-4 col-form-label"><b>Fecha</b></label>
                            <div class="col-8">
                                <input v-model="comprobante.fecha" type="date" class="form-control form-control-sm" id="fecha">
                            </div>
                        </div>
                        <div class="form-group row mb-2">
                            <label for="empresa" class="col-4 col-form-label"><b>Empresa</b></label>
                            <div class="col-8">
                                <select v-model="comprobante.empresa_transaccion" class="form-control form-control-sm" id="empresa">
                                    <option value="">Seleccionar</option>
                                    <option v-for="item in empresa" :key="item.id" :value="item.id" v-text="item.razon_social"></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row mb-2">
                            <label for="tipo" class="col-4 col-form-label"><b>Tipo de Transacción</b></label>
                            <div class="col-8">
                                <select v-model="comprobante.tipo_transaccion" class="form-control form-control-sm" id="tipo">
                                    <option value="">Seleccionar</option>
                                    <option v-for="item in tipoTransaccion" :key="item.id" :value="item.id" v-text="item.nombre"></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row mb-2">
                            <label for="tipo" class="col-4 col-form-label"><b>Categor&iacute;a</b></label>
                            <div class="col-8">
                                <select v-model="comprobante.tipo_categoria" class="form-control form-control-sm" id="categoria">
                                    <option value="">Seleccionar</option>
                                    <option v-for="item in categoria" :key="item.id" :value="item.id" v-text="item.descripcion"></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row mb-2">
                            <label for="cuenta" class="col-4 col-form-label"><b>Cuenta</b></label>
                            <div class="col-8">
                                <select v-model="comprobante.cuenta" class="form-control form-control-sm" id="cuenta">
                                    <option value="">Seleccionar</option>
                                    <option v-for="item in cuentas" :key="item.id" :value="item.id" v-text="item.cuenta"></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row mb-2">
                            <label for="tarifacero" class="col-4 col-form-label"><b>Tarifa 0%</b></label>
                            <div class="col-8">
                                 <money v-model="comprobante.tarifacero" class="form-control form-control-sm text-right" id="tarifacero"></money>
                            </div>
                        </div>
                        <div class="form-group row mb-2">
                            <label for="tarifadifcero" class="col-4 col-form-label"><b>Tarifa Dif. de 0%</b></label>
                            <div class="col-8">
                                 <money v-model="comprobante.tarifadifcero" class="form-control form-control-sm text-right" id="tarifadifcero"></money>
                            </div>
                        </div>
                        <div class="form-group row mb-2">
                            <label for="iva" class="col-4 col-form-label"><b>Iva</b></label>
                            <div class="col-8">
                                 <money v-model="comprobante.iva" class="form-control form-control-sm text-right" id="iva"></money>
                            </div>
                        </div>
                        <div class="form-group row mb-2">
                            <label for="importe" class="col-4 col-form-label"><b>Importe</b></label>
                            <div class="col-8">
                                 <money v-model="comprobante.importe" class="form-control form-control-sm text-right" id="importe"></money>
                            </div>
                        </div>
                        <div class="form-group row mb-2">
                            <label for="detalle" class="col-4 col-form-label"><b>Detalle</b></label>
                            <div class="col-8">
                                <input v-model="comprobante.detalle" type="text" class="form-control form-control-sm" id="detalle">
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row mb-2">
                            <label for="nota" class="col-4 col-form-label"><b>Nota</b></label>
                            <div class="col-8 text-right">
                                <a href="#" @click="abrirInputFile">
                                    <i class="fa fa-camera fa-2x" aria-hidden="true" id="fileIcon"></i>
                                </a>
                                <input type="file" @change="obtenerImagen" class="form-control form-control-sm d-none" id="inputFile" accept="image/*">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-12 text-center">
                                <figure v-if="imgFactura != ''">
                                    <img width="220" height="240" alt="Imagen" :src="imagen" class="img img-thumbnail">
                                </figure>
                                <div v-show="procesando">
                                    <span>Procesando...</span>
                                    <div class="spinner-grow spinner-grow-sm"></div>
                                    <div class="spinner-grow spinner-grow-sm"></div>
                                    <div class="spinner-grow spinner-grow-sm"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <span class="msjGuardando" style="display:none">
                            <span>Guardando registro...</span>
                            <div class="spinner-grow spinner-grow-lg text-secondary" role="status">
                            </div>
                        </span>
                        <button type="submit" class="btn btn-primary btn-sm">Guardar Registro</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
</template>
<script>
import datatable from 'datatables.net-bs4';
import datatableres from 'datatables.net-responsive';
import datatableresbs4 from 'datatables.net-responsive-bs4';
import moment from "moment";
import {Money} from 'v-money'
import Tesseract from 'tesseract.js';
import {Chart} from 'highcharts-vue'

/*var elemento = document.getElementById('btnDetalle');
elemento.addEventListener("click", function() {
   alert("You clicked me");
}​);​

function myFunction(idElemento) {
    var elemento = document.getElementById(idElemento);
    if(idElemento == "tblTransacciones"){
        //elemento.style.display = "block";
        var elementoOculta = document.getElementById("divGraficos");
        elementoOculta.style.display = "none";
    }else if(idElemento == "divGraficos"){
        //elemento.style.display = "block";
        var elementoOculta = document.getElementById("tblTransacciones");
        elementoOculta.style.display = "none";
    }
    elemento.style.display = "block";
}*/

var valorIngreso = 0;

function validaFormulario(){
    let respuesta = true;
    let arrayCampos = ['fecha',
                        'tipo',
                        'categoria',
                        'cuenta',
                        'tarifacero',
                        'tarifadifcero',
                        'iva',
                        'importe',
                        'detalle',
                        'inputFile'];

    arrayCampos.forEach( function(valor, indice) {
        let valorElemento = document.getElementById(valor).value;

        if(valorElemento === ""){
            respuesta = false;
            if(valor == "inputFile"){
                document.getElementById("fileIcon").style.color = "red";
            }else{
                document.getElementById(valor).style.borderColor = "red";
            }
        }else{
            if(valor == "inputFile"){
                document.getElementById("fileIcon").style.color = "#6777ef";
            }else{
                document.getElementById(valor).style.borderColor = "#e2e2e3";
            }
        }
    });
    return respuesta;
}

/*var observer = new IntersectionObserver(function(entries) {
	if(entries[0].isIntersecting === true)
		console.log('Element is fully visible in screen');
}, { threshold: [1] });

observer.observe(document.querySelector("#main-container"));*/

var elements = document.getElementsByClassName('applyBtn');
var requiredElement = elements[0];
console.log(elements);
/*requiredElement.addEventListener('click', function(e) {
    console.log("CLK");
}, false);*/

export default {
    props: ['listaTransacciones', 'subServicio', 'plan', 'tipoPlan', 'sumaIngresos', 'sumaEgresos', 'categorias'],
    data() {
        let arrayComprobantes = [];
        var resultado = [];
        let listaCategorias = JSON.parse(this.categorias);

        for (const key in listaCategorias){
            resultado.push({
                name: key,
                y: parseFloat(listaCategorias[key]),
            });
        }

        if (this.listaTransacciones.indexOf('},{') > -1)
        {
            let jsonstring = this.listaTransacciones.replace('[','').replace(']','').replaceAll('},{','}**STRINGSPLIT**{').replaceAll("'","");
            let split = jsonstring.split("**STRINGSPLIT**");
            if(split.length > 0)
            {
                split.forEach( function(valor, indice) {
                    arrayComprobantes.push(JSON.parse(valor));
                });
            }
        }else if (this.listaTransacciones.indexOf('{') > -1){
            let jsonstring = this.listaTransacciones.replace('[','').replace(']','').replaceAll("'","");
            arrayComprobantes.push(JSON.parse(jsonstring));
        }
        return {
            modalNuevoRegistro: false,
            procesando: false,
            imagenMiniatura: '',
            imgFactura: '',
            comprobante: {
                fecha: moment().format('YYYY-MM-DD'),
                tipo_transaccion: '',
                cuenta: '',
                tarifacero: 0,
                tarifadifcero: 0,
                iva: 0,
                importe: 0,
                detalle: '',
                tipo_categoria: '',
                empresa_transaccion: '',
            },
            tipoTransaccion: [],
            categoria: [],
            transacciones:arrayComprobantes,
            cuentas: [],
            empresa: [],
            chartOptions: {
                    series: [{
                        color: '#21618c',
                        data: [

                            {
                                name: 'INGRESOS',
                                color: '#28a745',
                                y: parseFloat(this.sumaIngresos)
                            },
                            {
                                name: 'EGRESOS',
                                color: '#dc3545',
                                y: parseFloat(this.sumaEgresos)
                            }
                        ],
                    }],
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: 'Resumen general'
                    },
                    plotOptions: {
                        bar: {
                            dataLabels: {
                                enabled: false,
                            },
                        },
                        column: {
                            pointWidth: 125,
                            borderWidth: 1
                        },
                    },
                    legend: {
                        enabled: false
                    },
                    yAxis: {
                        allowDecimals: false,
                        title: {
                            text: ''
                        }
                    },
                    xAxis: {
                        categories: ['INGRESOS','EGRESOS'],
                    },
                    tooltip: {
                        formatter: function () {
                        return "<b>$"+this.y+"</b>";
                        }
                    },
                },

                chartOptionsPie: {
                    series: [{
                        color: '#21618c',
                        data: resultado,
                    }],
                    chart: {
                        type: 'pie'
                    },
                    title: {
                        text: 'Resumen por categorías'
                    },
                    plotOptions: {
                        bar: {
                            dataLabels: {
                                enabled: false
                            },
                        },
                        column: {
                            pointWidth: 125,
                            borderWidth: 2
                        },
                    },
                    legend: {
                        enabled: true
                    },
                    yAxis: {
                        allowDecimals: true,
                        title: {
                            text: 'categoría'
                        }
                    },
                    tooltip: {
                        formatter: function () {
                        return "<b>$"+this.y+"</b>";
                        }
                    },
                },
        }
    },
    created() {
        this.listarTipoTransaccion();
        this.listarCategoria();
        this.listarCuentas();
        this.listarEmpresas();
        //this.$tablaGlobal("#tblTransacciones");
        this.generarDataTable();
    },
    components: {
        highcharts: Chart
    },
    methods: {
        mostrarElementos(idElemento){
            var elemento = document.getElementById(idElemento);
            if(idElemento == "tblTransacciones_wrapper"){
                var elementoOculta = document.getElementById("divGraficos");
                elementoOculta.style.display = "none";
            }else if(idElemento == "divGraficos"){
                var elementoOculta = document.getElementById("tblTransacciones_wrapper");
                elementoOculta.style.display = "none";
            }
            elemento.style.display = "block";
        },
        generarDataTable(){
            this.$nextTick(()=>{
                var minDateFilter = '';
                var maxDateFilter = '';

                $("#tblTransacciones").DataTable().destroy();
                var tabla = $("#tblTransacciones").DataTable({
                    "retrieve": true,
                    "bDeferRender": true,
                    "autoWidth": false,
                    "order": [[ 0, "desc" ]],
                    "search": {
                        "regex": true,
                        "caseInsensitive": false,
                    },
                    "destroy": true,
                    "sPaginationType": "full_numbers",
                    "language":{
                        "sProcessing":     "Procesando...",
                        "sLengthMenu":     "Mostrar _MENU_ registros",
                        "sZeroRecords":    "",
                        "sEmptyTable":     "No existen registros",
                        "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                        "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                        "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                        "sInfoPostFix":    "",
                        "sSearch":         "Buscar:",
                        "sUrl":            "",
                        "sInfoThousands":  ",",
                        "sLoadingRecords": "Cargando...",
                        "oPaginate": {
                            "sFirst":    "<i class='fa fa-fast-backward' aria-hidden='true'></i>",
                            "sLast":     "<i class='fa fa-fast-forward' aria-hidden='true'></i>",
                            "sNext":     "<i class='fa fa-step-forward' aria-hidden='true'></i>",
                            "sPrevious": "<i class='fa fa-step-backward' aria-hidden='true'></i>"
                        },
                        "oAria": {
                            "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                        }
                    },
                    "responsive": true,
                    //dom: 'Bfrtip',
                });

                $('.inputDateRange').daterangepicker({
                    startDate: moment(),
                    endDate: moment(),
                    locale: {
                        format: 'YYYY/MM/DD',
                        "separator": " - ",
                        "applyLabel": "Aplicar",
                        "cancelLabel": "Cancelar",
                        "fromLabel": "DE",
                        "toLabel": "HASTA",
                        "customRangeLabel": "Custom",
                        "daysOfWeek": [
                            "Dom",
                            "Lun",
                            "Mar",
                            "Mie",
                            "Jue",
                            "Vie",
                            "Sáb"
                        ],
                        "monthNames": [
                            "Enero",
                            "Febrero",
                            "Marzo",
                            "Abril",
                            "Mayo",
                            "Junio",
                            "Julio",
                            "Agosto",
                            "Septiembre",
                            "Octubre",
                            "Noviembre",
                            "Diciembre"
                        ],
                        "firstDay": 1,
                        "opens": "center",
                    }
                }, function(start, end, label) {
                    //console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
                    maxDateFilter = end;
                    minDateFilter = start;
                    tabla.draw();
                });

                $('.resetDateFilter').click(function(){
                    maxDateFilter = '';
                    minDateFilter = '';
                    tabla.draw();
                });

                $.fn.dataTableExt.afnFiltering.push(
                    function(oSettings, aData, iDataIndex){
                        if(typeof aData._date == 'undefined'){
                            aData._date = new Date(aData[0]).getTime();
                        }

                        if(minDateFilter && !isNaN(minDateFilter)){
                            if(aData._date < minDateFilter){
                                return false;
                            }
                        }

                        if(maxDateFilter && !isNaN(maxDateFilter)){
                            if(aData._date > maxDateFilter){
                                return false;
                            }
                        }
                        return true;
                    }
                );

            });
        },
        cerrarModal(){
            this.modalNuevoRegistro = false;
        },
        abrirInputFile(){
            $('#inputFile').click();
        },
        async obtenerImagen(e){
            var file = e.target.files[0];
            this.procesando = true;
            if(this.comprobante.importe == 0){
                var cero = 0;
                var difcero = 0;
                var importe = 0;
                var iva = 0;
                await Tesseract.recognize(file,'spa')
                    .progress(function(data){
                        //console.log(data.status)
                    })
                    .then(function(data){
                        data.lines.forEach((item,index,array) => {
                            if(item.text.match(/Tarifa 0.*/)){
                                var regex = /(\d.+)/g;
                                var valor = item.text.substr(-8);
                                cero = parseFloat(valor.match(regex));
                            }
                            if(item.text.match(/Tarifa 12.*/)){
                                var regex = /(\d.+)/g;
                                var valor = item.text.substr(-8);
                                difcero = parseFloat(valor.match(regex));
                            }
                            if(item.text.match(/IVA.*/)){
                                var regex = /(\d.+)/g;
                                var valor = item.text.substr(-8);
                                iva = parseFloat(valor.match(regex));
                            }
                            if(item.text.match(/TOTAL.*/)){
                                var regex = /(\d.+)/g;
                                var valor = item.text.substr(-8);
                                importe = parseFloat(valor.match(regex));
                            }
                        });
                    });
                this.comprobante.tarifacero = cero;
                this.comprobante.tarifadifcero = difcero;
                this.comprobante.importe = importe;
                this.comprobante.iva = iva;
            }

            this.procesando = false;
            this.imgFactura = file;
            this.cargarImagen(file);
        },
        cargarImagen(file){
            let reader = new FileReader();
            reader.onload = (e) => {
                this.imagenMiniatura = e.target.result;
            };
            reader.readAsDataURL(file);
        },
        async listarTipoTransaccion(){
            const respuesta = await axios.get('/admin/ingreso_facturas/listar_tipo_transaccion');
            this.tipoTransaccion = respuesta.data;
        },
        async listarCategoria(){
            const respuestaCategoria = await axios.get('/admin/ingreso_facturas/listar_categoria');
            this.categoria = respuestaCategoria.data;
        },
        async listarCuentas(){
            const respuestaCuentas= await axios.get('/admin/ingreso_facturas/listar_cuentas');
            this.cuentas = respuestaCuentas.data;
        },
        async listarEmpresas(){
            const respuestaEmpresas = await axios.get('/admin/ingreso_facturas/listar_empresas');
            this.empresa = respuestaEmpresas.data;
        },
        resetForm(){
            this.comprobante.fecha = moment().format('YYYY-MM-DD');
            this.comprobante.tipo_transaccion = '';
            this.comprobante.cuenta = '';
            this.comprobante.tarifacero = 0;
            this.comprobante.tarifadifcero = 0;
            this.comprobante.iva = 0;
            this.comprobante.importe = 0;
            this.imgFactura = '';
            this.imagenMiniatura = '';
            this.comprobante.detalle = '';
            this.comprobante.tipo_categoria = '';
            this.comprobante.empresa_transaccion = '';
        },
        storeService() {
            let respuestaValidacion = validaFormulario();

            if(respuestaValidacion){
                document.getElementsByClassName('msjGuardando')[0].style.display = "block";
                let set = this;
                let url = '/admin/ingreso_facturas/store';
                const config = {
                    headers: {
                        'content-type': 'multipart/form-data'
                    }
                };

                let file = document.getElementById('inputFile').files[0];
                let data = new FormData();

                data.append('fecha', this.comprobante.fecha);
                if (this.imgFactura !== null) {
                    data.append('imagenBase64', this.imagenMiniatura);
                    data.append('nombreFactura', file.name);
                }
                data.append('tipo_transaccion', this.comprobante.tipo_transaccion);
                data.append('cuenta', this.comprobante.cuenta);
                data.append('tarifacero', this.comprobante.tarifacero);
                data.append('tarifadifcero', this.comprobante.tarifadifcero);
                data.append('iva', this.comprobante.iva);
                data.append('importe', this.comprobante.importe);
                data.append('detalle', this.comprobante.detalle);
                data.append('tipo_categoria', this.comprobante.tipo_categoria);
                data.append('empresa_transaccion', this.comprobante.empresa_transaccion);
                data.append('estado', 'activo');
                data.append('subServicio',this.subServicio);
                data.append('plan',this.plan);

                let datos ={
                    url : url,
                    config: config,
                    data: data
                };

                axios.post(datos.url, datos.data, datos.config)
                    .then(function(res) {
                        //this.buttonDisable = true;
                        document.getElementsByClassName('msjGuardando')[0].style.display = "none";
                        //let link = "/admin/ingreso_facturas/ingreso_manual/"+this.subServicio+"/"+this.tipoPlan+"/";
                        //window.location = link;
                        window.location.href = window.location.href.split('#')[0];
                    })
                    .catch(function(error) {
                        //if (error.response.status == 422) {
                            //set.errors.record(error.response.datos.errors);
                        //}
                        //set.buttonDisable = false;
                    });
            }
        },
    },
    computed: {
        imagen(){
            return this.imagenMiniatura;
        }
    },
}
</script>
<style scoped>
.mostrar {
    display: list-item;
    opacity: 1;
    background-color: rgba(14, 21, 66, 0.445);
    overflow: auto;
}
.form-control-sm {
    height: calc(1.5em + .5rem + 2px) !important;
    padding: .25rem .5rem !important;
    font-size: .875rem !important;
    line-height: 1.5 !important;
    border-radius: .2rem !important;
}
</style>
