<?php
App::uses('AppController', 'Controller');
/**
 * Motivostraslados Controller
 *
 * @property Motivostraslado $Motivostraslado
 * @property PaginatorComponent $Paginator
 */
class MotivostrasladosController extends AppController {

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
		$this->Motivostraslado->recursive = 0;
		$this->set('motivostraslados', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Motivostraslado->exists($id)) {
			throw new NotFoundException(__('Invalid motivostraslado'));
		}
		$options = array('conditions' => array('Motivostraslado.' . $this->Motivostraslado->primaryKey => $id));
		$this->set('motivostraslado', $this->Motivostraslado->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Motivostraslado->create();
			if ($this->Motivostraslado->save($this->request->data)) {
				$this->Session->setFlash(__('The motivostraslado has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The motivostraslado could not be saved. Please, try again.'));
			}
		}
		$paquetes = $this->Motivostraslado->Paquete->find('list');
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
		if (!$this->Motivostraslado->exists($id)) {
			throw new NotFoundException(__('Invalid motivostraslado'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Motivostraslado->save($this->request->data)) {
				$this->Session->setFlash(__('The motivostraslado has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The motivostraslado could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Motivostraslado.' . $this->Motivostraslado->primaryKey => $id));
			$this->request->data = $this->Motivostraslado->find('first', $options);
		}
		$paquetes = $this->Motivostraslado->Paquete->find('list');
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
		$this->Motivostraslado->id = $id;
		if (!$this->Motivostraslado->exists()) {
			throw new NotFoundException(__('Invalid motivostraslado'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Motivostraslado->delete()) {
			$this->Session->setFlash(__('The motivostraslado has been deleted.'));
		} else {
			$this->Session->setFlash(__('The motivostraslado could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}}
