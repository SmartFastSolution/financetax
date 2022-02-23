@extends('layouts.app')

@section('content')

    <div id="compraservicio">
        <section class="section">
            <div class="section-body">
                @if ($data->isNotEmpty())
                    @foreach ($data as $key => $p)

                        <div class="invoice">
                            <div class="invoice-print">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="invoice-title">
                                            <h2>{{ $p->nombre }}</h2>
                                            <div class="invoice-number"></div>
                                        </div>
                                        <hr>
                                        <div class="alert alert-success text-left" role="alert" id="alertaGuardado" style="display:none;">
                                            <h5 class="alert-heading"><i class="fas fa-check-circle font-15"></i>&nbsp;
                                                ¡Plan obtenido de forma exitosa!
                                            </h5>
                                            <h5>
                                                &nbsp;&nbsp;&nbsp;&nbsp;
                                                Un asesor se contactar&aacute; con usted para activar el plan obtenido.
                                            </h5>
                                            <div class="fa-2x">
                                                <h6><i class="fas fa-sync fa-spin font-15"></i>&nbsp;&nbsp;Redirigiendo...</h6>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <address style="text-align: justify;">
                                                    <p>
                                                        {!!htmlspecialchars_decode($p->descripcion)!!}
                                                    </p>
                                                </address>
                                            </div>
                                            <div class="col-md-6 text-md-right">

                                                <div class="card" style="background-color: #efeeff;">
                                                    <div class="card-header">
                                                        <h3>Planes Disponibles</h3>
                                                    </div>
                                                    <div class="card-body">
                                                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                                                            <li class="nav-item" v-for="(tipo, index) in tipoplans" :key="tipo.id">
                                                                <a class="nav-link " ref="index" :class="index == 0 ? 'active' : '' "  id="home-tab2"
                                                                    data-toggle="tab" href="#home" role="tab"
                                                                    aria-controls="home"
                                                                    aria-selected="true" @click="mostrardetalle(tipo)" ><b>@{{ tipo . nombre }}</b>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                        <div class="tab-content" id="myTab3Content">
                                                            <div class="tab-pane fade show active"  id="home" role="tabpanel" aria-labelledby="home-tab2">
                                                                <p><span align="left" v-html="detalle.descripcion"></span></p>
                                                                <br>
                                                                <span class="text-center center-align"><h2><strong >$@{{detalle.costo}}</strong>&nbsp;/&nbsp;mes</h2></span>
                                                                <br>
                                                                @if(!$empresas->isEmpty() && $empresas->count() > 1)
                                                                    <div class="alert alert-primary text-left" role="alert">
                                                                        <h6 class="alert-heading"><i class="fas fa-exclamation-circle font-15"></i>&nbsp;
                                                                            Usted cuenta con <b>{{$empresas->count()}} empresas añadidas</b>, por favor escoger la empresa para proceder con la compra.
                                                                        </h6>
                                                                    </div>
                                                                <br>
                                                                @endif
                                                                    <input id="contadorEmpresas" value="{{$empresas->count()}}" hidden>
                                                                    <div class="alert alert-danger text-left" role="alert" id="alertaDuplicado" style="display:none;">
                                                                        <h6 class="alert-heading"><i class="fas fa-exclamation-triangle font-15"></i>&nbsp;
                                                                            Usted ya realiz&oacute; la compra de este plan para la empresa <b><u><span id="textoDuplicado"></span></u></b>.
                                                                            <br><br>
                                                                            Por favor elija otra empresa y otro plan o comun&iacute;quese con uno de nuestros asesores.
                                                                        </h6>
                                                                    </div>
                                                                    @if(!$empresas->isEmpty())

                                                                        @if($empresas->count() > 1)
                                                                        <div class="row justify-content-center align-self-center">
                                                                            <label class="align-bottom"> <b>Empresas Añadidas:&nbsp;</b></label>
                                                                            <select class="form-select" id="selectEmpresa" @change="selectEmpresa(this)">
                                                                            <option value="">Seleccionar Empresa</option>
                                                                            @foreach ($empresas as $keyEmpresa => $e)
                                                                                <option value="{{$e->id}}">{{$e->razon_social}}</option>
                                                                            @endforeach
                                                                            </select>
                                                                        </div>
                                                                        <br>
                                                                        @endif

                                                                        @if($empresas->count() == 1)
                                                                        <div class="row justify-content-center align-self-center" hidden>
                                                                            <label class="align-bottom"> <b>Empresas Añadidas:&nbsp;</b></label>
                                                                            <select class="form-select" id="selectEmpresa" @change="selectEmpresa(this)">
                                                                            <option value="0" selected>Seleccionar Empresa</option>
                                                                            </select>
                                                                        </div>
                                                                        <br>
                                                                        @endif
                                                                        <div class="text-md-right">
                                                                            <div class="float-lg-left mb-lg-0 mb-3">
                                                                            <button class="btn btn-success btn-icon icon-left" :disabled="buttonDisable"
                                                                                @click.prevent="validaciones('pendiente')">
                                                                                <h6><i class="fas fa-money-check-alt"></i>&nbsp;Comprar Plan</h6></button>
                                                                            </div>
                                                                        </div>
                                                                    @else
                                                                    <div class="alert alert-danger text-left" role="alert">
                                                                        <h6 class="alert-heading"><i class="fas fa-exclamation-triangle font-15"></i>&nbsp;No tiene empresas asignadas.
                                                                        <br>
                                                                        Para asignar empresas <a href="{{route('admin.mis.empresas')}}" class="alert-link">IR AL SIGUIENTE LINK.</a></h6>
                                                                    </div>
                                                                    @endif
                                                                    <br>
                                                                    {{-- <button class="btn btn-warning btn-icon icon-left"><i class="fas fa-print"></i> Print</button> --}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="text-md-right">
                                <div class="float-lg-left mb-lg-0 mb-3">
                                    <a type="button" class="btn btn-danger btn-icon icon-left" href="{{route('tienda.index',)}}" >
                                        <i class="fas fa-times font-15"></i>&nbsp;Cancelar
                                    </a>
                                </div>
                                <br>
                                {{-- <button class="btn btn-warning btn-icon icon-left"><i class="fas fa-print"></i> Print</button> --}}
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </section>

    </div>

@endsection


@section('js')

    <script type="text/javascript">
         class Errors {
            constructor() {
                this.errors = {}
            }
            has(field) {
                return this.errors.hasOwnProperty(field);
            }
            get(field) {
                if (this.errors[field]) {
                    return this.errors[field][0]
                }
            }
            record(errors) {
                this.errors = errors;
            }
            any() {
                return Object.keys(this.errors).length > 0;
            }
            anyfiles(query) {
                const asArray = Object.entries(this.errors);
                //const atLeast9Wins = asArray.filter(([key, value]) => key !== 'fecha_atencion' && key !== 'responsable_id' && key !== 'detalle_atencion' && key !== 'observacion' );
                const atLeast9Wins = asArray.filter(([key, value]) => key.toLowerCase().indexOf(query.toLowerCase()) > -
                    1);
                const atLeast9WinsObject = Object.fromEntries(atLeast9Wins);

                return Object.keys(atLeast9WinsObject).length > 0;
            }
            archivos(query) {
                const asArray = Object.entries(this.errors);
                //const atLeast9Wins = asArray.filter(([key, value]) => key !== 'fecha_atencion' && key !== 'responsable_id' && key !== 'detalle_atencion' && key !== 'observacion' );
                const atLeast9Wins = asArray.filter(([key, value]) => key.toLowerCase().indexOf(query.toLowerCase()) > -
                    1);
                const atLeast9WinsObject = Object.fromEntries(atLeast9Wins);
                return atLeast9WinsObject;
            }

        }

        let plans = @json($tipoplan);
        const compraservicio = new Vue({
            el: "#compraservicio",
            name: "Compra Servicios",
            data: {
                tipoplans: plans,
               
                buttonDisable: false,
                plans: [],
                detalle:{
                    costo:'',
                    descripcion:'',
                    subservice_id:'',
                    errors: new Errors,
                    tipoplan_id: '',
                    plan_id:'',

                },
            },

            mounted() {
                let empresas = document.getElementById("contadorEmpresas");
                if(empresas.value > 1)
                    this.buttonDisable = true;

                var tp = this.tipoplans;

                this.tipoplans.forEach((element ,index, array) => {
                    //console.log(element);
                    if (index == 0) {
                        this.detalle.costo = element.costo;
                        this.detalle.descripcion = element.descripcion;
                        this.detalle.subservice_id = element.subservice_id;
                        this.detalle.tipoplan_id = element.tipoplan_id;
                        this.detalle.plan_id = element.id;
                    }
                });
            },

            methods: {
                selectEmpresa(element) {
                    if(element.value !== ''){
                        this.buttonDisable = false;
                    }else{
                        this.buttonDisable = true;
                    }
                },
            
                mostrardetalle(tipo){
                  
                    this.detalle.costo = tipo.costo;
                    this.detalle.descripcion = tipo.descripcion;
                    this.detalle.subservice_id = tipo.subservice_id;
                    this.detalle.tipoplan_id = tipo.tipoplan_id;
                }, //end mostrardetalle

                validaciones(estado){
                    let empresa = document.getElementById('selectEmpresa').selectedOptions[0].value;

                    let dataValida = new FormData();
                    dataValida.append('subservice_id', this.detalle.subservice_id);
                    dataValida.append('tipoplan_id', this.detalle.tipoplan_id);
                    dataValida.append('plan_id', this.detalle.plan_id);
                    dataValida.append('empresa', empresa);

                    let data ={ data: dataValida };
                    let flagValida = false;

                    axios.post('/tienda/consultaEmpresa', data.data)
                    .then(function(res){
                        flagValida = res.data.flag;
                    });
                        /*.catch(function(error) {
                            if (error.response.status == 422) {
                                set.errors.record(error.response.data.errors);
                            }
                            set.buttonDisable = false;
                        });*/

                    if(flagValida == true){
                        document.getElementById("textoDuplicado").textContent = res.data.empresa;
                        let elementoOculta = document.getElementById("alertaDuplicado");
                        elementoOculta.style.display = "block";
                        this.buttonDisable = true;
                    }else{
                        let datos = this.createData(estado, empresa);
                        return this.StoreData(datos);
                    }

                    //let datos = this.createData(estado, empresa);
                    //return this.StoreData(datos);
                }, //end validacion

                createData(estado, empresa){
                    let set = this;
                    let url ='/tienda/storeplan';
                    
                    let data = new FormData();
                    data.append('subservice_id', this.detalle.subservice_id);
                    data.append('tipoplan_id', this.detalle.tipoplan_id);
                    data.append('costo', this.detalle.costo);
                    data.append('plan_id', this.detalle.plan_id);
                    data.append('estado', estado);
                    data.append('empresa', empresa);
                    
                    let datos ={
                        url: url,
                        data: data 
                    };
                    return datos;

                }, //createdata End
                
                StoreData(data){
                    let set = this;
                    axios.post(data.url, data.data)
                    .then(function(res){
                        this.buttonDisable = true;
                        document.getElementById('alertaGuardado').style.display = 'block';
                        setTimeout(function () {
                            //window.location.href = window.location.href;
                            let link = '{{ route('tienda.index')}}';
                            window.location = link;
                        }, 2500);
                        //let link = '{{ route('tienda.index')}}';
                        //window.location = link;
                    })
                    .catch(function(error) {
                        if (error.response.status == 422) {
                            set.errors.record(error.response.data.errors);
                        }
                        set.buttonDisable = false;
                    });

                }, //end storedata
                
            },

        });
    </script>




@endsection
