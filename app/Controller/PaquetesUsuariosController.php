<?php
App::uses('AppController', 'Controller');
App::uses ('BandejasController', 'Controller');
App::uses ('PaquetesController', 'Controller');

/**
 * PaquetesUsuarios Controller
 *
 * @property PaquetesUsuario $PaquetesUsuario
 * @property PaginatorComponent $Paginator
 */
class PaquetesUsuariosController extends AppController {

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
            $paginate=array();
            if(isset($this->passedArgs['Search.Oficio']) && !empty($this->passedArgs['Search.Oficio'])) {
                    $paginate['Paquete.numero_oficio LIKE '] = '%'.$this->passedArgs['Search.Oficio'].'%';

            }

            $this->PaquetesUsuario->recursive = 0;

            if(empty($paginate)){
                $this->Paginator->settings = $this->PaquetesUsuario->obtenerPaquetesUsuario();   
                $paquetesUsuarios = $this->Paginator->paginate('PaquetesUsuario');
                $this->set(compact('paquetesUsuarios'));
            }else{
                $this->Paginator->settings = $this->PaquetesUsuario->obtenerPaquetesUsuario();   
                $paquetesUsuarios = $this->Paginator->paginate('PaquetesUsuario', $paginate);
                $this->set(compact('paquetesUsuarios'));                          
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
		if (!$this->PaquetesUsuario->exists($id)) {
			throw new NotFoundException(__('El paquete - usuario no existe'));
		}
		$options = array('conditions' => array('PaquetesUsuario.' . $this->PaquetesUsuario->primaryKey => $id));
		$this->set('paquetesUsuario', $this->PaquetesUsuario->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->PaquetesUsuario->create();
			if ($this->PaquetesUsuario->save($this->request->data)) {
				$this->Session->setFlash(__('The paquetes usuario has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The paquetes usuario could not be saved. Please, try again.'));
			}
		}
		$paquetes = $this->PaquetesUsuario->Paquete->find('list');
		$usuarios = $this->PaquetesUsuario->Usuario->find('list');
		$this->set(compact('paquetes', 'usuarios'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->PaquetesUsuario->exists($id)) {
			throw new NotFoundException(__('La relación paquete - usuario no existe.'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->PaquetesUsuario->save($this->request->data)) {
				$this->Session->setFlash(__('La relación paquete - usuario ha sido guardada.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('La relación paquete - usuario no pudo ser guardada. Por favor, inténtelo de nuevo.'));
			}
		} else {
			$options = array('conditions' => array('PaquetesUsuario.' . $this->PaquetesUsuario->primaryKey => $id));
			$this->request->data = $this->PaquetesUsuario->find('first', $options);
		}
		$paquetes = $this->PaquetesUsuario->Paquete->find('list');
		$usuarios = $this->PaquetesUsuario->Usuario->find('list');
		$this->set(compact('paquetes', 'usuarios'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->PaquetesUsuario->id = $id;
		if (!$this->PaquetesUsuario->exists()) {
			throw new NotFoundException(__('La relación paquete - usuario no existe.'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->PaquetesUsuario->delete()) {
			$this->Session->setFlash(__('La relación paquete - usuario ha sido eliminada.'));
		} else {
			$this->Session->setFlash(__('La relación paquete - usuario no pudo ser eliminada. Por favor, inténtelo de nuevo.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
        
        
    public function infopaquete($paqueteId = null) {        
        
            $this->loadModel('Observacione');
            $this->loadModel('Ciudade');
            $this->loadModel('Oficina');
            $this->loadModel('Documentospaquete');
            $this->loadModel('Trazabilidade');
            $this->loadModel('Configuraciondato');
            $this->loadModel('Paquete');
            $this->loadModel('PaquetesUsuario');   
            $this->loadModel('Privilegio');
            $this->loadModel('PrivilegiosUsuario');
                    

            /*Se obtiene la informacion completa del paquete*/
            $arrInfoPaquete = $this->Paquete->obtenerInfoPaquete($paqueteId);

            /*Se obtiene la informacion de paquetes_usuarios en estado asignado TRUE*/
            $arrPaqUsr = $this->PaquetesUsuario->obtenerPaquetesUsuarioAsignado($paqueteId);

            /*Se obtiene el documento del paquete*/
            $documentosPaq = $this->Documentospaquete->obtenerDocsPaquetePorPaqteId($paqueteId);  
                 
            /*Se obtienen las observaciones realizadas sobre el paquete*/
            $observacion = $this->Observacione->obtenerObservacionesPorPaqueteId($paqueteId);                       
                 
            /*Se obtiene la informacion de la oficina*/
            $arrOficina = $this->Oficina->obtenerOficinaPorId($arrInfoPaquete['Paquete']['oficina_id']);

            /*Se obtiene la informacion de la ciudad y la regional*/
            $arrUbicacion = $this->Ciudade->obtenerInfoCiudad($arrOficina['Oficina']['ciudade_id']);            
           
            /*Se obtiene la url del proyecto para mostrar los documentos de cada paquete*/
            $urlDocs = $this->Configuraciondato->obtenerInfo($dato = 'url_raizproyserver') . "/repositorio/";
    
            //Se obtiene el id del privilegio que se desea obtener del usuario que realiza la gestión
            $permisoTrl = "Traslado";
            $privilegioTraslado = $this->Privilegio->obtenerIdPrivilegio($permisoTrl);

            $permisoCambUsr = "CambiarUsr";
            $privilegioCambiarUsr = $this->Privilegio->obtenerIdPrivilegio($permisoCambUsr);
            
            /*Se obtiene la informacion del usuario logueado*/
            $usrLogin = $this->Auth->user();

            //Se valida si el usuario que está realizando la gestión tiene permisos para trasladar archivos
            $permisoTraslado = $this->PrivilegiosUsuario->obtenerPrivilegiosPorUsuario($usrLogin['id'], $privilegioTraslado);            
            
            //Se valida si el usuario que está realizando la gestión tiene permisos para cambiar la asignacion de usuario - paquete
            $permisoCambioUsr = $this->PrivilegiosUsuario->obtenerPrivilegiosPorUsuario($usrLogin['id'], $privilegioCambiarUsr);             

            $this->set(compact('arrInfoPaquete','arrPaqUsr','documentosPaq', 'observacion', 'urlDocs', 'arrOficina', 'arrUbicacion','usrLogin', 'permisoTraslado', 'permisoCambioUsr'));       
    }   
    
    /**
     * Funcion que crea un formulario en un div para cambiar el usuario que tiene asignado un paquete
     */
    public function formcambiarusuariopaquete(){
        
            $this->loadModel('Oficina');
            $this->loadModel('Bandeja');
            $this->loadModel('Usuario');
            
            $paqueteId = $this->request->data['paquete_id'];            
            $usuarioId = $this->request->data['usuario_id']; 
            $paqueteusuarioId = $this->request->data['paquetesusuario_id'];
            
            $objPaquete = new PaquetesController();
            
            //Se obtienen las oficinas a las que pertenecen los paquetes a trasladar
            $arrOficinas = $this->Oficina->obtenerOficinasPaquetes($paqueteId);

            //Se obtienen las bandejas a las cuales pertenecen los paquetes a trasladar
            $arrBandejas = $this->Bandeja->obtenerBandejasPorPaquetes($paqueteId);
        
            //Se obtienen los usuarios con permisos sobre las oficinas y bandejas similares a los paquetes
            $arrUsuario = $this->Usuario->obtenerUsuarioGestionPaquete($arrOficinas, $arrBandejas, $usuarioId);
                
            //Agrupar la informacion de los permisos del usuario
            $arrAgrupUsr = $objPaquete->agruparPermisosUsuario($arrUsuario);

            $listaUsuarios = $objPaquete->validarPermisosUsuario($arrAgrupUsr,$arrOficinas,$arrBandejas);
          
            //Se reorganiza la lista para convertirla en el tipo $listaUsuarios['usuario_id'] = $listaUsuario['nombre']
            foreach ($listaUsuarios as $valUV){
                    $usuarios[$valUV['id']] = $valUV['nombre'];
            }

            $this->set(compact('paqueteId','usuarios', 'paqueteusuarioId'));
    }    
    
    /**
     * Funcion que cambia el usuario que tiene asignado un paquete, por un nuevo usuario
     */
    public function cambiarpaqueteusuario(){
        $this->layout="ajax";
        $this->autoRender=false;
        $this->loadModel('MotivostrasladosPaquete');
        
        $response=array();
        $response['estado']=false;

        if($this->request->is("post")){
            $usuario_id = $this->request->data("usuario_id"); 
            $paquete_id = $this->request->data("paquete_id");             
            $paquesteusuarioactual_id = $this->request->data("paquetesusuarioactual_id");
            $motivotraslado_id = $this->request->data("motivotraslado_id");                        
            
            if(!empty($usuario_id) && !empty($paquete_id) && !empty($paquesteusuarioactual_id)){
                
                //Se guarda el motivo de traslado del oficio
                $usuarioActual = $this->PaquetesUsuario->obtenerPaquetesUsuarioPorId($paquesteusuarioactual_id);
                $this->MotivostrasladosPaquete->crearTrasladoOficio($motivotraslado_id, $paquete_id, $usuarioActual['PaquetesUsuario']['usuario_id'], $usuario_id);
                
                /*Se asigna el paquete al usuario seleccionado por el administrador actualizando el registro actual*/
                $idNuevoUsuPaq = $this->PaquetesUsuario->reasignarPaqueteUsuario($paquesteusuarioactual_id, $usuario_id);
            }

            if(!empty($idNuevoUsuPaq) && $idNuevoUsuPaq != '0'){

                /*Se registra en trazabilidad el cambio de usuario*/
                $this->trazaCambioPaqUsr($paquete_id, $idNuevoUsuPaq);
                
                /*Se registra en auditoria el cambio de asignacion realizado por el administrador*/
                $this->auditoriaCambioPaUsr($paquete_id, $idNuevoUsuPaq);
                
                $response['estado']=true;

            }
        }
        echo json_encode($response);
        
    }    
    
    public function trazaCambioPaqUsr($paquete_id, $idNuevoUsuPaq){

        $this->loadModel('Trazabilidade');
        
        /*Se obtiene el registro en trazabidad activo para el usuario al cual se le retira el paquete*/
        $arrTraza = $this->Trazabilidade->consultarUltimaTrazaPaquete($paquete_id);

        $estadoId = $arrTraza['Trazabilidade']['estado_id'];
        $nuevoEstadoId = $arrTraza['Trazabilidade']['estadodestino_id'];
        $paqueteId = $paquete_id;
        $usuarioId = $this->Auth->user('id');      
        $paqUsrId = $idNuevoUsuPaq; 
        
        /*Se calculan los dias que el paquete estuvo asignado al anterior usuario*/
        $fechaActual = date("Y-m-d");
        $fechaAnterior = strtotime(h($arrTraza['Trazabilidade']['created']));                
        $diasEspera = floor(abs((strtotime($fechaActual)-$fechaAnterior)/86400));        

        /*Se crea el registro para el cambio de paquetes usuario*/
        $nuevaTraza = $this->Trazabilidade->guardarTrazabilidad($estadoId, $nuevoEstadoId, $paqueteId, $usuarioId, $paqUsrId);

        if($nuevaTraza){
            $this->Trazabilidade->actualizarUltimaTraza($arrTraza['Trazabilidade']['id'], $diasEspera);
        }
    }
    
    public function auditoriaCambioPaUsr($paqueteId, $idNuevoUsuPaq){
        
        $this->loadModel('Paquete');
        $this->loadModel('Auditoria');        
        
        /*Se obtiene la informacion del paquete*/
        $arrPaquete = $this->Paquete->obtenerInfoPaquete($paqueteId);

        /*Se obtiene la informacion del nuevo registro de UsuarioPaqute*/
        $usrPaq = $this->PaquetesUsuario->usuarioPaquetesUsuarioPorId($idNuevoUsuPaq);
       
        /*Se inserta el registro en auditoria sobre el cambio en la asignación usuario-paquete*/
        $id = 2;
        $accionAud = $this->Auditoria->accionAuditoria($id);   
        $arrDescripcionAud['numOficio'] = $arrPaquete['Paquete']['numerosolicitud'];
        $arrDescripcionAud['nombreUsuario'] = $usrPaq;
        
        $descripcionAud = $this->Auditoria->descripcionAuditoria($id, $arrDescripcionAud);
        $this->Auditoria->logAuditoria($this->Auth->user('id'), $descripcionAud, $accionAud);
    }
    
        public function search() {
		// the page we will redirect to
		$url=array();
            
                if($this->data['PaquetesUsuario']['accion_anterior']=='add'){
                    $url['action'] = 'add';
                }else if($this->data['PaquetesUsuario']['accion_anterior']=='index'){
                    $url['action'] = 'index';
                }      

		// build a URL will all the search elements in it
		// the resulting URL will be 
		// example.com/cake/posts/index/Search.keywords:mykeyword/Search.tag_id:3
		foreach ($this->data as $k=>$v){
                    if($k!='Paquetesusuario'){
			foreach ($v as $kk=>$vv){ 
				$url[$k.'.'.$kk]=$vv; 
			} 
                    }
		}

		// redirect the user to the url
		$this->redirect($url, null, true);
	}   	
        
        public function listasolicitudes($usuarioId = null){
            $this->loadModel('PrivilegiosUsuario'); 
            $this->loadModel('Privilegio');             
                        
            //Se obtiene el usuario que se encuentra logueado en la app
            $userAuth = $this->Auth->user('id');

            //Se obtiene el id del privilegio que se desea obtener del usuario que realiza la gestión
            $permisoDesc = "CambiarUsr";
            $permisoId = $this->Privilegio->obtenerIdPrivilegio($permisoDesc);
            
            //Se valida si el usuario que está realizando la gestión tiene permisos para trasladar archivos
            $permisoTraslado = $this->PrivilegiosUsuario->obtenerPrivilegiosPorUsuario($userAuth, $permisoId);

            //Se obtienen las solicitudes que el usuario tiene asignadas
            $arrSolicitudes = $this->PaquetesUsuario->obtenerPaquetesPorUsuarioId($usuarioId);

            for($i = 0; $i < count($arrSolicitudes); $i++){
                $arrSolicitudes[$i]['TZ']['dias'] = $this->calcularDiasPaqueteEnEspera($arrSolicitudes[$i]['TZ']['created']);
            }
  
            $this->set(compact('arrSolicitudes', 'permisoTraslado'));
        }
        
        public function calcularDiasPaqueteEnEspera($fecha){
            $this->loadModel('Diasfestivo');
            $fechaActual = date("Y-m-d h:i:s");
            $fechaAnterior = strtotime(h($fecha));
            $dias = floor(abs((strtotime($fechaActual)-$fechaAnterior)/86400));
            
            $diasFestivos = $this->Diasfestivo->obtenerDiasFestivos($fecha, $fechaActual);
            $diasTotal = $dias - $diasFestivos;            

            return $diasTotal;            
        }
        
        public function formtrasladosolicitudes(){
            $this->loadModel('Motivostraslado');
            $arrMotivosTraslado = $this->Motivostraslado->obtenerMotivosTraslado();
            
            $this->set(compact('arrMotivosTraslado'));
        }
}
