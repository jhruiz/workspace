<?php
App::uses('AppController', 'Controller');
App::uses('BandejasController', 'Controller');
App::uses('PaquetesUsuarioController', 'Controller');
/**
 * Estados Controller
 *
 * @property Estado $Estado
 * @property PaginatorComponent $Paginator
 */
class EstadosController extends AppController {

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
                $paginate['Estado.descripcion LIKE '] = '%' . $this->passedArgs['Search.Nombre'] . '%';
            }            

            $this->Estado->recursive = 0;

            if (empty($paginate)) {
                $this->set('estados', $this->Paginator->paginate());
            } else {
                $this->set('estados', $this->Paginator->paginate('Estado', $paginate));
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
		if (!$this->Estado->exists($id)) {
			throw new NotFoundException(__('El estado no existe'));
		}
		$options = array('conditions' => array('Estado.' . $this->Estado->primaryKey => $id));
		$this->set('estado', $this->Estado->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Estado->create();
			if ($this->Estado->save($this->request->data)) {
				$this->Session->setFlash(__('El estado ha sido guardado.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('El estado no pudo guardado. Por favor, inténtelo de nuevo.'));
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
		if (!$this->Estado->exists($id)) {
			throw new NotFoundException(__('El estado no existe'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Estado->save($this->request->data)) {
				$this->Session->setFlash(__('El estado ha sido guardado.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('El estado no pudo ser guardado. Por favor, inténtelo de nuevo.'));
			}
		} else {
			$options = array('conditions' => array('Estado.' . $this->Estado->primaryKey => $id));
			$this->request->data = $this->Estado->find('first', $options);
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
		$this->Estado->id = $id;
		if (!$this->Estado->exists()) {
			throw new NotFoundException(__('El estado no existe'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Estado->delete()) {
			$this->Session->setFlash(__('El estado ha sido eliminado.'));
		} else {
			$this->Session->setFlash(__('El estado no pudo ser eliminado. Por favor, inténtelo de nuevo.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
        
    public function validaestadorechazo(){            
        
        $this->layout='ajax';
        $this->autoRender=false;                                

        $response['valido']=true;

        if($this->request->is("post")){
            $estadoId = $this->request->data("estadoId");
            $arrEstado = $this->Estado->obtenerEstadoPorId($estadoId);

            if(isset($arrEstado) && count($arrEstado) > 0){
                $estadoAnulado = $arrEstado['Estado']['estadoanulado'];
                if(!$estadoAnulado){
                    $response['valido']=false;
                }
            }                
        }                          
        return json_encode($response);        
    }
        
    /**
     * Funcion que crea un formulario en un div para cambiar la bandeja de un oficio
     */
    public function formcambiarbandejapaquete(){
        
        $this->layout='ajax';
        $this->loadModel('Paquete');
        $this->loadModel('PaquetesUsuario');
        $this->loadModel('Permisousuariobandeja');
        $this->loadModel('Relacionbandejasestado');
        $this->loadModel('PrivilegiosUsuario');
        $this->loadModel('Privilegio');
        $this->loadModel('Bandejasestado');
        
        if($this->request->is("post")){            
            $paqueteId = $this->request->data("paquete_id");
            $paquetesusuarioId = $this->request->data('paquetesusuario_id');

            /*Se obtiene la información del paquete*/
            $arrPaquete = $this->Paquete->obtenerInfoPaquete($paqueteId);            

            /*Se obtiene la bandeja por el id del estado*/
            $arrBandejaEstado = $this->Relacionbandejasestado->obtenerInfoRelacionBE($arrPaquete['Paquete']['estado_id']);

            /*Se obtiene el id del estado y el nombre del mismo*/
            $codNombreEstado = $this->Bandejasestado->obtenerEstadosPorBandeja($arrBandejaEstado['Relacionbandejasestado']['bandeja_id']);

            foreach($codNombreEstado as $valor){
                    $arrRelBandEst[$valor['Estado']['id']] =  $valor['Estado']['descripcion'] . " (" . $valor['Etiquetacambioestado']['descripcion'] . ")";                    
            }  

            //Se obtiene el id del privilegio que se desea obtener del usuario que realiza la gestión
            $permisoTrl = "Traslado";
            $privilegioTraslado = $this->Privilegio->obtenerIdPrivilegio($permisoTrl);
            
            /*Se obtiene la informacion del usuario logueado*/
            $usrLogin = $this->Auth->user();

            //Se valida si el usuario que está realizando la gestión tiene permisos para trasladar archivos
            $permisoTraslado = $this->PrivilegiosUsuario->obtenerPrivilegiosPorUsuario($usrLogin['id'], $privilegioTraslado);                  

            $this->set(compact('paqueteId','paquetesusuarioId','permisoTraslado','arrRelBandEst'));
        }        
    }
    
    public function cambiarpaqueteestado(){
        $this->layout='ajax';
        $BandejasController = new BandejasController; 
        $this->loadModel('Paquete');
        $this->loadModel('Estado');
        $this->loadModel('Auditoria');
        $this->loadModel('Documentospaquete');
        $this->loadModel('Observacione');
        $this->loadModel('Trazabilidade'); 
        $this->loadModel('Relacionbandejasestado');
        $this->loadModel('Bandejasestado');
        $this->loadModel('PaquetesUsuario');

        if($this->request->is("post")){
            $estado = false;
            $paqueteId = $this->request->data("paquete_id");
            $estadoId = $this->request->data("estado_id"); 

            /*Se obtiene la informacion completa del paquete, del estado en que se encuentra y la oficina a la que pertenece*/
            $arrOficio = $this->Paquete->obtenerInfoPaquete($paqueteId);

            //Se obtiene la información de la relación bandeja-estado
            $arrBandeja = $this->Relacionbandejasestado->obtenerInfoRelacionBE($arrOficio['Paquete']['estado_id']);

            //Se obtiene la información para validar si el flujo seleccionado requiere análisis de cargas
            $arrSecuencia = $this->Bandejasestado->secuenciaFlujo($arrBandeja['Relacionbandejasestado']['bandeja_id'], $estadoId);

            //Se obtiene la bandeja hacia donde se envia el paquete
            $arrBandejaDestino = $this->Relacionbandejasestado->obtenerInfoRelacionBE($estadoId);

            //Se valida si el paquete ya ha sido gestionado por un usuario en el estado al que se desea enviar
            $paqUsrId = $this->obtenerUltimoUsuarioGestionPaq($paqueteId, $arrBandejaDestino['Relacionbandejasestado']['bandeja_id'], $arrOficio['Paquete']['oficina_id']);

            /*Se obtiene la informacion del nuevo estado del paquete*/
            $arrNuevoEstado = $this->Estado->obtenerEstadoPorId($estadoId);
            
            if(isset($arrSecuencia['Bandejasestado']) && $arrSecuencia['Bandejasestado']['analisiscargas'] == '1' && $paqUsrId == ""){
                /*Se asigna el paquete por analisis de cargas*/
                $paqUsrId = $BandejasController->asignacionAnalisisCargas($paqueteId, $estadoId, $arrOficio['Paquete']['oficina_id']);                
            }else if(isset($arrSecuencia['Bandejasestado']) && $arrSecuencia['Bandejasestado']['analisiscargas'] != '1' && $paqUsrId == "" && $arrNuevoEstado['Estado']['estadofinal'] == '1'){
                /*obtengo el paqueteusuario que se va deshabilitar*/
                $paqUsrId = $this->PaquetesUsuario->obtenerPaqueteUsuarioPaqId($paqueteId);
                
                /*Se retira el paquete al usuario asignado*/
                $BandejasController->retirarPaqueteUsuario($paqueteId);                              
            }else if($paqUsrId != ""){
                /*Se retira el paquete al usuario asignado*/
                $BandejasController->retirarPaqueteUsuario($paqueteId);

                /*Se asigna el paquete al usuario por analisis de cargas*/
                $this->PaquetesUsuario->activarPaqueteUsuario($paqUsrId);               
            }

            if($paqUsrId == "" || $paqUsrId == null){
                $estado = FALSE;
            }else{

                /*Si la nueva bandeja es de tipo "rechazo" se elimina el documento de la solicitud*/
                if(count($arrNuevoEstado) > 0 && $arrNuevoEstado['Estado']['estadoanulado'] == '1' && $arrNuevoEstado['Estado']['id'] == '2'){
                    //Se obtienen los documentos del paquete
                    $arrDocsPaquete = $this->Documentospaquete->obtenerDocsPorPaqteId($paqueteId);
                    foreach($arrDocsPaquete as $documentos){
                        $this->Documentospaquete->desactivarDocPaquete($documentos['Documentospaquete']['id']);
                    }

                    /*Se registra la eliminación del documento*/
                    $accionAud = $this->Auditoria->accionAuditoria($mensajeId = '1');
                    $arrDescripcionAud['numOficio'] = $arrOficio['Paquete']['numerocredencial'];
                    $descripcionAud = $this->Auditoria->descripcionAuditoria($id = '1', $arrDescripcionAud);
                    $this->Auditoria->logAuditoria($this->Auth->user('id'), $descripcionAud, $accionAud);                
                }     

                /*Se realiza el registro del nuevo estado para el paquete y el numero de oficio*/
                $this->Paquete->actualizarEstadoPaqueteAdmin($paqueteId, $estadoId);

                /*Se registra en trazabilidad el cambio de estado*/
                $BandejasController->guardarTrazabilidadOficio($arrOficio['Paquete']['estado_id'], $estadoId, $paqueteId, $this->Auth->user('id'), $paqUsrId);           

                /*Se registra en auditoria el cambio de estado del paquete/oficio */
                $accionAud = $this->Auditoria->accionAuditoria($mensajeId = '0');
                $arrDescripcionAud['numOficio'] = $arrOficio['Paquete']['numerocredencial'];
                $arrDescripcionAud['estOrigen'] = $arrOficio['Estado']['descripcion'];
                $arrDescripcionAud['estDestino'] = $arrNuevoEstado['Estado']['descripcion'];

                $descripcionAud = $this->Auditoria->descripcionAuditoria($id = '0',$arrDescripcionAud);
                $this->Auditoria->logAuditoria($this->Auth->user('id'), $descripcionAud, $accionAud);            

                if($paqUsrId != '0' && $paqUsrId != ""){
                    $estado = TRUE;
                }                
            }                       
            echo json_encode(array('estado' => $estado)); 
            
        }  
        exit();
    }
    
    public function search() {
            // the page we will redirect to
            $url=array();
            if($this->data['Estado']['accion_anterior']=='add'){
                $url['action'] = 'add';
            }else if($this->data['Estado']['accion_anterior']=='index'){
                $url['action'] = 'index';
            }

            foreach ($this->data as $k=>$v){
                if($k!='Estado'){
                    foreach ($v as $kk=>$vv){ 
                            $url[$k.'.'.$kk]=$vv; 
                    } 
                }
            }

            // redirect the user to the url
            $this->redirect($url, null, true);
    }
    
    public function AjaxEstadoCargueArchivos(){    
        $this->autoRender = false;        
        
        if(isset($this->request->data['oficioSel'])){
            $this->loadModel('Paquete');
            $arrPaquete = $this->Paquete->obtenerInfoPaquete($this->request->data['oficioSel']);
            $estadoId = $arrPaquete['Paquete']['estado_id'];
        }else{
            $estadoId = ($this->request->data['estadoId']);            
        }

        $arrEstado = $this->Estado->obtenerEstadoPorId($estadoId);
        if($arrEstado['Estado']['adjuntararchivos'] == '1'){            
           echo json_encode(array('bool' => "true"));
        }else{
            echo json_encode(array('bool' => "false"));
        }
        exit();            
    }
    
    //Se obtiene el ultimo paquete_usuario que gestionó el paquete en el estado inmediatamente anterior para retornarselo
    public function obtenerUltimoUsuarioGestionPaq($paqueteId, $bandejaId, $oficinaId){
        $this->loadModel('PaquetesUsuario');
        $this->loadModel('OficinasUsuario');
        
        $paqueteUsuarioFinal = "";
        
        //Se obtienen todos los usaurios que han gestionado el paquete en orden ascendente
        $arrPaqUsr = $this->PaquetesUsuario->obtenerUsuarioGestionPq($paqueteId);
        
        //se obtiene el usuario con los permisos de gestion sobre la bandeja en la oficicina a la que pertenece el paquete
        foreach ($arrPaqUsr as $paqUsr){
            $arrPermGest = $this->OficinasUsuario->validarPermisosUsuario($oficinaId, $paqUsr['PaquetesUsuario']['usuario_id'], $bandejaId);
            if(count($arrPermGest) > '0'){
                $paqueteUsuarioFinal = $paqUsr['PaquetesUsuario']['id'];
                break;
            }            
        }
        
        return $paqueteUsuarioFinal;
    }    
    
            
}
