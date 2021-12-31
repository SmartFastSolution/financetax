<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Sri\SriController;
use App\Http\Controllers\IngresoComprobanteController;

//Route::view('/admin/ingreso_facturas/sri', 'admin.ingreso_facturas.sri.index')->name('admin.ingreso_facturas.sri.index');

Route::view('/admin/ingreso_facturas/sri/{id}/{tipoplan}', 'admin.ingreso_facturas.sri.index')->name('admin.ingreso_facturas.sri.index');
Route::post('/admin/procesarComprobanteSRI',[SriController::class,'procesarComprobanteSRI'])->name('admin.procesarComprobanteSRI');

//Route::view('/admin/ingreso_facturas/ingreso_manual', 'admin.ingreso_facturas.ingreso_manual.index')->name('admin.ingreso_facturas.ingreso_manual.index');
Route::get('/admin/ingreso_facturas/ingreso_manual/{id}/{tipoplan}', [IngresoComprobanteController::class,'index'])->name('admin.ingreso_facturas.ingreso_manual.index');
Route::get('/admin/ingreso_facturas/listar_tipo_transaccion', [IngresoComprobanteController::class,'listarTipoTransaccion'])->name('admin.ingreso_facturas.listar_tipo_transaccion');
Route::get('/admin/ingreso_facturas/listar_comprobantes', [IngresoComprobanteController::class,'listarComprobantes'])->name('admin.ingreso_facturas.listar_comprobantes');
Route::get('/admin/ingreso_facturas/listar_categoria', [IngresoComprobanteController::class,'listarCategoria'])->name('admin.ingreso_facturas.listar_categoria');
Route::get('/admin/ingreso_facturas/listar_cuentas', [IngresoComprobanteController::class,'listarCuentas'])->name('admin.ingreso_facturas.listar_cuentas');
Route::get('/admin/ingreso_facturas/listar_empresas', [IngresoComprobanteController::class,'listarEmpresas'])->name('admin.ingreso_facturas.listar_empresas');
Route::post('/admin/ingreso_facturas/store', [IngresoComprobanteController::class,'store'])->name('admin.ingreso_facturas.store');