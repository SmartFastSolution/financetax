<?php

namespace App\Http\Controllers\Sri;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SriController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function procesarComprobanteSRI(Request $request)
    {
        $archivo =  file_get_contents($request->file);
        $array = explode("\t", $archivo);

        $arrayComprobantes = [];
        foreach($array as $key => $item){
            if(strlen($item) == 49 && is_numeric($item)){
                $respuestaSRI = $this->autorizarComprobanteSRI($item);
                if(!is_array($respuestaSRI)){
                    $xmlRespuesta = $respuestaSRI->RespuestaAutorizacionComprobante->autorizaciones->autorizacion->comprobante;
                    $xml = new \SimpleXMLElement($xmlRespuesta);

                    $aux = [
                        'key'               => $key,
                        'ruc'               => (string) $xml->infoTributaria->ruc,
                        'fechaEmision'      => (string) $xml->infoFactura->fechaEmision,
                        'totalSinImpuestos' => (string) $xml->infoFactura->totalSinImpuestos,
                        'importeTotal'      => (string) $xml->infoFactura->importeTotal,
                    ];

                    array_push($arrayComprobantes,$aux);
                }else{
                    return 0;
                }
            }
        }
        return $arrayComprobantes;
    }

    public function autorizarComprobanteSRI($clave)
    {
        $webAutoriza = 'https://cel.sri.gob.ec/comprobantes-electronicos-ws/AutorizacionComprobantesOffline?wsdl';
        $parametrosAutoriza = array("claveAccesoComprobante" => $clave);

        try{
            $webServiceAutorizacion = new \SoapClient($webAutoriza);
            $result = $webServiceAutorizacion->autorizacionComprobante($parametrosAutoriza);
        }catch(\SoapFault $e){
            //$result =  $e->getMessage();
            $result =  [];

        }
        return $result;


    }
}
