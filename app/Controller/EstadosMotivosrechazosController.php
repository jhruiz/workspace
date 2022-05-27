<?php
App::uses('AppController', 'Controller');
/**
 * EstadosMotivosrechazos Controller
 *
 * @property EstadosMotivosrechazo $EstadosMotivosrechazo
 * @property PaginatorComponent $Paginator
 */
class EstadosMotivosrechazosController extends AppController {

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
		$this->EstadosMotivosrechazo->recursive = 0;
		$this->set('estadosMotivosrechazos', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->EstadosMotivosrechazo->exists($id)) {
			throw new NotFoundException(__('No existe la relación Estado - Motivo de Rechazo'));
		}
		$options = array('conditions' => array('EstadosMotivosrechazo.' . $this->EstadosMotivosrechazo->primaryKey => $id));
		$this->set('estadosMotivosrechazo', $this->EstadosMotivosrechazo->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->EstadosMotivosrechazo->create();
			if ($this->EstadosMotivosrechazo->save($this->request->data)) {
				$this->Session->setFlash(__('La relación Estado - Motivo de Rechazo ha sido guardada.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('La relación Estado - Motivo de Rechazo no pudo ser guardada. Por favor, inténtelo de nuevo.'));
			}
		}
		$estados = $this->EstadosMotivosrechazo->Estado->find('list');
		$motivosrechazos = $this->EstadosMotivosrechazo->Motivosrechazo->find('list');
		$this->set(compact('estados', 'motivosrechazos'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->EstadosMotivosrechazo->exists($id)) {
			throw new NotFoundException(__('No existe la relación Estado - Motivo de Rechazo'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->EstadosMotivosrechazo->save($this->request->data)) {
				$this->Session->setFlash(__('La relación Estado - Motivo de Rechazo ha sido guardada.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('La relación Estado - Motivo de Rechazo no pudo ser guardada. Por favor, inténtelo de nuevo.'));
			}
		} else {
			$options = array('conditions' => array('EstadosMotivosrechazo.' . $this->EstadosMotivosrechazo->primaryKey => $id));
			$this->request->data = $this->EstadosMotivosrechazo->find('first', $options);
		}
		$estados = $this->EstadosMotivosrechazo->Estado->find('list');
		$motivosrechazos = $this->EstadosMotivosrechazo->Motivosrechazo->find('list');
		$this->set(compact('estados', 'motivosrechazos'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->EstadosMotivosrechazo->id = $id;
		if (!$this->EstadosMotivosrechazo->exists()) {
			throw new NotFoundException(__('No existe la relación Estados - Motivos de Rechazo'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->EstadosMotivosrechazo->delete()) {
			$this->Session->setFlash(__('La relación Estados - Motivos de Rechazo ha sido eliminada.'));
		} else {
			$this->Session->setFlash(__('La relación Estados - Motivos de Rechazo no pudo ser eliminada. Por favor, inténtelo de nuevo.'));
		}
		return $this->redirect(array('action' => 'index'));
	}}
