<?php
App::uses('AppController', 'Controller');
/**
 * Eliminarmultis Controller
 *
 * @property Eliminarmulti $Eliminarmulti
 * @property PaginatorComponent $Paginator
 */
class EliminarmultisController extends AppController {

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
		$this->Eliminarmulti->recursive = 0;
		$this->set('eliminarmultis', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Eliminarmulti->exists($id)) {
			throw new NotFoundException(__('Invalid eliminarmulti'));
		}
		$options = array('conditions' => array('Eliminarmulti.' . $this->Eliminarmulti->primaryKey => $id));
		$this->set('eliminarmulti', $this->Eliminarmulti->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Eliminarmulti->create();
			if ($this->Eliminarmulti->save($this->request->data)) {
				$this->Session->setFlash(__('The eliminarmulti has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The eliminarmulti could not be saved. Please, try again.'));
			}
		}
		$paquetes = $this->Eliminarmulti->Paquete->find('list');
		$this->set(compact('paquetes'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Eliminarmulti->exists($id)) {
			throw new NotFoundException(__('Invalid eliminarmulti'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Eliminarmulti->save($this->request->data)) {
				$this->Session->setFlash(__('The eliminarmulti has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The eliminarmulti could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Eliminarmulti.' . $this->Eliminarmulti->primaryKey => $id));
			$this->request->data = $this->Eliminarmulti->find('first', $options);
		}
		$paquetes = $this->Eliminarmulti->Paquete->find('list');
		$this->set(compact('paquetes'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Eliminarmulti->id = $id;
		if (!$this->Eliminarmulti->exists()) {
			throw new NotFoundException(__('Invalid eliminarmulti'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Eliminarmulti->delete()) {
			$this->Session->setFlash(__('The eliminarmulti has been deleted.'));
		} else {
			$this->Session->setFlash(__('The eliminarmulti could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}}
