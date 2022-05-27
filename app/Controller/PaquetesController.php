<?php
App::uses('AppController', 'Controller');
/**
 * Paquetes Controller
 *
 * @property Paquete $Paquete
 * @property PaginatorComponent $Paginator
 */
class PaquetesController extends AppController {

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
		$this->Paquete->recursive = 0;
		$this->set('paquetes', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Paquete->exists($id)) {
			throw new NotFoundException(__('Invalid paquete'));
		}
		$options = array('conditions' => array('Paquete.' . $this->Paquete->primaryKey => $id));
		$this->set('paquete', $this->Paquete->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Paquete->create();
			if ($this->Paquete->save($this->request->data)) {
				$this->Session->setFlash(__('The paquete has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The paquete could not be saved. Please, try again.'));
			}
		}
		$estados = $this->Paquete->Estado->find('list');
		$oficinas = $this->Paquete->Oficina->find('list');
		$usuarios = $this->Paquete->Usuario->find('list');
		$documentos = $this->Paquete->Documento->find('list');
		$this->set(compact('estados', 'oficinas', 'usuarios', 'documentos'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Paquete->exists($id)) {
			throw new NotFoundException(__('Invalid paquete'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Paquete->save($this->request->data)) {
				$this->Session->setFlash(__('The paquete has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The paquete could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Paquete.' . $this->Paquete->primaryKey => $id));
			$this->request->data = $this->Paquete->find('first', $options);
		}
		$estados = $this->Paquete->Estado->find('list');
		$oficinas = $this->Paquete->Oficina->find('list');
		$usuarios = $this->Paquete->Usuario->find('list');
		$documentos = $this->Paquete->Documento->find('list');
		$this->set(compact('estados', 'oficinas', 'usuarios', 'documentos'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Paquete->id = $id;
		if (!$this->Paquete->exists()) {
			throw new NotFoundException(__('Invalid paquete'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Paquete->delete()) {
			$this->Session->setFlash(__('The paquete has been deleted.'));
		} else {
			$this->Session->setFlash(__('The paquete could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

        
        public function AjaxValidarOficioCargueArchivos(){
            $this->autoRender = false;
            $this->loadModel('Paquete');
            $numOficio = trim($this->request->data['numOficio']);
            $oficinaId = $this->request->data['oficinaId'];
                               
            $arrPaquete = $this->Paquete->obtenerPaqueteCargueArchivos($numOficio, $oficinaId);

            echo json_encode($arrPaquete);
            exit();            
        }
        
        public function formseleccionoficiocarguearchivos(){

            $this->layout='ajax';
            if($this->request->is("post")){    
                $arrSolicitud = $this->request->data['arrSolicitud'];
                $permisoCrearId = $this->request->data['permisoCrear'];                             

                $this->set(compact('arrSolicitud', 'permisoCrearId'));            
            }            
        }
        
        public function obtenerUsuarioGestion(){
            $this->loadModel('Oficina');
            $this->loadModel('Bandeja');
            $this->loadModel('Usuario');
            
            $this->autoRender = false;
            $postData = $this->request->data;
            $paqueteId = $postData['paqueteIds'];
            $usuarioId = $postData['usuarioId'];

            //Se obtienen las oficinas a las que pertenecen los paquetes a trasladar
            $arrOficinas = $this->Oficina->obtenerOficinasPaquetes($paqueteId);
            
            //Se obtienen las bandejas a las cuales pertenecen los paquetes a trasladar
            $arrBandejas = $this->Bandeja->obtenerBandejasPorPaquetes($paqueteId);
            
            //Se obtienen los usuarios con permisos sobre las oficinas y bandejas similares a los paquetes
            $arrUsuario = $this->Usuario->obtenerUsuarioGestionPaquete($arrOficinas, $arrBandejas, $usuarioId);

            //Agrupar la informacion de los permisos del usuario
            $arrAgrupUsr = $this->agruparPermisosUsuario($arrUsuario);
            
            $listaUsuarios = $this->validarPermisosUsuario($arrAgrupUsr,$arrOficinas,$arrBandejas);

            echo json_encode(array_values($listaUsuarios));
            
        }
        
        //Valida los permisos del usuario y crea un arreglo con los que cuentan con las credenciales completas
        public function validarPermisosUsuario($arrAgrupUsr,$arrOficinas,$arrBandejas){
            $listaUsr = array();
            
            foreach($arrAgrupUsr as $valU){
                $respO = true;
                $respB = true;

                foreach($arrOficinas as $valO){
                    if(!array_key_exists($valO, $valU['O'])){
                        $respO = false;
                    }else{
                        continue;
                    }
                }
                
                foreach($arrBandejas as $valB){
                    if(!array_key_exists($valB, $valU['B'])){
                        $respB = false;
                    }else{
                        continue;
                    }
                }
                
                if($respO){
                    $listaUsr[$valU['U']['id']]['id'] = $valU['U']['id'];
                    $listaUsr[$valU['U']['id']]['nombre'] = $valU['U']['nombre'];
                }else{
                    continue;
                }                
            }
            
            return $listaUsr;
        }
        
        
        //Agrupa la información del paciente por usuario, oficina y bandejas.
        public function agruparPermisosUsuario($arrUsuario){
            $arrAgrUsr = array();            

            foreach ($arrUsuario as $val){
                if(!empty($arrAgrUsr)){
                    if(array_key_exists($val['Usuario']['id'],$arrAgrUsr)){                        
                        if(!array_key_exists($val['OFIU']['oficina_id'], $arrAgrUsr[$val['Usuario']['id']]['O'])){
                            $arrAgrUsr[$val['Usuario']['id']]['O'][$val['OFIU']['oficina_id']] = $val['OFIU']['oficina_id'];
                        }
                        
                        if(!array_key_exists($val['PUB']['bandeja_id'], $arrAgrUsr[$val['Usuario']['id']]['B'])){
                            $arrAgrUsr[$val['Usuario']['id']]['O'][$val['PUB']['bandeja_id']] = $val['PUB']['bandeja_id'];
                        }                        
                    }else{
                        $arrAgrUsr[$val['Usuario']['id']]['U']['id'] = $val['Usuario']['id'];
                        $arrAgrUsr[$val['Usuario']['id']]['U']['nombre'] = $val['Usuario']['nombre'];
                        $arrAgrUsr[$val['Usuario']['id']]['O'][$val['OFIU']['oficina_id']] = $val['OFIU']['oficina_id'];
                        $arrAgrUsr[$val['Usuario']['id']]['B'][$val['PUB']['bandeja_id']] = $val['PUB']['bandeja_id'];                         
                    }
                }else{
                    $arrAgrUsr[$val['Usuario']['id']]['U']['id'] = $val['Usuario']['id'];
                    $arrAgrUsr[$val['Usuario']['id']]['U']['nombre'] = $val['Usuario']['nombre'];
                    $arrAgrUsr[$val['Usuario']['id']]['O'][$val['OFIU']['oficina_id']] = $val['OFIU']['oficina_id'];
                    $arrAgrUsr[$val['Usuario']['id']]['B'][$val['PUB']['bandeja_id']] = $val['PUB']['bandeja_id'];                    
                }                
                
            }
            
            return $arrAgrUsr;
        }
        
        public function cambiarNumeroCredencial(){
            $this->loadModel('Auditoria');
            
            $this->autoRender = false;
            $numCredencial = trim($this->request->data['numeroCredencial']);
            $paqueteId = $this->request->data['paqueteId'];
            $numCredencialAct = $this->request->data['numCredencialAct'];
            
            $datos['valido'] = $this->Paquete->actualizarCredencial($paqueteId, $numCredencial);
            
            if($datos['valido']){
                /*Se registra el cambio del número de credencial*/
                $accionAud = $this->Auditoria->accionAuditoria($mensajeId = '3');
                $arrDescripcionAud['numOficio'] = $numCredencialAct;
                $arrDescripcionAud['numOficioNuevo'] = $numCredencial;
                $descripcionAud = $this->Auditoria->descripcionAuditoria($id = '3', $arrDescripcionAud);
                $this->Auditoria->logAuditoria($this->Auth->user('id'), $descripcionAud, $accionAud); 
            }            
            echo json_encode($datos);
        }
        
        public function AjaxObtenerInfoPaqute(){
            $this->loadModel('Ciudade');
            $this->autoRender = false;
            $infoPaquete = array();
            $paqueteId = trim($this->request->data['paqueteId']);
                               
            $arrPaquete = $this->Paquete->obtenerInfoPaquete($paqueteId);  
            $arrCiudad = $this->Ciudade->obtenerInfoCiudad($arrPaquete['Oficina']['ciudade_id']);
            
            $infoPaquete['credencial'] = $arrPaquete['Paquete']['numerocredencial'];
            $infoPaquete['oficinaId'] = $arrPaquete['Paquete']['oficina_id'];
            $infoPaquete['oficinaDesc'] = $arrPaquete['Oficina']['descripcion'];
            $infoPaquete['ciudadDesc'] = $arrCiudad['Ciudade']['descripcion'];
            $infoPaquete['regionalDesc'] = $arrCiudad['Regionale']['descripcion'];
            
            echo json_encode($infoPaquete);
            exit();            
        }        
}        