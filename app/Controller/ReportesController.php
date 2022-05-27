<?php

App::uses('AppController', 'Controller');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ReportesController
 *
 * @author Margarita Hoyos
 */
class ReportesController extends AppController {

    var $nombre = 'Reportes';
    var $uses = array();

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator');

    function index() {
        
    }

    function estadopaquetes() {
        /*         * * Cargamos regionales ** */
        $this->loadModel('Regionale');
        $regional = $this->Regionale->find('list');
        $this->set(compact('regional'));

        /*         * * Cargamos ciudades ** */
        $this->loadModel('Ciudade');
        $ciudad = $this->Ciudade->find('list');
        $this->set(compact('ciudad'));

        /*         * * Cargamos oficinas ** */
        $this->loadModel('Oficina');
        $oficina = $this->Oficina->find('list');
        $this->set(compact('oficina'));
    }

    function generar_estadopaquetes() {
        $this->loadModel('Regionale');
        $this->loadModel('Ciudade');
        $this->loadModel('Paquete');
        $this->loadModel('Oficina');
        $this->loadModel('PaquetesUsuario');
				
        $tipo_reporte = $this->request->data['Reporte']['tipo'];
        $id_regional = $this->request->data['Reporte']['regional'];
        $id_ciudad = $this->request->data['Reporte']['ciudad'];
        $id_oficina = $this->request->data['Reporte']['oficina'];
        $desde = $this->request->data['Reporte']['fecha_inicio'];
        $hasta = $this->request->data['Reporte']['fecha_fin'];
        
        $arr_condiciones = array();
        if (!empty($desde) && !empty($hasta)) {
            array_push($arr_condiciones, array('Paquete.fechacreacion BETWEEN ? AND ?' => array($desde, $hasta . " 23:59:59")));
        }
        
        $ciudad = empty($id_ciudad) ? 
                (empty($id_regional) ? null : 
                $this->Ciudade->find('list', array('conditions' => array('Ciudade.regionale_id' => $id_regional)))) :
                $this->Ciudade->find('list', array('conditions' => array('Ciudade.id' => $id_ciudad)));

        //pasar como parametro al filtro de oficinas, los id de las ciudades de la variable ciudad
        $arr_id_ciudades = array();
        $id_oficinas = array();
        if ($ciudad != null && empty($id_oficina)) {            
            foreach ($ciudad as $idc => $ciu) {
                array_push($arr_id_ciudades, $idc);
            }
            
            $oficina = $this->Oficina->find('list', array('conditions' => array('Oficina.ciudade_id' => $arr_id_ciudades)));
            
            foreach ($oficina as $ido => $ofi) {
                array_push($id_oficinas, $ido);
            }
        }else if(!empty ($id_oficina)){
            $id_oficinas['0'] = $id_oficina;
        }
        
        if($ciudad != null && $id_oficinas == null){
            array_push($arr_condiciones, array('C.id' => $arr_id_ciudades));
        }
        if(!empty($id_oficinas)){
            array_push($arr_condiciones, array('O.id' => $id_oficinas));
        }


        $paquetes = $this->Paquete->obtenerPaquetesEstadoPaquetes($arr_condiciones);
//        $paquetes = empty($id_oficina) ? 
//                ( isset($arr_id_ciudades) ? 
//                $this->Paquete->find('all', array('conditions' => array('Paquete.oficina_id' => $id_oficinas, $arr_condiciones), 'recursive' => 0)) : 
//                $this->Paquete->find('all', array('conditions' => array($arr_condiciones), 'recursive' => 0)) ) :
//                $this->Paquete->find('all', array('conditions' => array('Paquete.oficina_id' => $id_oficina, $arr_condiciones), 'recursive' => 0));

//        for ($i = 0; $i < count($paquetes); $i++) {
//			
//            $arrUbicacion = $this->Oficina->obtenerUbicacionOficina($paquetes[$i]['Oficina']['id']);
//            if(count($arrUbicacion) > 0){
//                    $paquetes[$i]['Oficina']['ciudaddescripcion'] = $arrUbicacion['C']['descripcion'];
//                    $paquetes[$i]['Oficina']['regionaldescripcion'] = $arrUbicacion['R']['descripcion'];
//            }
//
//            $arrPaquetesUsuario = $this->PaquetesUsuario->find('all', array('conditions' => array('PaquetesUsuario.paquete_id' => $paquetes[$i]['Paquete']['id'], 'PaquetesUsuario.asignado' => 'true'), 'order' => 'PaquetesUsuario.id', 'recursive' => 0));
//            $countArray = count($arrPaquetesUsuario);
//            if ($countArray > 0) {
//                $paquetes[$i]['Paquete']['usuario_asignado'] = $arrPaquetesUsuario[$countArray - 1]['Usuario']['nombre'];
//            } else {
//                $arrPaquetesUsuario = $this->PaquetesUsuario->find('all', array('conditions' => array('PaquetesUsuario.paquete_id' => $paquetes[$i]['Paquete']['id']), 'order' => 'PaquetesUsuario.id DESC', 'limit' => '1', 'recursive' => 0));
//                $paquetes[$i]['Paquete']['usuario_asignado'] = $arrPaquetesUsuario['0']['Usuario']['nombre'];
//            }
//        }       

        $this->set(compact('paquetes'));
        $texto_tit = "Reporte - Estado de Solicitudes";
        $this->set('texto_tit', $texto_tit);

        if ($tipo_reporte == "1") {
            $this->Paquete->recursive = 1;
            $this->set('rows', $paquetes);
            $arr_titulos = array(
                0 => __('NUMERO CREDENCIAL'),
                1 => __('NUMERO SOLICITUD'),
                2 => __('FECHA CREACION'),
                3 => __('ESTADO'),
                4 => __('USUARIO'),
                5 => __('REGIONAL'),
                6 => __('CIUDAD'),
                7 => __('OFICINA'),
            );
            $this->set('titulos', $arr_titulos);
            $this->render('export_xls', 'export_xls');
        }
    }

    public function obtenerciudades() {
        $this->layout = 'ajax';
        if ($this->request->is('post')) {
            $id = $this->request->data('idregional');
            $this->loadModel('Ciudade');

            $ciudad = empty($id) ? $this->Ciudade->find('list', array('conditions' => array('Ciudade.estadoregistro_id' => 1))) :
                    $this->Ciudade->find('list', array('conditions' => array('Ciudade.estadoregistro_id' => 1, 'Ciudade.regionale_id' => $id)));
            $this->set(compact('ciudad'));
        }
    }

    public function obteneroficinas() {
        $this->layout = 'ajax';
        if ($this->request->is('post')) {
            $id = $this->request->data('idciudad');
            $this->loadModel('Oficina');
            if (!empty($id)) {
                $oficina = $this->Oficina->find('list', array('conditions' => array('Oficina.ciudade_id' => $id)));
                $this->set(compact('oficina'));
            } else {
                $oficina = $this->Oficina->find('list');
                $this->set(compact('oficina'));
            }
        }
    }

    public function obtenerusuarios() {
        $this->layout = 'ajax';
        if ($this->request->is('post')) {
            $id = $this->request->data('idoficina');
            $this->loadModel('Usuario');
            $this->loadModel('OficinasUsuario');

            $idusuarios = $this->OficinasUsuario->find('all', array('conditions' => array('OficinasUsuario.oficina_id' => $id), 'fields' => 'OficinasUsuario.usuario_id'));
            $arr_id_usuarios = array();
            foreach ($idusuarios as $idu => $usu) {
                array_push($arr_id_usuarios, $usu['OficinasUsuario']['usuario_id']);
            }

            $usuario = $this->Usuario->find('list', array('conditions' => array('Usuario.id' => $arr_id_usuarios)));
            $this->set(compact('usuario'));
        }
    }

    public function tiempospromedio() {
        
    }

    public function generar_tiempospromedio() {
        $this->loadModel('Trazabilidade');
        $this->loadModel('Oficina');
        $this->loadModel('Usuario');
        
        $arr_condiciones = array();
        $tipo_reporte = 0;

        if(isset($this->request->data['Reporte']['credencial']) && $this->request->data['Reporte']['credencial'] != ""){
            array_push($arr_condiciones, array('P.numerocredencial' => $this->request->data['Reporte']['credencial']));   
        }
        
        if(isset($this->request->data['Reporte']['tipo'])){
            $tipo_reporte = $this->request->data['Reporte']['tipo'];            
        }

        $trazas = array();
        if ($tipo_reporte == "1") {
            $trazas = $this->Trazabilidade->obtnerInfoTrazabilidad($arr_condiciones);
        } else {
            $joins = $this->Trazabilidade->obtnerJoinsTraza();
            $this->Paginator->settings = array(
                'joins' => $joins, 
                'conditions' => array($arr_condiciones),
                'fields' => array(                    
                    'P.numerocredencial',
                    'P.numerosolicitud',
                    'E.descripcion',
                    'O.descripcion',
                    'U.nombre',
                    'Trazabilidade.created',
                    'Trazabilidade.diaspromedio'
                    ),                 
                'order' => array('Trazabilidade.paquete_id' => 'ASC', 'Trazabilidade.created' => 'DESC'),
                'limit' => 30,
                'paramType' => 'querystring',
                'recursive' => 0
            );

            $trazas = $this->Paginator->paginate('Trazabilidade');       
        }

        $texto_tit = "Reporte - Tiempos promedio por estado" . (empty($this->request->data['Reporte']['credencial']) ? "" : " Credencial {$this->request->data['Reporte']['credencial']}");

        $this->set('texto_tit', $texto_tit);
        $this->set(compact('trazas'));

        if ($tipo_reporte == "1") {
            $this->Trazabilidade->recursive = 1;
            $this->set('rows', $trazas);
            $arr_titulos = array(
                0 => __('NUMERO DE CREDENCIAL'),
                1 => __('NUMERO DE SOLICITUD'),
                2 => __('ESTADO'),
                3 => __('USUARIO'),
                4 => __('OFICINA'),
                5 => __('FECHA'),
                6 => __('DIAS')
            );
            $this->set('titulos', $arr_titulos);
            $this->render('export_xls', 'export_xls');
        }
    }

    public function diasenespera() {
        /*         * * Cargamos regionales ** */
        $this->loadModel('Regionale');
        $regional = $this->Regionale->find('list');
        $this->set(compact('regional'));

        /*         * * Cargamos ciudades ** */
        $this->loadModel('Ciudade');
        $ciudad = $this->Ciudade->find('list');
        $this->set(compact('ciudad'));

        /*         * * Cargamos oficinas ** */
        $this->loadModel('Oficina');
        $oficina = $this->Oficina->find('list');
        $this->set(compact('oficina'));

        /*         * * Cargamos formatos ** */
        $this->loadModel('Documento');
        $documento = $this->Documento->find('list');
        $this->set(compact('documento'));
    }

    public function generar_diasenespera() {
        $id_regional = $this->request->data['Reporte']['regional'];
        $id_oficina = $this->request->data['Reporte']['oficina'];
        $id_ciudad = $this->request->data['Reporte']['ciudad'];
        $desde = $this->request->data['Reporte']['fecha_inicio'];
        $hasta = $this->request->data['Reporte']['fecha_fin'];

        $texto_tit = "Reporte - Dias en espera";
        $this->set('texto_tit', $texto_tit);

        $this->loadModel('Trazabilidade');
        $this->loadModel('Paquete');
        $this->loadModel('Estado');
        $this->loadModel('Usuario');
        $this->loadModel('Oficina');
        $this->loadModel('Ciudade');

        $arr_condiciones = array();
                
        //se obtienen los estados marcados como finalizados
        $arrEstados = $this->Estado->obtenerEstadosFin();
        for($p = 0; $p < count($arrEstados); $p++){
            $estadosFin[$p] = $arrEstados[$p]['Estado']['id'];            
        }        
        
        if(count($estadosFin) > '0'){
            array_push($arr_condiciones, array('Trazabilidade.estadodestino_id NOT IN' => $estadosFin));            
        }
        
        $ciudad = empty($id_ciudad) ? 
                (empty($id_regional) ? null : 
                $this->Ciudade->find('list', array('conditions' => array('Ciudade.regionale_id' => $id_regional)))) :
                $this->Ciudade->find('list', array('conditions' => array('Ciudade.id' => $id_ciudad)));

        //pasar como parametro al filtro de oficinas, los id de las ciudades de la variable ciudad
        $arr_id_ciudades = array();
        $id_oficinas = array();
        if ($ciudad != null && empty($id_oficina)) {            
            foreach ($ciudad as $idc => $ciu) {
                array_push($arr_id_ciudades, $idc);
            }
            
            $oficina = $this->Oficina->find('list', array('conditions' => array('Oficina.ciudade_id' => $arr_id_ciudades)));
            
            foreach ($oficina as $ido => $ofi) {
                array_push($id_oficinas, $ido);
            }
        }else if(!empty ($id_oficina)){
            $id_oficinas['0'] = $id_oficina;
        }
        
        if(!empty($id_oficinas)){
            array_push($arr_condiciones, array('O.id' => $id_oficinas));
        }        
        if (!empty($desde) && !empty($hasta)) {
            array_push($arr_condiciones, array('Trazabilidade.created BETWEEN ? AND ?' => array($desde, $hasta)));
        }

		
	//campos que se van a mostrar        
        $paquetesDias = $this->Trazabilidade->obtenerTrazabilidadPaquetes($arr_condiciones);                            

        $this->set(compact('paquetesDias'));

        $tipo_reporte = $this->request->data['Reporte']['tipo'];
        if ($tipo_reporte == "1") {
            $this->set('rows', $paquetesDias);
            $arr_titulos = array(
                0 => __('NUMERO DE CREDENCIAL'),
                1 => __('NUMERO DE SOLICITUD'),
                2 => __('ESTADO'),
                3 => __('USUARIO'),
                4 => __('FECHA CREACION'),
                5 => __('REGIONAL'),
                6 => __('CIUDAD'),
                7 => __('OFICINA'),
                8 => __('CANTIDAD DE DIAS'),
            );
            $this->set('titulos', $arr_titulos);
            $this->render('export_xls', 'export_xls');
        }
    }

    function reporteproduccion() {
        /*         * * Cargamos regionales ** */
        $this->loadModel('Regionale');
        $regional = $this->Regionale->find('list');
        $this->set(compact('regional'));

        /*         * * Cargamos ciudades ** */
        $this->loadModel('Ciudade');
        $ciudad = $this->Ciudade->find('list');
        $this->set(compact('ciudad'));

        /*         * * Cargamos oficinas ** */
        $this->loadModel('Oficina');
        $oficina = $this->Oficina->find('list');
        $this->set(compact('oficina'));

        /*         * * Cargamos usuarios ** */
        $this->loadModel('Usuario');
        $usuario = $this->Usuario->find('list', array('conditions' => array('Usuario.username' => '2')));
        $this->set(compact('usuario'));

        $perfilusuario = $this->Auth->user('Perfile.id');
        $this->set(compact('perfilusuario'));

        $idusuario = $this->Auth->user('Usuario.id');
        $this->set(compact('idusuario'));

        
    }

    function generar_reporteproduccion() {
        //Lectura de variables enviadas por post
        
        $idusuario = $this->request->data['Reporte']['usuario'];
        $idciudad = "";
        $desde = $this->request->data['Reporte']['fecha_inicio'];
        $hasta = $this->request->data['Reporte']['fecha_fin'];

        if (empty($idusuario)) {
            $idusuario = $this->Auth->user('id');
        }

        //Trae el nombre del usuario
        $this->loadModel('Usuario');
        $usuario = $this->Usuario->find('first', array('conditions' => array('Usuario.id' => $idusuario)));
        $usuario = $usuario['Usuario']['nombre'];

        if (empty($idciudad)) {
            $this->loadModel('OficinasUsuario');
            $resul = $this->OficinasUsuario->find('first', array('conditions' => array('OficinasUsuario.usuario_id' => $idusuario), 'fields' => 'Oficina.ciudade_id'));
            $idciudad = $resul['Oficina']['ciudade_id'];
        }

        //Trae el nombre de la ciudad que lleva el reporte
        $this->loadModel('Ciudade');
        $ciudad = $this->Ciudade->find('first', array('conditions' => array('Ciudade.id' => $idciudad), 'recursive' => -1));
        $ciudad = $ciudad['Ciudade']['nombre'];       

        //Consultar ids aprobados en rango de fecha
        $this->loadModel('Trazabilidade');
        $idsPaquetesTraza = $this->Trazabilidade->find('all', array(
            'conditions' => array('Trazabilidade.created BETWEEN ? AND ?' => array($desde, $hasta),
                'Trazabilidade.estadoproceso_id' => array('13', '14')),
            'fields' => 'Trazabilidade.paquete_id', 'group' => 'Trazabilidade.paquete_id',
            'recursive' => -1
        ));

        $idsPaquetesTrazabilidad = array();
        foreach ($idsPaquetesTraza as $idpt => $idptra) {
            array_push($idsPaquetesTrazabilidad, $idptra['Trazabilidade']['paquete_id']);
        }
        
        $join = array(array('table' => 'paquetes', 'alias' => 'Paqu', 'type' => 'INNER',
                'conditions' => array('Paqu.id = Trazabilidade.paquete_id')));
        $idsPaquetesTraza = $this->Trazabilidade->find('all', array(
            'joins' => $join,
            'conditions' => array('Trazabilidade.paquete_id' => $idsPaquetesTrazabilidad),
            'fields' => 'Trazabilidade.paquete_id', 'group' => 'Trazabilidade.paquete_id',
            'recursive' => -1
        ));

        $idsPaquetesTrazabilidad = array();
        foreach ($idsPaquetesTraza as $idpt => $idptra) {
            array_push($idsPaquetesTrazabilidad, $idptra['Trazabilidade']['paquete_id']);
        }



        //Consulta los paquetes asociados al usuario correspondiente
        $this->loadModel('PaquetesUsuario');
        $idPqtUsu = $this->PaquetesUsuario->find('all', array(
            'conditions' => array('PaquetesUsuario.usuario_id' => $idusuario, 'PaquetesUsuario.paquete_id' => $idsPaquetesTrazabilidad),
            'fields' => 'PaquetesUsuario.paquete_id',
            'recursive' => -1
        ));

        $idPqtUsuarios = array();
        foreach ($idPqtUsu as $idpt => $idptra) {
            array_push($idPqtUsuarios, $idptra['PaquetesUsuario']['paquete_id']);
        }

        //Consultara los paquetes de la lista
        $condiciones = array();
        array_push($condiciones, array('Paquete.id' => $idPqtUsuarios));
        $this->loadModel('Paquete');
        $paquetesFormato = $this->Paquete->find('all', array('conditions' => $condiciones));

        //Cabeceras de la tabla dell excel
        $this->set('rows', $paquetesFormato);
        $arr_titulos = array(
            0 => __('NOMBRE PRODUCTO'),
            1 => __('TIPO DE MOVIMIENTO'),
            2 => __('NOMBRE RESPONSABLE DE PAGO'),            
            4 => __('NUMERO CERTIFICADO (REFERENCIA)'),
            5 => __('PLACA')
        );
        $titulosrotados = array(
            0 => __('POLIZA'),
            1 => __('SOLICITUD SEGURO'),
            2 => __('SARLAFT'),            
            4 => __('TARJETA PROPIEDAD'),
            5 => __('FACTURA DE COMPRA'),
            6 => __('OBJETO LICITO'),
            7 => __('JUEGO DE IMPRONTAS'),
            8 => __('MANIFIESTO DE ADUANA'),
            9 => __('INSPECCION'),
            10 => __('DECLARACION RENTA O CERTIFICADO DE INGRESOS'),
            11 => __('REFERENCIAS BANCARIAS'),
            12 => __('SOPORTE DEL DESCUENTO'),
            13 => __('SOPORTE DEL MOVIMIENTO'),
            14 => __('AVALUO COMERCIAL'),
            15 => __('EXCLUSION'),
            16 => __('NUMERO DE HOJAS'),
            17 => __('AJUSTE'),
            18 => __('NUMERO ECASE'),
            19 => __('NUMERO RECIBO PAGO (Aplica ventas de contado)')
        );
        $titulodescripcion = "OBSERVACIONES";

        //Se compactan todas las variables que se mostraran en el reporte
        $this->set(compact('desde'));
        $this->set(compact('hasta'));
        $this->set(compact('usuario'));
        $this->set(compact('ciudad'));       
        $this->set(compact('titulodescripcion'));
        $this->set('titulos', $arr_titulos);
        $this->set('paquetesFormato', $paquetesFormato);
        $this->set(compact('titulosrotados'));
        $this->render('export_xls', 'export_xls');
    }
	
    public function motivostraslados() {
        /*         * * Cargamos regionales ** */
        $this->loadModel('Regionale');
        $regional = $this->Regionale->find('list');
        $this->set(compact('regional'));

        /*         * * Cargamos ciudades ** */
        $this->loadModel('Ciudade');
        $ciudad = $this->Ciudade->find('list');
        $this->set(compact('ciudad'));

        /*         * * Cargamos oficinas ** */
        $this->loadModel('Oficina');
        $oficina = $this->Oficina->find('list');
        $this->set(compact('oficina'));
        
        /*         * * Cargamos los motivos de traslado ** */
        $this->loadModel('Motivostraslado');
        $motivos = $this->Motivostraslado->obtenerMotivosTraslado();
        $this->set(compact('motivos'));

    } 	
	
    public function generar_motivostraslados(){
        $this->loadModel('Paquete');
        $this->loadModel('MotivostrasladosPaquete');
        $this->loadModel('Usuario');
        $this->loadModel('Oficina');
        $this->loadModel('Regionale');
        $this->loadModel('Ciudade');
        
        $regionalId = $this->request->data['Reporte']['regional'];        
        $ciudadId = $this->request->data['Reporte']['ciudad'];
        $oficinaId = $this->request->data['Reporte']['oficina'];
        $motivoId = $this->request->data['Reporte']['motivos'];
        $credencial = $this->request->data['Reporte']['credencial'];
        $nombreUsuario = $this->request->data['Reporte']['usuario'];
        
        $condiciones = array();                

        if(!empty($oficinaId)){            
            array_push($condiciones, array('PQ.oficina_id' => $oficinaId));            
        }else if (empty($regionalId) && !empty($ciudadId)){
            $arrOficinas = $this->Oficina->obtenerInfoOficinasPorCiudad(array_values($ciudadId));
            foreach ($arrOficinas as $ofi){
                $oficinaId[] = $ofi['Oficina']['id'];
            }               
            array_push($condiciones, array('PQ.oficina_id' => $oficinaId));
        }else if (empty ($oficinaId) && empty ($ciudadId) && !empty ($regionalId)){
            $arrCiudades = $this->Ciudade->obtenerInfoCiudadesPorRegion($regionalId);
            foreach ($arrCiudades as $ciu){
                $ciudadId[] = $ciu['Ciudade']['id'];
            }   
            
            $arrOficinas = $this->Oficina->obtenerInfoOficinasPorCiudad(array_values($ciudadId));
            foreach ($arrOficinas as $ofi){
                $oficinaId[] = $ofi['Oficina']['id'];
            }   
            
            array_push($condiciones, array('PQ.oficina_id' => $oficinaId));
        }
        
        if(!empty($credencial)){
            array_push($condiciones, array('PQ.numerocredencial' => $credencial));
        }
        
        $arrMotivosTraslado = $this->MotivostrasladosPaquete->obtenerMotivosTrasladoPaquete($condiciones, $motivoId, $nombreUsuario);
 
        $texto_tit = "Reporte - Motivos de Traslado";
        $this->set('texto_tit', $texto_tit);
        
        $this->set(compact('arrMotivosTraslado'));

        $tipo_reporte = $this->request->data['Reporte']['tipo'];
        if ($tipo_reporte == "1") {
            $this->set('rows', $arrMotivosTraslado);
            $arr_titulos = array(
                0 => __('FECHA DE ASIGNACION'),
                1 => __('NUMERO DE CREDENCIAL'),
                2 => __('NUMERO DE SOLICITUD'),
                3 => __('AUDITOR ASIGNADO'),
                4 => __('FECHA TRASLADO'),
                5 => __('AUDITOR RECIBE'),
                6 => __('MOTIVO'),
                7 => __('REGIONAL'),
                8 => __('CIUDAD'),
                9 => __('OFICINA')
            );
            $this->set('titulos', $arr_titulos);
            $this->render('export_xls', 'export_xls');
    }
    }	

}

?>
