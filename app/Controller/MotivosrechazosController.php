<?php
App::uses('AppController', 'Controller');
/**
 * Motivosrechazos Controller
 *
 * @property Motivosrechazo $Motivosrechazo
 * @property PaginatorComponent $Paginator
 */
class MotivosrechazosController extends AppController {

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
		$this->Motivosrechazo->recursive = 0;
		$this->set('motivosrechazos', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Motivosrechazo->exists($id)) {
			throw new NotFoundException(__('El motivo de rechazo no existe'));
		}
		$options = array('conditions' => array('Motivosrechazo.' . $this->Motivosrechazo->primaryKey => $id));
		$this->set('motivosrechazo', $this->Motivosrechazo->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Motivosrechazo->create();
			if ($this->Motivosrechazo->save($this->request->data)) {
				$this->Session->setFlash(__('El motivo de rechazo ha sido guardado.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('El motivo de rechazo no pudo ser guardado. Por favor, inténtelo de nuevo.'));
			}
		}
		$paquetes = $this->Motivosrechazo->Paquete->find('list');
		$estados = $this->Motivosrechazo->Estado->find('list');
		$this->set(compact('paquetes', 'estados'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Motivosrechazo->exists($id)) {
			throw new NotFoundException(__('El motivo de rechazo no existe'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Motivosrechazo->save($this->request->data)) {
				$this->Session->setFlash(__('El motivo de rechazo ha sido guardado.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('El motivo de rechazo no pudo ser guardado. Por favor, inténtelo de nuevo.'));
			}
		} else {
			$options = array('conditions' => array('Motivosrechazo.' . $this->Motivosrechazo->primaryKey => $id));
			$this->request->data = $this->Motivosrechazo->find('first', $options);
		}
		$paquetes = $this->Motivosrechazo->Paquete->find('list');
		$estados = $this->Motivosrechazo->Estado->find('list');
		$this->set(compact('paquetes', 'estados'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Motivosrechazo->id = $id;
		if (!$this->Motivosrechazo->exists()) {
			throw new NotFoundException(__('El motivo de rechazo no existe'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Motivosrechazo->delete()) {
			$this->Session->setFlash(__('El motivo de rechazo ha sido eliminado.'));
		} else {
			$this->Session->setFlash(__('El motivo de rechazo no pudo ser eliminado. Por favor, inténtelo de nuevo.'));
		}
		return $this->redirect(array('action' => 'index'));
	}}
