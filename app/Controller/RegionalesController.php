<?php
App::uses('AppController', 'Controller');
App::import('Model', 'Auditoria');
/**
 * Regionales Controller
 *
 * @property Regionale $Regionale
 * @property PaginatorComponent $Paginator
 */
class RegionalesController extends AppController {

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

          $title = array();
          $paginate=array();
          if(isset($this->passedArgs['Search.Nombre']) && !empty($this->passedArgs['Search.Nombre'])) {
                  $paginate['Regionale.descripcion LIKE '] = '%'.$this->passedArgs['Search.Nombre']."%";
          }         
                                         
            $this->Regionale->recursive = 0;
            
            if(empty($paginate)){
                $this->set('regionales', $this->Paginator->paginate());                           
            }else{
                $this->set('regionales', $this->Paginator->paginate('Regionale',$paginate));                           
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

		if (!$this->Regionale->exists($id)) {
			throw new NotFoundException(__('La Regional no existe.'));
		}
		$options = array('conditions' => array('Regionale.' . $this->Regionale->primaryKey => $id));
		$this->set('regionale', $this->Regionale->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
            if ($this->request->is('post')) {
                    $this->Regionale->create();
                    if ($this->Regionale->save($this->request->data)) {
                            $this->Session->setFlash(__('La regional ha sido guardada.'));
                            return $this->redirect(array('action' => 'index'));
                    } else {
                            $this->Session->setFlash(__('La regional no fue guardada. Por favor, inténtelo de nuevo.'));
                    }
            }
            $estadoregistros = $this->Regionale->Estadoregistro->find('list');
            $this->set(compact('estadoregistros'));
                                                                                               
            $title = array();
            $paginate=array();
            if(isset($this->passedArgs['Search.Nombre']) && !empty($this->passedArgs['Search.Nombre'])) {
                    $paginate['Regionale.nombre LIKE '] = "%".$this->passedArgs['Search.Nombre']."%";
            }

            if(isset($this->passedArgs['Search.Codigo']) && !empty($this->passedArgs['Search.Codigo'])) {
                    $paginate['Regionale.codigo LIKE '] = "%".$this->passedArgs['Search.Codigo']."%";

            }
                                         
            $this->Regionale->recursive = 0;
            
            if(empty($paginate)){
                $this->set('regionales', $this->Paginator->paginate());                           
            }else{
                $this->set('regionales', $this->Paginator->paginate('Regionale',$paginate));                           
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
            
		if (!$this->Regionale->exists($id)) {
			throw new NotFoundException(__('La Regional no existe.'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Regionale->save($this->request->data)) {
                                $this->Session->setFlash(__('La regional ha sido guardada.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('La regional no ha sido guardada. Por favor, inténtelo de nuevo'));
			}
		} else {
			$options = array('conditions' => array('Regionale.' . $this->Regionale->primaryKey => $id));
			$this->request->data = $this->Regionale->find('first', $options);
		}
		$estadoregistros = $this->Regionale->Estadoregistro->find('list');
		$this->set(compact('estadoregistros'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Regionale->id = $id;
		if (!$this->Regionale->exists()) {
			throw new NotFoundException(__('La regional no existe'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Regionale->delete()) {
			$this->Session->setFlash(__('La regional ha sido eliminada.'));
		} else {
			$this->Session->setFlash(__('La regional no pudo ser eliminada. Por favor, inténtelo de nuevo.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
        
          public function search() {
		// the page we will redirect to
		$url=array();
            
                if($this->data['Regionale']['accion_anterior']=='add'){
                    $url['action'] = 'add';
                }else if($this->data['Regionale']['accion_anterior']=='index'){
                    $url['action'] = 'index';
                }                
		foreach ($this->data as $k=>$v){
                    if($k!='Regionale'){
			foreach ($v as $kk=>$vv){ 
				$url[$k.'.'.$kk]=$vv; 
			} 
                    }
		}
		// redirect the user to the url
		$this->redirect($url, null, true);
	} 
        
        public function inactivar($id = null) {
             
                $this->Regionale->id = $id;
                
                if (!$this->Regionale->exists()) {
                    throw new NotFoundException(__('La regional no existe.'));
                }    
                
                $this->request->onlyAllow('post', 'delete');
                $id = $this->request->params['pass'][0];
                $datos = $this->Regionale->obtenerRegionalPorId($id);
                $estadReg = $datos['Regionale']['estadoregistro_id'];
                $mensaje="";
                
                if($estadReg == 1){
                    $newEst = 2;
                    $mensaje="Inactiva";
                }else{
                    $newEst = 1;
                    $mensaje="Activa";
                }
                
                if($this->Regionale->updateAll(
                        array('estadoregistro_id' => $newEst),
                        array('id' => $id)                       
                )){
                
                     //Se activan/inactivan las ciudades de la regional que se ha activado/inactivado
                    $ciudades = $this->Regionale->Ciudade->find("list", array("conditions" => array("regionale_id" => $id), 'fields' => 'id', 'recursive' => -1 ));
                    $this->Regionale->Ciudade->updateAll(array('estadoregistro_id' => $newEst),array('id' => $ciudades));
                    $this->Session->setFlash(__('Se ha cambiado el estado de la Regional a '.$mensaje));
                    return $this->redirect(array('action' => 'index'));               
                }else{
                    $this->Session->setFlash(__('Se produjo un error, intentelo de nuevo'));
                }
        } 
        
}