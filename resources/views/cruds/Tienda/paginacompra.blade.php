@extends('layouts.app')

@section('content')

<div id="compraservicio">
<section class="section">
    <div class="section-body">
        @if ($data->isNotEmpty())
        @foreach ($data as $key=>$p)

        <div class="invoice">
            <div class="invoice-print">
              <div class="row">
                <div class="col-lg-12">
                  <div class="invoice-title">
                    <h2>{{$p->nombre}}</h2>
                    <div class="invoice-number"></div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-md-6">
                      <address>
                        <strong>Requerimientos:</strong><br>
                        Sarah Smith<br>
                        6404 Cut Glass Ct,<br>
                        Wendell,<br>
                        NC, 27591, USA
                      </address>
                    </div>
                    <div class="col-md-6 text-md-right">
                      <address>
                          {{-- datos por si acaso --}}
                        {{-- <strong>Shipped To:</strong><br>
                        Keith Johnson<br>
                        197 N 2000th E<br>
                        Rexburg, ID,<br>
                        Springfield Center, USA --}}
                      </address>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <address>
                        <strong>{{$p->nombre}}</strong><br>
                        <p>
                            {{$p->descripcion}}
                        </p>
                        
                      </address>
                    </div>
                    <div class="col-md-6 text-md-right">
                      <address>
                        <strong>Order Date:</strong><br>
                        June 26, 2018<br><br>
                      </address>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row mt-4">
                <div class="col-md-12">
                  <div class="section-title">Seleccionar Plan</div>
                  <div class="form-group col-md-6">
                    <model-list-select :list="tipoplans" v-model="tipoplan_id"   option-value="id"  
                    option-text="nombre"  placeholder="Seleccione un Tipo Servicio"  @input="searchPlan()">
                    </model-list-select>
                </div>
                  <div class="table-responsive">
                    <table class="table table-striped table-hover table-md">
                      <tr>
                        <th data-width="40">#</th>
                        <th>Item</th>
                        <th class="text-center">Price</th>
                        <th class="text-center">Quantity</th>
                        <th class="text-right">Totals</th>
                      </tr>
                    </table>
                  </div>
                  <div class="row mt-4">
                    <div class="col-lg-8">
                    
                    </div>
                    <div class="col-lg-4 text-right">
                      <div class="invoice-detail-item">
                        <div class="invoice-detail-name">Subtotal</div>
                        <div class="invoice-detail-value">$670.99</div>
                      </div>
                      <div class="invoice-detail-item">
                        <div class="invoice-detail-name">Shipping</div>
                        <div class="invoice-detail-value">$15</div>
                      </div>
                      <hr class="mt-2 mb-2">
                      <div class="invoice-detail-item">
                        <div class="invoice-detail-name">Total</div>
                        <div class="invoice-detail-value invoice-detail-value-lg">$685.99</div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <hr>
            <div class="text-md-right">
              <div class="float-lg-left mb-lg-0 mb-3">
                <button class="btn btn-primary btn-icon icon-left"><i class="fas fa-credit-card"></i> Realizar Compra
                  </button>
                <button class="btn btn-danger btn-icon icon-left"><i class="fas fa-times"></i> Cancel</button>
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
        el:"#compraservicio",
        name:"Compra Servicios",
        data:{
            tipoplans: plans,
            tipoplan_id: '',
            subservice_id:'',
            errors: new Errors,
            buttonDisable: false,
            plans :[],
        },

        methods: {
            
            //BUSCAR LOS PLANES DE LOS TIPOS DE PLANES
            searchPlan(){

                let id  = this.tipoplan_id;
                let id2 = this.subservice_id;
                let url = '/tienda/obtener-plan';
                axios.post(url,{
                    id:id,
                }).then(response=>{
                    this.plans = response.data;
                    console.log(response.data);
                }).catch(function(error){

                }); 
            },
        },

    })


</script>



    
@endsection