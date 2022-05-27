<?php
App::uses('AppController', 'Controller');
App::uses ('DocumentospaquetesController', 'Controller');
App::uses('EstadosController', 'Controller');
/**
 * Bandejas Controller
 *
 * @property Bandeja $Bandeja
 * @property PaginatorComponent $Paginator
 */
class BandejasController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
 * index method
 *
 * @return void
 */
	public function index() {
            $paginate = array();
            if (isset($this->passedArgs['Search.Nombre']) && !empty($this->passedArgs['Search.Nombre'])) {
                $paginate['Bandeja.descripcion LIKE '] = '%' . $this->passedArgs['Search.Nombre'] . '%';
            }
            
            if (isset($this->passedArgs['Search.estado_id']) && !empty($this->passedArgs['Search.estado_id'])) {
                $paginate['Bandeja.estado_id ='] = $this->passedArgs['Search.estado_id'];
            }

            $this->Bandeja->recursive = 0;

            if (empty($paginate)) {
                $this->set('bandejas', $this->Paginator->paginate());
            } else {
                $this->set('bandejas', $this->Paginator->paginate('Bandeja', $paginate));
            }                       
        }

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
         
		if (!$this->Bandeja->exists($id)) {
			throw new NotFoundException(__('La bandeja no existe'));
		}
		$options = array('conditions' => array('Bandeja.' . $this->Bandeja->primaryKey => $id));
		$this->set('bandeja', $this->Bandeja->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {

		if ($this->request->is('post')) {
			$this->Bandeja->create();
			if ($this->Bandeja->save($this->request->data)) {
				$this->Session->setFlash(__('La bandeja ha sido guardada.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('La bandeja no pudo ser guardada. Por favor, inténtelo de nuevo.'));
			}
		}                        
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Bandeja->exists($id)) {
			throw new NotFoundException(__('La bandeja no existe'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Bandeja->save($this->request->data)) {
				$this->Session->setFlash(__('La bandeja ha sido guardada.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('La bandeja no pudo ser guardada. Por favor, inténtelo de nuevo.'));
			}
		} else {
			$options = array('conditions' => array('Bandeja.' . $this->Bandeja->primaryKey => $id));
			$this->request->data = $this->Bandeja->find('first', $options);
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {

		$this->Bandeja->id = $id;
		if (!$this->Bandeja->exists()) {
			throw new NotFoundException(__('La bandeja no existe'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Bandeja->delete()) {
			$this->Session->setFlash(__('La bandeja ha sido eliminada.'));
		} else {
			$this->Session->setFlash(__('La bandeja no pudo ser eliminada. Por favor, inténtelo de nuevo.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
        
        public function configurar(){                        
            
            $this->loadModel('Etiquetacambioestado');
            $this->loadModel('Usuario');
            $this->loadModel('Permisobandeja');
            $this->loadModel('Perfile');
            $this->loadModel('Bandejasestado');
            $this->loadModel('Semaforo');
            $this->loadModel('Relacionbandejasestado');
            $this->loadModel('Privilegio');
            $this->loadModel('PrivilegiosUsuario');
            
            //Se obtiene el listado de bandejas
            $listBandejas = $this->Bandeja->listaBandejas(); 
            $listBandejas['0'] = "Seleccione una...";
            ksort($listBandejas);
            
            //Se obtiene la información completa de las bandejas y su estado
            $infoBandejas = $this->Relacionbandejasestado->infoBandejasEstados();

            //Se obtienen las etiquetas para cambio de estado
            $listEtiquetasCambEst = $this->Etiquetacambioestado->ListaEtiquetasCE();
            $listEtiquetasCambEst['0'] = "Seleccione una...";
            ksort($listEtiquetasCambEst);
            
            //Se obtienen los usuarios
            $infoUsuarios = $this->Usuario->obtenerInfoUsuarios();
            
            //Se obtiene el listado de permisos que se pueden asignar sobre las bandejas
            $listPermisoBandeja = $this->Permisobandeja->obtenerListaPermisoBandeja();
            $listPermisoBandeja['0'] = "Seleccione uno...";
            ksort($listPermisoBandeja);            
            
            //Se obtienen los perfiles de la aplicacion
            $infoPerfiles = $this->Perfile->obtenerDatosPerfiles();
            
            //Se obtienen las bandejas que han sido configuradas para el flujo
            $infoBandejasEstados = $this->Bandejasestado->infoBandejaEstados();
            
            //Se obtiene el listado de semaforos 
            $listSemaforo = $this->Semaforo->obtenerSemaforos();  
            
            //Se obtiene el id del usuario logueado
            $usuarioId = $this->Auth->user('id');
            
            //Se valida si el usuario tiene permisos de gestion sobre las secuencias del flujo
            $permisoGF = 'GestionFlujo';
            $idPrivilegioAdj = $this->Privilegio->obtenerIdPrivilegio($permisoGF);
            $arrPriviUsrGest = $this->PrivilegiosUsuario->obtenerPrivilegiosPorUsuario($usuarioId, $idPrivilegioAdj);     
            
            $this->set(compact('listBandejas', 'infoBandejas', 'listEtiquetasCambEst', 'infoUsuarios', 'listPermisoBandeja', 'infoPerfiles', 'infoBandejasEstados', 'listSemaforo', 'arrPriviUsrGest'));
        }
        
        public function addSecuencia(){
            $this->autoRender = false;
            $postData = $this->request->data;
            
            $bandejaInicial = $postData['bandejasflujo_id'];
            $bandejaSiguiente = $postData['bandejasflujosig_id'];
            $etiquetaCambio = $postData['etiqutaCambio'];

            $this->loadModel('Bandejasestado');
            $this->loadModel('Bandeja');
            
            $estadoBandejaSig = $this->Bandeja->obtenerBandejaPorId($bandejaSiguiente);
            $estadoSiguiente = $estadoBandejaSig['Bandeja']['estado_id'];            
          
            //Se valida si no existe la secuenca para crearla
            if($this->Bandejasestado->relacionSecuenciaExiste($bandejaInicial, $estadoSiguiente)){
                echo json_encode(array('respuesta' => 'La secuencia ya existe', 'bool' => false));
            }else{
                if ($this->Bandejasestado->guardarBandejasEstados($bandejaInicial,$estadoSiguiente,$etiquetaCambio)) {
                    echo json_encode(array('respuesta' => 'Se guardó la secuencia', 'bool' => true));  
                } else {
                    echo json_encode(array('respuesta' => 'No se guardó la secuencia', 'bool' => false));
                }                
            }           
        }
        
        public function borrarSecuencia(){
            $this->autoRender = false;
            $postData = $this->request->data;

            $this->loadModel('Bandejasestado');
            if ($this->Bandejasestado->delete($postData['id'], false)) {
                echo json_encode(true);
            } else {
                echo json_encode(false);
            }            
        }
        
    public function listarpaquetes($bandejaId = null) { 
        $this->loadModel('Paquete');
        $this->loadModel('Permisousuariobandeja');
        $this->loadModel('Semaforo');
        $this->loadModel('Relacionbandejasestado');
        $this->loadModel('OficinasUsuario');
        $this->loadModel('Regionale');   
        $this->loadModel('Estado');
        $usuarioId = $this->Auth->user('id');
        
        $paginate = array();
        if(isset($this->passedArgs['Search.Numero']) && $this->passedArgs['Search.Numero'] != "") {
            $paginate['Paquete.numerocredencial LIKE '] = '%'.$this->passedArgs['Search.Numero'].'%';
        }
        
        if(isset($this->passedArgs['Search.FechaDesde'])){
            $desde = $this->passedArgs['Search.FechaDesde'];
        }
        
        if(isset($this->passedArgs['Search.FechaHasta'])){
            $hasta = $this->passedArgs['Search.FechaHasta'];
        }
        
        if (!empty($desde) && !empty($hasta)) {
            $paginate['Paquete.fechacreacion BETWEEN ? AND ?'] = array($desde, $hasta . " 23:59:59");
        }
        
        if(isset($this->passedArgs['Search.Estado']) && $this->passedArgs['Search.Estado'] != "") {
            $paginate['Paquete.estado_id'] = $this->passedArgs['Search.Estado'];
        }         
        
        if(isset($this->passedArgs['Oficina.Oficina']) && count($this->passedArgs['Oficina.Oficina']) > '0' && $this->passedArgs['Oficina.Oficina'] != "") {
            $paginate['Paquete.oficina_id'] = $this->passedArgs['Oficina.Oficina'];
        }  
        
        /*Se obtiene la información de la bandeja en la cual se encuentra el usuario logueado*/
        $arrInfoBandeja = $this->Bandeja->obtenerBandejaPorId($bandejaId);
        
        /*Se obtiene la informacion del permiso que tiene el usuario sobre la bandeja*/
        $arrPermisosUsrBandeja = $this->Permisousuariobandeja->obtenerPermisosPorUsuBand($bandejaId, $usuarioId); 
        $permisoUsuarioBandeja = $arrPermisosUsrBandeja['Permisousuariobandeja']['permisobandeja_id'];        
                
        /*Se obtiene el listado de oficinas sobre las cuales el usuario tiene permisos para gestionar los respectivos paquetes*/
        $arrOficinas = $this->OficinasUsuario-> obtenerOficinasUsuario($usuarioId);          
        foreach ($arrOficinas as $oficinas){
            $oficinasIds[] = $oficinas['Oficina']['id'];
        }
        
        /*Se obtienen los estados relacionados a la bandeja en gestión*/
        $arrEstados = $this->Relacionbandejasestado->obtenerInfoRelacionBEPorBandeja($bandejaId);
        foreach ($arrEstados as $estados){
            $arrEstId[] = $estados['Relacionbandejasestado']['estado_id'];
        }
        
        /*Se obtiene el listado de paquetes que el usuario puede gestionar o visualizar y se pagina*/        
        if(empty($paginate)){
            $this->Paginator->settings = $this->Paquete->obtenerListadoPaquetes($arrEstId, $usuarioId, $oficinasIds, $permisoUsuarioBandeja);               
            $arrPaquetes = $this->Paginator->paginate('Paquete');            
        }else{
            $this->Paginator->settings = $this->Paquete->obtenerListadoPaquetes($arrEstId, $usuarioId, $oficinasIds, $permisoUsuarioBandeja);               
            $arrPaquetes = $this->Paginator->paginate('Paquete', $paginate);            
        }

        /*Se recorre el arreglo de paquetes para agregar la ciudad y la regional a la que pertenece el paquete*/
        $arrUbicacion = array();
        foreach ($arrPaquetes as $clvPaq => $valPaq){
            $arrUbicacion = $this->obtenerUbicacionPaquete($valPaq['Oficina']['id']);
            $arrPaquetes[$clvPaq]['Paquete']['ciudad'] = $arrUbicacion['ciudad'];
            $arrPaquetes[$clvPaq]['Paquete']['regional'] = $arrUbicacion['regional'];                
        }
		
		/*Se obtienen los estados configurados como finalizados en la aplicacion*/
		$arrEstFin = $this->Estado->obtenerEstadosFin();		
		$estadosFin = array();
		for($p = 0; $p < count($arrEstFin); $p++){
			$estadosFin[$p] = $arrEstFin[$p]['Estado']['id'];
		}

        /*Se obtienen los semaforos*/
        $arrBandejas = $this->Semaforo->obtenerValoresSemaforos();     

        /*Se calcula el semáforo para cada paquete siempre y cuando no se encuentre en un estado finalizado*/
        if(count($arrBandejas) > 0){
            foreach($arrPaquetes as $clave => $valor){
				if(!in_array($valor['Paquete']['estado_id'],$estadosFin)){
				   $semaforoPaquete = $this->calcularSemaforoPaquete($valor, $arrBandejas);
				   $arrPaquetes[$clave]['Paquete']['color_semaforo'] = $semaforoPaquete;
				   $arrPaquetes[$clave]['Paquete']['dias_semaforo'] = $this->calcularDiasCreacionPaquete($valor['Paquete']['fechacreacion']);					
				}

            }
        }
        
        /*Se obtiene el listado de regionales*/
        $arrRegionales = $this->Regionale->obtenerTodasRegionales();

        /*Se obtiene el listado de estados*/
        $arrEstadosF = $this->Estado->obtenerListaEstados();

        $this->set(compact('arrPaquetes', 'permisoUsuarioBandeja', 'arrBandejas', 'bandejaId', 'arrInfoBandeja', 'arrRegionales', 'arrEstadosF'));            
    }
    

    public function calcularSemaforoPaquete($valor, $arrBandejas){
        $dias = $this->calcularDiasCreacionPaquete($valor['Paquete']['fechacreacion']);
        if($dias <= '0'){
            $dias = $dias + 1;
        }
        
        $arrSemaforos = array();
        foreach($arrBandejas as $clave => $valor){
            $arrSemaforos[$clave]['rango_inicial'] = $valor['Semaforo']['rangoinicial'];
            $arrSemaforos[$clave]['rango_final'] = $valor['Semaforo']['rangofinal'];
            $arrSemaforos[$clave]['color'] = $valor['Semaforo']['color'];
        }        
        
        sort($arrSemaforos);
        foreach ($arrSemaforos as $cl => $vl){
            if($dias >= $vl['rango_inicial'] && $dias <= $vl['rango_final']){                
                $colorSemPaq = $vl['color'];
                break;
            }
        }
        
        if(!isset($colorSemPaq)){
            $colorSemPaq = $arrSemaforos[count($arrSemaforos)-1]['color']; 
        }
        
        return $colorSemPaq;
    }        
      
    public function calcularDiasPaqueteEnEspera($paqueteId){
        $this->loadModel('Trazabilidade');
        $this->loadModel('Diasfestivo');

        $arrTrazabilidad = $this->Trazabilidade->consultarUltimaTrazaPaquete($paqueteId);
        if(count($arrTrazabilidad)>0){
            $fechaActual = date("Y-m-d h:i:s");
            $fechaAnterior = strtotime(h($arrTrazabilidad['Trazabilidade']['created']));
            $dias = floor(abs((strtotime($fechaActual)-$fechaAnterior)/86400));
            $diasFestivos = $this->Diasfestivo->obtenerDiasFestivos($arrTrazabilidad['Trazabilidade']['created'], $fechaActual);
            $diasTotal = $dias - $diasFestivos;
            return $diasTotal;            
        }

    }
    
    public function gestionpaquete(){
        if($this->request->is('post')){
            $this->loadModel('Bandejasestado');
            $this->loadModel('Observacione');
            $this->loadModel('Documentospaquete');
            $this->loadModel('Trazabilidade');
            $this->loadModel('Estado');
            $this->loadModel('Configuraciondato');
            $this->loadModel('MotivosrechazosPaquete');
            $posData = $this->request->data;

            $permisobandejaId = $posData['permisobandejaId'];
            $paqueteId = $posData['paqueteId'];
            $fechaCreacion = $posData['fechaCreacion'];
            $numeroOficio = $posData['numeroSolicitud'];
            $numeroCredencial = $posData['numeroCredencial'];
            $estado = $posData['estado'];
            $nombreOficina = $posData['oficina'];
            $oficinaId = $posData['oficinaId'];
            $bandejaId = $posData['bandejaId'];
            $estadoId = $posData['estadoId'];
            
            /*Se obtiene el listado de estados hacia los cuales se puede gestionar el paquete*/
            $codNombreEstado = $this->Bandejasestado->obtenerEstadosPorBandeja($bandejaId);
            foreach($codNombreEstado as $valor){
                $listEstadosBandeja[$valor['Estado']['id']] =  "<b>" . $valor['Estado']['descripcion'] . "</b> (" . $valor['Etiquetacambioestado']['descripcion'] . ")";
            }            
            
            /*Se obtienen las observaciones realizadas sobre el paquete*/
            $observacion = $this->Observacione->obtenerObservacionesPorPaqueteId($paqueteId);           

            /*Se obtiene el documento del paquete*/
            $documentosPaq = $this->Documentospaquete->obtenerDocsPaquetePorPaqteId($paqueteId);                      

            /*Si el oficio tiene mas de un documento anexado, se concatenan y se elmina el registro del doc concatenado, dejando el primero como registro*/
            if(count($documentosPaq) > 1){
                $documentosPaquete = new DocumentospaquetesController();
                $urlRaizDocs = $this->Configuraciondato->obtenerInfo($dato = 'dirPaquetes');

                $arrDocumentos = array();
                for($i = 0; $i < count($documentosPaq); $i++){
                    $arrDocumentos[$i] = $urlRaizDocs . $documentosPaq[$i]['Documentospaquete']['url_fisica'];                    
                }
                
                $documentosPaquete->concatenarPDF($arrDocumentos, $urlRaizDocs . $documentosPaq['0']['Documentospaquete']['url_fisica']);

                /*Se elimina el registro de documentospaquetes del archivo concatenado*/
                for($j = 1; $j < count($documentosPaq); $j++){
                    $this->Documentospaquete->desactivarDocPaquete($documentosPaq[$j]['Documentospaquete']['id']);
                }
            }

            /*Se obtiene el ultimo registro en trazabilidad con estado FALSE para obtener el paso previo del paquete*/
            $ultimaTraza = $this->Trazabilidade->consultarTrazaPreviaActual($paqueteId);

            /*Se obtienen los datos del usuario logueado*/
            $datosUsuarioLogin = $this->Auth->user();                 
            
            /*Se obtiene la url del proyecto para mostrar los documentos de cada paquete*///"url_raizproyserver"
            $urlDocs = $this->Configuraciondato->obtenerInfo($dato = 'url_raizproyserver') . "/repositorio/";
            
            /*Se obtiene la información del estado actual*/
            $arrInfoEstado = $this->Estado->obtenerEstadoPorId($estadoId);
            /*Se valida si el estado es de tipo "anulado"*/
            if($arrInfoEstado['Estado']['estadoanulado'] == '1'){
                $motivoPaquete = $this->MotivosrechazosPaquete->obtenerUltimoMotivoPaquete($paqueteId);
            }

            $this->set(compact('permisobandejaId','paqueteId','fechaCreacion','fechaDigitalizacion','numeroOficio'));
            $this->set(compact('estado','nombreOficina','oficinaId','bandejaId','listEstadosBandeja', 'motivoPaquete'));
            $this->set(compact('observacion','ultimaTraza','documentosPaq', 'datosUsuarioLogin', 'estadoId', 'urlDocs', 'numeroCredencial'));
        }        
    }
    
    public function guardargestionpaquete(){
        
        if($this->request->is('post')){
            $this->loadModel('Auditoria');
            $this->loadModel('Observacione');
            $this->loadModel('Paquete');
            $this->loadModel('PaquetesUsuario');
            $this->loadModel('Trazabilidade');
            $this->loadModel('Estado');
            $this->loadModel('Usuario');
            $this->loadModel('Relacionbandejasestado');
            $this->loadModel('Bandejasestado');
            $this->loadModel('Documentospaquete');
            $this->loadModel('MotivosrechazosPaquete');
            $estadosController = new EstadosController();

            $posData = $this->request->data;

            $usuarioId = $this->Auth->user('id');
            $paqueteId = $posData['paqueteId'];            
            $descrBandejaAct = $posData['bandejaActual'];
            $oficinaId = $posData['oficinaId'];
            $estadoId = $posData['estadoId'];
            $bandejaId = $posData['bandejaId'];
            $numOficio = $posData['numOficio'];
            $obsDevOficio = $posData['obsDevOfi'];            
            $obsGeneral = $posData['obsGeneral'];             
            $nuevoEstadoId = $posData['Bandeja']['envioBandeja'];
            $motivoRechazoId = $posData['motivorechazo'];
            
            /*Se obtiene la informacion completa del paquete, del estado en que se encuentra y la oficina a la que pertenece*/
            $arrOficio = $this->Paquete->obtenerInfoPaquete($paqueteId);

            //Se obtiene la información de la relación bandeja-estado del estado en que se encuentra actualmente el paquete
            $arrBandeja = $this->Relacionbandejasestado->obtenerInfoRelacionBE($arrOficio['Paquete']['estado_id']);

            //Se obtiene la información para validar si el flujo seleccionado requiere análisis de cargas
            $arrSecuencia = $this->Bandejasestado->secuenciaFlujo($arrBandeja['Relacionbandejasestado']['bandeja_id'], $nuevoEstadoId);

            //Se obtiene la bandeja hacia donde se envia el paquete
            $arrBandejaDestino = $this->Relacionbandejasestado->obtenerInfoRelacionBE($nuevoEstadoId);

            //Se valida si el paquete ya ha sido gestionado por un usuario en el estado al que se desea enviar
            $paqUsrId = $estadosController->obtenerUltimoUsuarioGestionPaq($paqueteId, $arrBandejaDestino['Relacionbandejasestado']['bandeja_id'], $oficinaId);

            /*Se obtiene la informacion del nuevo estado del paquete*/
            $arrNuevoEstado = $this->Estado->obtenerEstadoPorId($nuevoEstadoId);                        

            if(isset($arrSecuencia['Bandejasestado']) && $arrSecuencia['Bandejasestado']['analisiscargas'] == '1' && $paqUsrId == ""){
                /*Se asigna el paquete por analisis de cargas*/
                $paqUsrId = $this->asignacionAnalisisCargas($paqueteId, $estadoId, $arrOficio['Paquete']['oficina_id']);                
            }else if(isset($arrSecuencia['Bandejasestado']) && $arrSecuencia['Bandejasestado']['analisiscargas'] != '1' && $paqUsrId == "" && $arrNuevoEstado['Estado']['estadofinal'] == '1'){
                /*obtengo el paqueteusuario que se va deshabilitar*/
                $paqUsrId = $this->PaquetesUsuario->obtenerPaqueteUsuarioPaqId($paqueteId);                
                /*Se retira el paquete al usuario asignado*/
                $this->retirarPaqueteUsuario($paqueteId);                              
            }else if($paqUsrId != ""){
                /*Se retira el paquete al usuario asignado*/
                $this->retirarPaqueteUsuario($paqueteId);
                /*Se asigna el paquete al usuario por analisis de cargas*/
                $this->PaquetesUsuario->activarPaqueteUsuario($paqUsrId);               
            }  

            if($paqUsrId == "" || $paqUsrId == null){
                $this->Session->setFlash(__('No se pudo realizar la gestión de la solicitud. Por favor, inténtelo de nuevo.'));
                $this->redirect(array('action' => 'listarpaquetes/' . $bandejaId));                 
            }else{            
                /*Si la nueva bandeja es de tipo "rechazo" se envia el correo de la devolución*/
                if(count($arrNuevoEstado) > 0 && $arrNuevoEstado['Estado']['estadoanulado'] == '1'){
                    
                    /*Se valida si el nuevo estado es "pendientes" y el motivo específico es "faltan soportes" para eliminar el documento*/
                    if($arrNuevoEstado['Estado']['id'] == '2' && $motivoRechazoId == '9'){
                        //Se obtienen los documentos del paquete
                        $arrDocsPaquete = $this->Documentospaquete->obtenerDocsPorPaqteId($paqueteId);
                        foreach($arrDocsPaquete as $documentos){
                            $this->Documentospaquete->desactivarDocPaquete($documentos['Documentospaquete']['id']);
                        }

                        /*Se registra la eliminación del documento*/
                        $accionAud = $this->Auditoria->accionAuditoria($mensajeId = '1');
                        $arrDescripcionAud['numOficio'] = $numOficio;
                        $descripcionAud = $this->Auditoria->descripcionAuditoria($id = '1', $arrDescripcionAud);
                        $this->Auditoria->logAuditoria($usuarioId, $descripcionAud, $accionAud);                                                          
                    }
                    
                    /*Se registra el motivo de rechazo seleccionado por el usuario*/
                    $this->MotivosrechazosPaquete->guardarEstadoMotivoRechazo($motivoRechazoId, $paqueteId);

                    /*Envio de alerta*/
//                    $this->correoDevolucionPaquete($arrOficio, $motivoRechazoId, $obsDevOficio, $arrBandejaDestino, $paqUsrId);
                }

                /*Se realiza el registro del nuevo estado para el paquete y el numero de oficio*/
                if(isset($nuevoEstadoId)){
                    $this->Paquete->actualizarEstadoPaqueteAdmin($paqueteId, $nuevoEstadoId);
                }                
                
                /*Se registran las observaciones del oficio, las generales y se concatenan las observacion de devolucion en caso que existan*/ 
                if($obsDevOficio != ""){
                    $obsGeneral = $obsGeneral . "\n" . $obsDevOficio . "\n___";
                }                             
                $this->guardarObservacionOficio($paqueteId, $obsGeneral);
                
                /*Se registra en trazabilidad el cambio de estado*/
                $this->guardarTrazabilidadOficio($estadoId, $nuevoEstadoId, $paqueteId, $usuarioId, $paqUsrId);

                /*Se registra en auditoria el cambio de estado del paquete/oficio */
                $accionAud = $this->Auditoria->accionAuditoria($mensajeId = '0');
                $arrDescripcionAud['numOficio'] = $numOficio;
                $arrDescripcionAud['estOrigen'] = $descrBandejaAct;
                $arrDescripcionAud['estDestino'] = $arrNuevoEstado['Estado']['descripcion'];

                $descripcionAud = $this->Auditoria->descripcionAuditoria($id = '0',$arrDescripcionAud);
                $this->Auditoria->logAuditoria($usuarioId, $descripcionAud, $accionAud);

                $this->Session->setFlash(__('La solicitud se gestionó correctamente.'));
                $this->redirect(array('action' => 'listarpaquetes/' . $bandejaId));            
            }       
        }
    }    
    
    public function obtenerUbicacionPaquete($oficinaId){
        $this->loadModel('Oficina');
        $this->loadModel('Ciudade');
        $arrUbicacion = array();
        
        /*Se obtiene la informacion de la oficina para capturar la descripcion de la ciudad y el id de la misma*/
        $arrOficina = $this->Oficina->obtenerInfoOficina($oficinaId);

        /*Se realiza consulta a la ciudad para obtener la regional a la cual pertenecen*/
        $arrCiudad = $this->Ciudade->obtenerInfoCiudad($arrOficina['Ciudade']['id']);

        $arrUbicacion['ciudad'] = $arrOficina['Ciudade']['descripcion'];
        $arrUbicacion['ciudad_id'] = $arrOficina['Ciudade']['id'];
        $arrUbicacion['regional'] = $arrCiudad['Regionale']['descripcion'];
        $arrUbicacion['regional_id'] = $arrCiudad['Regionale']['id'];

        return $arrUbicacion;
    }
    
    public function asignacionAnalisisCargas($paqueteId, $nuevoEstadoId, $oficinaId){
        $this->loadModel('Usuario');
        $this->loadModel('Bandeja');
        $this->loadModel('PaquetesUsuario');
        $this->loadModel('Relacionbandejasestado');
        
        /*Se obtiene el id de la bandeja para filtrar los usuarios que tienen permisos de gestion sobre ésta*/
        $arrBandeja = $this->Relacionbandejasestado->obtenerInfoRelacionBE($nuevoEstadoId);

        /*Se obtienen los usuario que tienen permiso sobre la regional y de gestion sobre la bandeja*/
        $arrUsuarios = $this->Usuario->obtenerUsuarioGestionPaquete($oficinaId, $arrBandeja['Relacionbandejasestado']['bandeja_id'], $usuarioId=null);
                
        if(!isset($arrUsuarios[0])){
            return;
        }else{
            
            /*Se buscan los usuario a los cuales se les ha asignado paquetes, si existe uno sin registro, se le 
              asigna, de tener registro todos, se le asigna al de la fecha mas antigua*/
            $arrAnalisisCarg = array();
            foreach ($arrUsuarios as $clvUsu => $valUsu){
                $fechaAsig = $this->PaquetesUsuario->obtenerFechaAsigPaquete($valUsu['Usuario']['id']);
                $arrAnalisisCarg[$clvUsu]['fecha_asignado'] = $fechaAsig;
                $arrAnalisisCarg[$clvUsu]['usuario'] = $valUsu['Usuario']['id'];
            }       

            /*Se ordena el array para obtener el usuario al cual se le va asignar el oficio*/
            function ordenar( $a, $b ) {
                return strtotime($a['fecha_asignado']) - strtotime($b['fecha_asignado']);
            }
            usort($arrAnalisisCarg, 'ordenar');

            /*Se retira el paquete al usuario asignado*/
            $this->retirarPaqueteUsuario($paqueteId);

            /*Se asigna el paquete al usuario por analisis de cargas*/
            $paqUsrId = $this->asignarPaqueteUsuario($arrAnalisisCarg['0']['usuario'], $paqueteId);

            return $paqUsrId;            
        }
    }
    
    public function retirarPaqueteUsuario($paqueteId){
        $this->loadModel('PaquetesUsuario');
        
        /*Se obtiene el registro donde se encuentra el paquete asignado a un usuario*/
        $paqUsrId = $this->PaquetesUsuario->obtenerPaqueteUsuarioPaqId($paqueteId); 
        if($paqUsrId != "" || $paqUsrId != null){
            $this->PaquetesUsuario->retirarPaqueteUsuario($paqUsrId);            
        }
    }
    
    public function asignarPaqueteUsuario($usuarioId, $paqueteId){
        $this->loadModel('PaquetesUsuario');  
        $asignar = '1';
        $paqUsrId = $this->PaquetesUsuario->asignarPaqueteUsuario($usuarioId, $paqueteId, $asignar);        
        return $paqUsrId;
    }
    
    public function guardarObservacionOficio($paqueteId, $obsGeneral){
        $this->loadModel('Observacione');
        
        /*Se obtiene el id de la observacion*/
        $arrObs = $this->Observacione->obtenerObservacionesPorPaqueteId($paqueteId);
        
        $obsId = "";
        if(count($arrObs) > 0){
            $obsId = $arrObs['0']['Observacione']['id'];
        }
        
        $this->Observacione->saveObservaciones($obsId, $paqueteId, $obsGeneral);
    }

    public function guardarTrazabilidadOficio($estadoId, $nuevoEstadoId, $paqueteId, $usuarioId, $paqUsrId){   

        $this->loadModel('Trazabilidade');
        
        /*Se obtiene el último regitro de trazabilidad*/
        $arrTrazabilidad = $this->Trazabilidade->consultarUltimaTrazaPaquete($paqueteId);

        /*Se obtiene los dias que el paquete ha estado en espera de gestion*/
        $diasEspera = $this->calcularDiasPaqueteEnEspera($paqueteId);

        /*Se pasa a false el ultimo registro de trazabilidad para indicar que ya se gestionó el paquete*/
        $this->Trazabilidade->actualizarUltimaTraza($arrTrazabilidad['Trazabilidade']['id'],$diasEspera);
        
        /*Se crea el nuevo registro en trazabilidad*/
        $this->Trazabilidade->guardarTrazabilidad($estadoId, $nuevoEstadoId, $paqueteId, $usuarioId, $paqUsrId);
        
    }
    
    
    public function actualizarOficioPorAdminAjax(){
        $this->loadModel('Paquete');
        $this->loadMOdel('Auditoria');
                
        $this->autoRender = false;
        $postData = $this->request->data;
        
        $paqueteId = $postData['paqueteId'];
        $nuevoNumeroOf = $postData['numOficio'];
        
        /*Se obtiene la informacion del paquete*/
        $arrPaquete = $this->Paquete->obtenerInfoPaquete($paqueteId); 
        
        /*Se crea la nueva carpeta del oficio y se trasladan los archivos que pertenecen al mismo*/
        $this->cambiarNumeroOficio($paqueteId, $nuevoNumeroOf);        
        
        $salida = $this->Paquete->actualizarOficioPorAdmin($paqueteId, $nuevoNumeroOf);
        
        if($salida){
            /*Se registra el cambio del número por parte del administrador*/
            $accionAud = $this->Auditoria->accionAuditoria($mensajeId = '3');
            $arrDescripcionAud['numOficio'] = $arrPaquete['Paquete']['numero_oficio'];
            $arrDescripcionAud['numOficioNuevo'] = $nuevoNumeroOf;
            $descripcionAud = $this->Auditoria->descripcionAuditoria($id = '3', $arrDescripcionAud);
            $this->Auditoria->logAuditoria($this->Auth->user('id'), $descripcionAud, $accionAud);             
            
            echo json_encode(array('respuesta' => 'Se actualizó el número de la solicitud', 'bool' => true));     
        }else{
            echo json_encode(array('respuesta' => 'No se pudo realizar el cambio de la solicitud. Por favor, inténtelo de nuevo', 'bool' => false));            
        }        
    }

    public function search() {
            // the page we will redirect to
            $url=array();
            if($this->data['Bandeja']['accion_anterior']=='add'){
                $url['action'] = 'add';
            }else if($this->data['Bandeja']['accion_anterior']=='index'){
                $url['action'] = 'index';
            }

            foreach ($this->data as $k=>$v){
                if($k!='Bandeja'){
                    foreach ($v as $kk=>$vv){ 
                            $url[$k.'.'.$kk]=$vv; 
                    } 
                }
            }

            // redirect the user to the url
            $this->redirect($url, null, true);
    }
    
    public function searchListarPaquetes() {

             // the page we will redirect to
             $url=array();
             $arrUrl = split('/', $this->request->data['Bandejas']['Bandeja']); 
             $url['action'] = 'listarpaquetes/' . $arrUrl['5'];

             if(isset($this->data['Search']['FechaDesde'])){
                 $this->request->data['Search']['FechaDesde'] = str_replace("/", "-", $this->data['Search']['FechaDesde']);
             }
             
             if(isset($this->data['Search']['FechaDesde'])){
                 $this->request->data['Search']['FechaHasta'] = str_replace("/", "-", $this->data['Search']['FechaHasta']);
             }                          
             
             foreach ($this->data as $k=>$v){
                 if($k!='Bandejas'){
                     foreach ($v as $kk=>$vv){ 
                             $url[$k.'.'.$kk]=$vv;
                     } 
                }
             }
             // redirect the user to the url
             $this->redirect($url, null, true);
     } 
     
     public function cambiarNumeroOficio($paqueteId, $nuevoNumeroOficio){
         $this->loadModel('Paquete');
         $this->loadModel('Configuraciondato');
         $this->loadModel('Documentospaquete');
         
         $arrPaquete = $this->Paquete->obtenerInfoPaquete($paqueteId);
         if($nuevoNumeroOficio != $arrPaquete['Paquete']['numero_oficio']){
             
             /*Se obtiene la ubicacion actual del oficio*/
             $arrUbicacion = $this->obtenerUbicacionPaquete($arrPaquete['Paquete']['oficina_id']);
             
             /*Se obtienen los documentos del oficio que seran movidos a la nueva ubicacion*/
             $docOficio = $this->Documentospaquete->obtenerDocsPorPaqteId($paqueteId);
             
             /*Se obtiene la url raiz de los documentos*/
             $urlRaiz = $this->Configuraciondato->obtenerInfo($dato= 'dirPaquetes');
             $url = $urlRaiz . "\\" . $arrUbicacion['regional_id'] . "\\" . $arrUbicacion['ciudad_id'] . "\\" . $arrPaquete['Paquete']['oficina_id'] . "\\";

             /*Se crea la nueva carpeta si ésta no existe*/
             if(!file_exists($url . $nuevoNumeroOficio )){
                    mkdir($url . $nuevoNumeroOficio, 0777, true);
             }
             
             /*Se cambia la ubicacion de los documentos asociados al oficio*/
             foreach($docOficio as $clv => $val){
                 rename ($url . $arrPaquete['Paquete']['numero_oficio'] . "\\" . $val['Documentospaquete']['url_fisica'], $url . $nuevoNumeroOficio . "\\" . $val['Documentospaquete']['url_fisica']);
             }
             
         }
         
     }
     
     public function formObservacionesDevOficio(){
         $this->loadModel('EstadosMotivosrechazo');
         
         $posData = $this->request->data;
         
         $arrEstadoRechazo = $this->EstadosMotivosrechazo->estadosMotivosRechazoEstId($posData['estadoId']);
         
         foreach ($arrEstadoRechazo as $motivos){
             $motivosRechazoList[$motivos['Motivosrechazo']['id']] = $motivos['Motivosrechazo']['descripcion'];
         }

         //Se obtiene el listado de motivos de rechazo segun el tipo de rechazo que se realiza sobre el paquete         
         $nombreUsuario = $this->Auth->user('nombre');
         $fechaActual = date("Y-m-d H:i:s");
         $this->set(compact('nombreUsuario', 'fechaActual', 'motivosRechazoList'));
     }
     
     
     public function correoDevolucionPaquete($arrOficio, $motivoRechazoId, $obsDevOficio, $arrBandejaDestino, $paqUsrId){
         
        $this->loadModel('Estado');
        $this->loadModel('Motivosrechazo');
        $this->loadModel('PaquetesUsuario');
        $this->loadModel('Usuario');
        
        $arrPaqUsr = $this->PaquetesUsuario->obtenerPaquetesUsuarioPorId($paqUsrId);
        $arrUsuario = $this->Usuario->obtenerUsuarioPorId($arrPaqUsr['PaquetesUsuario']['usuario_id']);
        $arrEstado = $this->Estado->obtenerEstadoPorId($arrBandejaDestino['Relacionbandejasestado']['estado_id']);
        $arrMotivos = $this->Motivosrechazo->obtenerMotivoPorId($motivoRechazoId);
            
        $cuerpoCorreo['numCredencial'] = $arrOficio['Paquete']['numerocredencial'];
        $cuerpoCorreo['numSolicitud'] = $arrOficio['Paquete']['numerosolicitud'];
        $cuerpoCorreo['estado'] = $arrEstado['Estado']['descripcion'];
        $cuerpoCorreo['rechazo'] = $arrMotivos['Motivosrechazo']['descripcion'];
        $cuerpoCorreo['auditor'] = $this->Auth->user('nombre');
        $cuerpoCorreo['observacion'] = $obsDevOficio;
        $cuerpoCorreo['fechaactual'] = date("Y-m-d H:i:s");
        $cuerpoCorreo['fechacreacion'] = $arrOficio['Paquete']['fechacreacion'];
        
        $mensajeCorreo = "Se devuelve Solicitud con numero de credencial: " . $cuerpoCorreo['numCredencial'] . " y ";
        $mensajeCorreo .= "numero de solicitud: " . $cuerpoCorreo['numSolicitud'] . " al estado: ";
        $mensajeCorreo .= $cuerpoCorreo['estado'] . " con el siguiente motivo: " . $cuerpoCorreo['rechazo'] . ".\n\n";
        $mensajeCorreo .= "Auditor que devuelve la solicitud: " . $cuerpoCorreo['auditor'] . ".\n\n";
        $mensajeCorreo .= "Observaciones: \n";
        $mensajeCorreo .= $cuerpoCorreo['observacion'] . ".\n\n";
        $mensajeCorreo .= "Fecha de devolucion de la Solicitud: " . $cuerpoCorreo['fechaactual'] . ".\n\n";
        $mensajeCorreo .= "Fecha de digitalizacion de la Solicitud: " . $cuerpoCorreo['fechacreacion'] . ".\n\n";

        $utilidad = new UtilidadesController();
        $utilidad->send_mail(
                $utilidad->asuntoCorreo(0), 
                $arrUsuario['Usuario']['nombre'], 
                $arrUsuario['Usuario']['correoelectronico'], 
                $mensajeCorreo
                );             
     }
	 
    public function calcularDiasCreacionPaquete($fechaCreacion){
        $this->loadModel('Diasfestivo');

            $arrFechaCreacion = split(" ", $fechaCreacion);
            $fechaActual = date("Y-m-d");
            $fechaAnterior = strtotime(h($arrFechaCreacion[0]));
            $dias = floor(abs((strtotime($fechaActual)-$fechaAnterior)/86400));
            $diasFestivos = $this->Diasfestivo->obtenerDiasFestivos($arrFechaCreacion[0], $fechaActual);
            $diasTotal = ($dias) - $diasFestivos;
            return $diasTotal;             
    }  	 

}
