<?php
App::uses('AppController', 'Controller');
/**
 * Oficinas Controller
 *
 * @property Oficina $Oficina
 * @property PaginatorComponent $Paginator
 */
class OficinasController extends AppController {

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
			$paginate['Oficina.descripcion LIKE'] = '%'.$this->passedArgs['Search.Nombre']."%";                     
		}

                if(isset($this->passedArgs['Search.ciudade_id']) && !empty($this->passedArgs['Search.ciudade_id'])) {
			$paginate['Oficina.ciudade_id ='] = $this->passedArgs['Search.ciudade_id'];
		}                
                                
		$this->Oficina->recursive = 0;
                if(empty($paginate)){
                $this->set('oficinas', $this->Paginator->paginate());                           
            }else{
                $this->set('oficinas', $this->Paginator->paginate('Oficina',$paginate));                           
            }
            
            $listCiudades = $this->Oficina->Ciudade->find('list');
            $this->set(compact('listCiudades'));  
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Oficina->exists($id)) {
			throw new NotFoundException(__('Oficina Invalida'));
		}
		$options = array('conditions' => array('Oficina.' . $this->Oficina->primaryKey => $id));
		$this->set('oficina', $this->Oficina->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
            
		if ($this->request->is('post')) {
			$this->Oficina->create();
			if ($this->Oficina->save($this->request->data)) {
				$this->Session->setFlash(__('La oficina fue guardada.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('La oficina no pudo ser guardada. Intentelo de nuevo.'));
			}
		}
		$ciudades = $this->Oficina->Ciudade->find('list');
                $estadoregistros = $this->Oficina->Estadoregistro->find('list');
                
		$this->set(compact('ciudades', 'usuarios', 'estadoregistros'));                	
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {

		if (!$this->Oficina->exists($id)) {
			throw new NotFoundException(__('Oficina Invalida'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Oficina->save($this->request->data)) {
				$this->Session->setFlash(__('La oficina fue guardada.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('La oficina no pudo ser guardada. Intentelo de nuevo.'));
			}
		} else {
			$options = array('conditions' => array('Oficina.' . $this->Oficina->primaryKey => $id));
			$this->request->data = $this->Oficina->find('first', $options);
		}
		$ciudades = $this->Oficina->Ciudade->find('list');
		$this->set(compact('ciudades', 'usuarios'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Oficina->id = $id;
		if (!$this->Oficina->exists()) {
			throw new NotFoundException(__('Oficina Invalida'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Oficina->delete()) {
			$this->Session->setFlash(__('la oficina fue eliminada.'));
		} else {
			$this->Session->setFlash(__('La oficina no pudo ser eliminada. Intentelo de nuevo.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
        
        
        public function search() {
		$url=array();
            
                if($this->data['Oficina']['accion_anterior']=='add'){
                    $url['action'] = 'add';
                }else if($this->data['Oficina']['accion_anterior']=='index'){
                    $url['action'] = 'index';
                }                
		foreach ($this->data as $k=>$v){
                    if($k!='Oficina'){
			foreach ($v as $kk=>$vv){ 
				$url[$k.'.'.$kk]=$vv; 
			} 
                    }
		}
		$this->redirect($url, null, true);
	}
 }
