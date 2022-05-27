<?php
App::uses('AppController', 'Controller');
/**
 * Diasfestivos Controller
 *
 * @property Diasfestivo $Diasfestivo
 * @property PaginatorComponent $Paginator
 */
class DiasfestivosController extends AppController {

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
		$this->Diasfestivo->recursive = 0;
		$this->set('diasfestivos', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Diasfestivo->exists($id)) {
			throw new NotFoundException(__('El día festivo no existe'));
		}
		$options = array('conditions' => array('Diasfestivo.' . $this->Diasfestivo->primaryKey => $id));
		$this->set('diasfestivo', $this->Diasfestivo->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Diasfestivo->create();
			if ($this->Diasfestivo->save($this->request->data)) {
				$this->Session->setFlash(__('El día festivo ha sido guardado.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('El día festivo no pudo ser guardado. Por favor, inténtelo de nuevo.'));
			}
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
		if (!$this->Diasfestivo->exists($id)) {
			throw new NotFoundException(__('El día festivo no existe'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Diasfestivo->save($this->request->data)) {
				$this->Session->setFlash(__('El día festivo ha sido guardado.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('El día festivo no pudo ser guardado. Por favor, inténtelo de nuevo.'));
			}
		} else {
			$options = array('conditions' => array('Diasfestivo.' . $this->Diasfestivo->primaryKey => $id));
			$this->request->data = $this->Diasfestivo->find('first', $options);
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
		$this->Diasfestivo->id = $id;
		if (!$this->Diasfestivo->exists()) {
			throw new NotFoundException(__('El día festivo no existe'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Diasfestivo->delete()) {
			$this->Session->setFlash(__('El día festivo ha sido eliminado.'));
		} else {
			$this->Session->setFlash(__('El día festivo no pudo ser eliminado. Por favor, inténtelo de nuevo.'));
		}
		return $this->redirect(array('action' => 'index'));
	}}
