<?php
App::uses('AppController', 'Controller');
App::import('Model', 'Auditoria');

class UbicacionesfisicasController extends AppController {

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

		$paginate['Ubicacionesfisica.ubicacionesfisica_id ='] = null;
		$this->Ubicacionesfisica->recursive = 0;

		$this->set('ubicaciones', $this->Paginator->paginate('Ubicacionesfisica',$paginate));
	}

	/**
	 * Funcion para agregar directorios
	 *
	 * @return void
	 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Ubicacionesfisica->create();
			if ($this->Ubicacionesfisica->save($this->request->data)) {
				$this->Session->setFlash(__('La ubicación física ha sido guardada.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('La ubicación física no pudo ser guardada. Por favor, inténtelo de nuevo.'));
			}
		}
	}

	/**
	 * Función para agregar subdirectorios
	 */
	public function addsubdir($nombre, $id) {
		if ($this->request->is('post')) {
			$this->Ubicacionesfisica->create();
			if ($this->Ubicacionesfisica->save($this->request->data)) {
				$this->Session->setFlash(__('La ubicación física ha sido guardada.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('La ubicación física no pudo ser guardada. Por favor, inténtelo de nuevo.'));
			}
		}
		$this->set(compact('nombre', 'id'));
		
	}

	/**
	 * Obtiene las ubicaciones pertenecientes a un padre específico
	 */
	public function obtenersubmenus() {
		$this->autoRender=false;
		$idPadre = $this->request->data['id_menu']; 
		$uHijas = $this->Ubicacionesfisica->obtenerUbicacionesFisicarHijas($idPadre); 
		
		echo json_encode($uHijas);

	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {

		if (!$this->Ubicacionesfisica->exists($id)) {
			throw new NotFoundException(__('La ubicación física seleccionada no existe.'));
		}

		if ($this->request->is(array('post', 'put'))) {
			if ($this->Ubicacionesfisica->save($this->request->data)) {
				$this->Session->setFlash(__('La ubicación física ha sido guardada.'));
				return $this->redirect(array('action' => 'index'));
			}else {
				$this->Session->setFlash(__('La ubicación física no pudo ser guardada. Por favor, Inténtelo de nuevo.'));
			}
		} else {
			$options = array('conditions' => array('Ubicacionesfisica.' . $this->Ubicacionesfisica->primaryKey => $id));
			$this->request->data = $this->Ubicacionesfisica->find('first', $options);
		}
	}      
}         

