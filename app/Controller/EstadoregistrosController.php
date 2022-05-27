<?php
App::uses('AppController', 'Controller');
/**
 * Estadoregistros Controller
 *
 * @property Estadoregistro $Estadoregistro
 * @property PaginatorComponent $Paginator
 */
class EstadoregistrosController extends AppController {

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
                if(isset($this->passedArgs['Search.Nombre'])) {
			$paginate['Estadoregistro.descripcion LIKE'] = '%'.$this->passedArgs['Search.Nombre']."%";                     
		}
		$this->Estadoregistro->recursive = 0;
                if(empty($paginate)){
                $this->set('estadoregistros', $this->Paginator->paginate());                           
            }else{
                $this->set('estadoregistros', $this->Paginator->paginate('Estadoregistro',$paginate));                           
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

		if (!$this->Estadoregistro->exists($id)) {
			throw new NotFoundException(__('Estado de registro invalido.'));
		}
		$options = array('conditions' => array('Estadoregistro.' . $this->Estadoregistro->primaryKey => $id));
		$this->set('estadoregistro', $this->Estadoregistro->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {

		if ($this->request->is('post')) {
			$this->Estadoregistro->create();
			if ($this->Estadoregistro->save($this->request->data)) {
				$this->Session->setFlash(__('El estado de registro fue guardado.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('El estado de registro no pudo ser guardado. Intentelo de nuevo.'));
			}
		}
                
                $title = array();
                $paginate=array();
                if(isset($this->passedArgs['Search.Nombre'])) {
			$paginate['Estadoregistro.nombre LIKE'] = '%'.$this->passedArgs['Search.Nombre']."%";                     
		}
		$this->Estadoregistro->recursive = 0;
                if(empty($paginate)){
                $this->set('estadoregistros', $this->Paginator->paginate());                           
                }else{
                    $this->set('estadoregistros', $this->Paginator->paginate('Estadoregistro',$paginate));                           
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
            
		if (!$this->Estadoregistro->exists($id)) {
			throw new NotFoundException(__('Estado de registro invalido'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Estadoregistro->save($this->request->data)) {
				$this->Session->setFlash(__('El estado de registro fue guardado.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('El estado de registro no pudo ser guardado. Intentelo de nuevo.'));
			}
		} else {
			$options = array('conditions' => array('Estadoregistro.' . $this->Estadoregistro->primaryKey => $id));
			$this->request->data = $this->Estadoregistro->find('first', $options);
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
            
		$this->Estadoregistro->id = $id;
		if (!$this->Estadoregistro->exists()) {
			throw new NotFoundException(__('Estado de registro invalido.'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Estadoregistro->delete()) {
			$this->Session->setFlash(__('El estado de registro fue guardado.'));
		} else {
			$this->Session->setFlash(__('El estado de registro fue guardado. Intentelo de nuevo.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
        
        public function search() {
		$url=array();
            
                if($this->data['Estadoregistro']['accion_anterior']=='add'){
                    $url['action'] = 'add';
                }else if($this->data['Estadoregistro']['accion_anterior']=='index'){
                    $url['action'] = 'index';
                }                
		foreach ($this->data as $k=>$v){
                    if($k!='Estadoregistro'){
			foreach ($v as $kk=>$vv){ 
				$url[$k.'.'.$kk]=$vv; 
			} 
                    }
		}
		$this->redirect($url, null, true);
	}        
}
