<?php
App::uses('AppController', 'Controller');
/**
 * Series Controller
 *
 * @property Series $Series
 * @property PaginatorComponent $Paginator
 */
class SeriesController extends AppController {

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
            
		$this->Series->recursive = 0;
		$this->set('series', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {

		if (!$this->Series->exists($id)) {
			throw new NotFoundException(__('La serie no existe'));
		}
		$options = array('conditions' => array('Series.' . $this->Series->primaryKey => $id));
		$this->set('series', $this->Series->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
            
		if ($this->request->is('post')) {
			$this->Series->create();
			if ($this->Series->save($this->request->data("Series"))) {
				$this->Session->setFlash(__('La serie ha sido guardada.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('La serie no pudo ser guardada. Por favor, inténtelo de nuevo.'));
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
            
		if (!$this->Series->exists($id)) {
			throw new NotFoundException(__('La serie no existe'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Series->save($this->request->data)) {
				$this->Session->setFlash(__('La serie ha sido guardada.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('La serie no pudo ser guardada. Por favor, inténtelo de nuevo.'));
			}
		} else {
			$options = array('conditions' => array('Series.' . $this->Series->primaryKey => $id));
			$this->request->data = $this->Series->find('first', $options);
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
		$this->Series->id = $id;
		if (!$this->Series->exists()) {
			throw new NotFoundException(__('La serie no existe'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Series->delete()) {
			$this->Session->setFlash(__('La serie ha sido eliminada.'));
		} else {
			$this->Session->setFlash(__('La serie no pudo ser eliminada. Por favor, inténtelo de nuevo.'));
		}
		return $this->redirect(array('action' => 'index'));
	}}
