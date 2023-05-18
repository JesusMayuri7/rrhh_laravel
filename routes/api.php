<?php

use App\Http\Controllers\CasController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/welcome', function () {
    return view('welcome');
});

Route::post('/presupuestal/certificacion/importar','CertificacionPresuController@import'); 
Route::post('/cas/nueva_publicacion','CasController@nueva_publicacion'); 

//DOCUMENTOS
Route::get('/documentos','DocumentosController@list'); 
Route::post('/documentos','DocumentosController@create'); 
Route::put('/documentos/{id}','DocumentosController@update'); 
Route::delete('/documentos/{id}','DocumentosController@delete'); 
Route::post('/documentos/import','DocumentosController@import'); 

//JUDICIALES
Route::get('/judiciales','JudicialesController@list'); 
Route::post('/judiciales','JudicialesController@create'); 
Route::put('/judiciales/{id}','JudicialesController@update'); 
Route::delete('/judiciales/{id}','JudicialesController@delete'); 

Route::post('/judiciales_detail','JudicialesController@create_detail');


Route::group(['middleware' => 'jwt.verify'], function() {
    Route::post('/cas/planilla/importar','PlanillaCasController@import'); 
    
    // SUBSIDIO DEVOLUCIONES
    Route::get('/subsidio/devolucion/{anio}','SubsidioController@getDevolucion');
    Route::post('/subsidio/new_subsidio','SubsidioController@newSubsidio'); 

    // HOME
   Route::get('/home/devengado_total','HomeController@devengadoTotal');
   Route::get('/home/cap_estado_opp','HomeController@capEstadoOpp');

   //TODO
   Route::delete('/todo/{id}','TodoController@delete'); 
    Route::get('/todo','TodoController@index'); 
    Route::get('/todo_anio/{anio}','TodoController@index_anio'); 
    Route::post('/todo','TodoController@save'); 

    //CONFIGURACION
    Route::get('/configuracion/laudos','ConfiguracionController@laudos'); 
    Route::get('/configuracion/convocatorias','ConfiguracionController@convocatorias'); 
    Route::get('/configuracion/certificados','ConfiguracionController@certificados'); 
    Route::get('/configuracion/mop','ConfiguracionController@mop'); 
    Route::get('/configuracion/modalidades/{anio}','ConfiguracionController@modalidades');  
    Route::get('/configuracion/get_areas','ConfiguracionController@areas');

    Route::get('/presupuestal/dependencias','PresupuestoController@dependencias'); 

    //FORMATIVA
    Route::get('/formativa/base_formativa','FormativaController@base_formativa'); 
    Route::get('/formativa/base_formativa_anio/{anio}','FormativaController@base_formativa_anio'); 
    Route::post('/formativa/base_formativa_alta_baja','FormativaController@base_formativa_alta_baja'); 
    Route::get('/formativa/siga_formativa','FormativaController@siga_formativa'); 
    Route::get('/formativa/airhsp_formativa','AirHspFormativaController@airhsp_formativa'); 
    Route::post('/formativa/base_formativa_update','FormativaController@base_formativa_update'); 
    Route::post('/formativa/base_formativa_updated','FormativaController@base_formativa_updated'); 
    Route::delete('/formativa/base_formativa_remove/{id}','FormativaController@base_formativa_remove'); 
    Route::post('/formativa/planilla/planilla_formativa_anual','PlanillaFormativaController@planilla_formativa_anual'); 
    Route::post('/formativa/planilla/importar','PlanillaFormativaController@import'); 

    Route::get('/formativa/base_formativa_proyeccion_ejec','FormativaController@base_formativa_proyeccion_ejec'); 
    Route::post('/formativa/planilla/proyeccion_cas','FormativaController@proyeccion_formativa'); 
    Route::get('/formativa/planilla/planilla_formativa','PlanillaFormativaController@planilla_formativa'); 
    Route::post('/formativa/personal/personal_formativa_import','PersonalFormativaController@import'); 
    Route::post('/formativa/airhsp/importar','AirHspFormativaController@import'); 
    Route::get('/formativa/certificado/{anio}','CertificadoController@certificadoPracticante'); 

    Route::get('/activos/pap/{anio}','PapController@index'); 
    Route::get('/activos/pap_air','PapController@pap_air'); 
    Route::get('/activos/area','CapController@area'); 
    Route::get('/activos/unidad','CapController@unidad'); 
    Route::get('/activos/escala','CapController@escala'); 
    Route::get('/activos/estado','CapController@estados'); 
    Route::post('/activos/trabajador/dni','TrabajadorController@getNombres'); 
    Route::post('/activos/trabajador/nuevo','TrabajadorController@postDni'); 
    Route::get('/activos/matriz_data','CapController@matriz_data'); 
    Route::post('/activos/matriz_control','CapController@matriz_control'); 
    Route::post('/activos/nuevo_matriz','CapController@nuevo_matriz'); 
    Route::get('/activos/cap/{anio}','CapController@index'); 
    Route::get('/activos/airhsp','AirHspController@index'); 
    Route::post('/activos/airhsp/importar','AirHspController@import'); 
    //Route::get('/activos/airhsp/importar','AirHspController@import'); 

    Route::get('/cap/siga_net_cap','CapController@siga_net_cap'); 
    Route::get('/cap/dependencias','CapController@dependencias'); 
    Route::get('/cap/rpt_vigente_cap','CapController@cap_rpt_vigente'); 
    Route::post('/cap/planilla/planilla_cap_anual','PlanillaCapController@planilla_cap_anual'); 
    Route::post('/cap/personal/personal_cap_import','PersonalCapController@import'); 
    Route::post('/cap/planilla/planilla_cap_import','PlanillaCapController@import'); 
    Route::post('/cap/planilla/planilla_cap_cts_import','PlanillaCapController@import_cts'); 
    Route::get('/cap/planilla/planilla_cap/{anio}','PlanillaCapController@index'); 
    Route::get('/cap/base_cap_id/{cap_id}','CapController@base_cap_id'); 
    Route::get('/cap/base_cap_anio/{anio}','CapController@base_cap_anio'); 
    Route::get('/cap/base_cap','CapController@base_cap');
    Route::put('/cap/base_cap/cap_baja','CapController@cap_baja'); 
    Route::post('/cap/base_cap/pap_alta','CapController@pap_alta'); 
    Route::put('/cap/base_cap_update','CapController@base_cap_update'); 
    Route::post('/cap/planilla/proyeccion_dos_cap','PlanillaCapController@proyeccion_dos_cap'); 

    Route::get('/cap/certificado/{anio}','CertificadoController@certificadoCap'); 
    Route::get('/cap/presupuesto/{anio}','PresupuestoController@presupuestoCap'); 
    Route::get('/cap/presupuesto_2023','PresupuestoController@presupuestoCap2023'); 
    Route::get('/reporte/rpt_cantidad_modalidad','ReporteController@rpt_cantidad_modalidad'); 



    Route::get('/tramite/certificacion','CasController@certificacion'); 
    Route::put('/tramite/certificacion','CertificacionController@certificacion_update');
    Route::put('/cas/certificacion_update_solicitud','CertificacionController@update_solicitud'); 

    
    Route::post('/tramite/certificacion','CasController@certificacion_create');
    Route::get('/tramite/certificacion_plazas','CertificacionController@certificacion_plazas');
    Route::post('/tramite/certificacion_plaza_update','CertificacionController@certificacion_plaza_update');
    Route::post('/cas/certificacion_validar','CertificacionController@validar'); 


    Route::post('cas/create_certificacion_detalle_publicacion','CasController@create_certificacion_detalle_publicacion' ); 
    Route::put('/cas/certificacion_cargo_update','CasController@certificacion_cargo_update');
    Route::get('/cas/airhsp','AirHspCasController@index_cas'); 
    Route::get('/cas/base_cas/{anio}','CasController@base_cas'); 
    Route::get('/cas/base_cas_proyeccion/{anio}','CasController@base_cas_proyeccion'); 
    Route::get('/cas/base_cas_historial/{base_cas_id}','CasController@base_cas_historial'); 
    Route::put('/cas/base_cas','CasController@cas_update'); 
    Route::get('/cas/certificados','CasController@certificados'); 
    Route::get('/cas/unidades_metas','AirHspCasController@unidades_metas'); 
    Route::post('/cas/convocatoria','CasController@nueva_convocatoria'); 
    Route::post('/cas/convocatorias','ConvocatoriaController@nueva_convocatoria'); 
    
    Route::get('/cas/publicacion','CasController@lista_publicacion'); 
    Route::post('/cas/nueva_plaza','AirHspCasController@nueva_plaza'); 
    Route::put('/cas/base_cas_update','CasController@base_cas_update'); 
    

    Route::get('/cas/siga_net_ingresos','CasController@siga_net_ingresos'); 
    Route::get('/cas/certificado/{anio}','CertificadoController@certificadoCas'); 

    Route::get('/cas/metas','CertificacionController@metas'); 

    Route::get('/requerimientos/{anio}','RequerimientosController@index'); 


    Route::post('/cas/convocatoria/nueva_convocatoria','ConvocatoriaController@nueva_convocatoria'); 
    Route::get('/cas/convocatoria/list_convocatoria','ConvocatoriaController@list_convocatoria'); 
    
    Route::post('/cas/personal/importar','CasController@import_personal_cas'); 
    Route::post('/cas/planilla/planilla_cas_anual','PlanillaCasController@planilla_cas_anual'); 
    Route::post('/cas/planilla/proyeccion_cas','PlanillaCasController@proyeccion_cas'); 
    Route::post('/cas/planilla/proyeccion_dos_cas','PlanillaCasController@proyeccion_dos_cas'); 
    Route::post('/cas/planilla/proyeccion_tres_cas','PlanillaCasController@proyeccion_tres_cas'); 
    Route::get('/cas/planilla/planilla_cas/{anio}','PlanillaCasController@planilla_cas'); 
    Route::post('/cas/airhsp/importar','AirHspCasController@import'); 
    Route::get('/cas/personal/nuevo_designacion','CasController@lista_designacion'); 
    Route::get('/cas/personal/nuevo_concurso','CasController@lista_concurso'); 

    Route::post('/cas/base_cas/nuevo_designacion','CasController@cas_designacion'); 
    Route::put('/cas/base_cas/cas_baja','CasController@cas_baja'); 
    Route::put('/cas/base_cas/cas_alta','CasController@cas_alta'); 

    
    
    Route::post('/presupuestal/devengado/importar','DevengadoController@import'); 
    Route::get('/presupuestal/resumen','PresupuestoController@resumen'); 
    Route::get('/presupuestal/certificacion','PresupuestoController@certificacion'); 
    Route::get('/presupuestal/certificacion/{anio}','PresupuestoController@certificacion_anio'); 
    Route::get('/presupuestal/ejecucion','PresupuestoController@ejecucion'); 
    Route::post('/presupuestal/variables','PresupuestoController@variables'); 

    Route::get('/presupuestal/presupuesto_cas/{anio}','PresupuestoController@presupuesto_cas'); 
    Route::get('/presupuestal/presupuesto_cas2023','PresupuestoController@presupuesto_cas2023'); 
    Route::get('/presupuestal/presupuesto_cas_ley','PresupuestoController@presupuesto_cas_ley'); 

    Route::get('/liquidacion/cas/{anio}','LiquidacionController@getLiquidacionCas'); 
    Route::get('/liquidacion/report/{anio}','LiquidacionController@getLiquidacionReport'); 
    Route::get('/liquidacion/report_siaf/{anio}','LiquidacionController@getLiquidacionReportSiaf'); 
    Route::get('/liquidacion/report_siaf_all/{anio}','LiquidacionController@getLiquidacionReportSiafAll'); 
    Route::post('/liquidacion/resumen_liquidacion','LiquidacionController@getLiquidacionResumenLiquidacion'); 
    Route::post('/liquidacion/resumen_siaf','LiquidacionController@getLiquidacionResumenSiaf'); 
    Route::post('/liquidacion/update_liquidacion_detalle','LiquidacionController@updateLiquidacionDetelle'); 
    Route::post('/liquidacion/update_liquidacion','LiquidacionController@updateLiquidacion'); 
    Route::post('/liquidacion/add_liquidacion','LiquidacionController@create'); 

    Route::get('/servicios/organigrama','OrganigramaController@index'); 
    Route::get('/servicios/servicios','ServiciosController@index'); 
    Route::post('/servicios/ordenes','ServiciosController@orden'); 
    Route::post('/servicios/nuevo_servicio','ServiciosController@nuevo_servicio'); 
    Route::post('/servicios/nuevo_personal','ServiciosController@nuevo_personal'); 
    Route::post('/servicios/siga/importar','OrdenController@import'); 
    Route::post('/servicios/sigaz/listar','OrdenController@listarz'); 
    Route::post('/servicios/sigaz/importar','OrdenController@importZ'); 
    Route::post('/servicios/sede/actualizar_tiempo','OrdenController@actualizar_tiempo'); 
    Route::get('/servicios/ordenes_sigamef_export','OrdenController@export'); 
    Route::post('/servicios/sede/actualizar_control','OrdenController@actualizar_control'); 
    Route::post('/servicios/zonal/actualizar_control','OrdenController@actualizar_control_z'); 
    Route::get('/servicios/sede/ordenes_pendientes_tiempo','OrdenController@ordenes_pendientes_tiempo'); 
    Route::delete('/servicios/personal/eliminar/{id}','ServiciosController@eliminar_personal'); 

    Route::get('/control/designaciones_index/{anio}','DesignacionController@index'); 
    Route::put('/control/designaciones_update','DesignacionController@update'); 
    Route::post('/control/designaciones_create','DesignacionController@create'); 

    Route::post('/presupuesto/importar','PresupuestoController@import');
    Route::get('/presupuesto_export/{mes}','PresupuestoController@export'); 
    Route::get('/presupuesto/metas/{anio}','PresupuestoController@metas');
    Route::get('/presupuesto/get_fuentes','PresupuestoController@getFuentes');

    Route::get('/presupuesto/get_metas/{anio}','PresupuestoController@getMetas');
    Route::get('/presupuesto/{mes}','PresupuestoController@index'); 
    Route::post('/presupuesto/save_certificado','CertificadoController@save'); 
    Route::get('/presupuesto/certificados/{anio}','CertificadoController@certificados'); 
    Route::post('/validar_certificado','CertificadoController@index'); 
    Route::get('/modalidad_concepto_clasificador','PresupuestoController@get_modalidad_concepto_clasificador'); 

    Route::get('/presupuesto/clasificador/{anio}','PresupuestoController@getClasificadores'); 
    Route::get('/presupuesto/clasificador/cap','PresupuestoController@getClasificadoresCap'); 

});


// LOGIN
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {	
	Route::post('register', 'AuthController@register');
    Route::post('me', 'AuthController@me');
	
    Route::post('login', 'AuthController@login');	
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('autenticated', 'AuthController@autenticated');
});








Route::get('/prueba', function (Request $request) {
	echo 'Versión actual de PHP: ' . phpversion();
	//$aja = DB::select('select @@VERSION');
	//echo $aja;
});


Route::any('(:any)/(:all?)',function (Request $request) {
	return view('index');
    //return view('index');
});


