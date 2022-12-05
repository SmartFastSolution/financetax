<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Sri\SriController;
use App\Http\Controllers\IngresoComprobanteController;

Route::group(['middleware'=>['role_or_permission:cliente|c-servicios']], function(){
//Route::view('/admin/ingreso_facturas/sri', 'admin.ingreso_facturas.sri.index')->name('admin.ingreso_facturas.sri.index');

//Route::view('/admin/ingreso_facturas/sri/{id}/{tipoplan}/{usuarioEmpresa}', 'admin.ingreso_facturas.sri.index')->name('admin.ingreso_facturas.sri.index');
Route::get('/admin/ingreso_facturas/sri/{id}/{tipoplan}/{usuarioEmpresa}', [SriController::class,'index'])->name('admin.ingreso_facturas.sri.index');
Route::post('/admin/procesarComprobanteSRI',[SriController::class,'procesarComprobanteSRI'])->name('admin.procesarComprobanteSRI');
Route::post('/admin/guardarRegistrosAuto',[SriController::class,'guardarResgistrosAutomaticos'])->name('admin.guardarRegistrosAuto');
//Route::get('/admin/getInfoEmpresa',[SriController::class,'getInfoEmpresa'])->name('admin.getInfoEmpresa');

//Route::view('/admin/ingreso_facturas/ingreso_manual', 'admin.ingreso_facturas.ingreso_manual.index')->name('admin.ingreso_facturas.ingreso_manual.index');
Route::get('/admin/ingreso_facturas/ingreso_manual/{id}/{tipoplan}/{usuarioEmpresa}', [IngresoComprobanteController::class,'index'])->name('admin.ingreso_facturas.ingreso_manual.index');
Route::get('/admin/ingreso_facturas/listar_tipo_transaccion', [IngresoComprobanteController::class,'listarTipoTransaccion'])->name('admin.ingreso_facturas.listar_tipo_transaccion');
Route::get('/admin/ingreso_facturas/listar_comprobantes', [IngresoComprobanteController::class,'listarComprobantes'])->name('admin.ingreso_facturas.listar_comprobantes');
Route::get('/admin/ingreso_facturas/listar_categoria', [IngresoComprobanteController::class,'listarCategoria'])->name('admin.ingreso_facturas.listar_categoria');
Route::get('/admin/ingreso_facturas/listar_cuentas/{id}', [IngresoComprobanteController::class,'listarCuentas'])->name('admin.ingreso_facturas.listar_cuentas');
Route::get('/admin/ingreso_facturas/listar_empresas', [IngresoComprobanteController::class,'listarEmpresas'])->name('admin.ingreso_facturas.listar_empresas');
Route::get('/admin/ingreso_facturas/listar_empresas', [IngresoComprobanteController::class,'listarEmpresas'])->name('admin.ingreso_facturas.listar_empresas');
Route::post('/admin/ingreso_facturas/store', [IngresoComprobanteController::class,'store'])->name('admin.ingreso_facturas.store');

Route::get('/admin/ingreso_facturas/calendario/{id}/{tipoplan}/{usuarioEmpresa}', [IngresoComprobanteController::class,'listarCalendario'])->name('admin.ingreso_facturas.listarCalendario');

Route::post('/admin/ingreso_facturas/leer_factura', [IngresoComprobanteController::class,'leerFactura'])->name('admin.ingreso_facturas.leer_factura');

Route::get('/admin/exportarDocumentos/{id}', [IngresoComprobanteController::class,'exportarDocumentos']);
});