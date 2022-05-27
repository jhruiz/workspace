<?php
App::uses('AppController', 'Controller');
/**
 * Relacionbandejasestados Controller
 *
 * @property Relacionbandejasestado $Relacionbandejasestado
 * @property PaginatorComponent $Paginator
 */
class RelacionbandejasestadosController extends AppController {

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
		$this->Relacionbandejasestado->recursive = 0;
		$this->set('relacionbandejasestados', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Relacionbandejasestado->exists($id)) {
			throw new NotFoundException(__('No existe la relación Bandeja - Estado'));
		}
		$options = array('conditions' => array('Relacionbandejasestado.' . $this->Relacionbandejasestado->primaryKey => $id));
		$this->set('relacionbandejasestado', $this->Relacionbandejasestado->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Relacionbandejasestado->create();
			if ($this->Relacionbandejasestado->save($this->request->data)) {
				$this->Session->setFlash(__('La relación Bandeja - Estado ha sido guardada.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('La relación Bandeja - Estado no pudo ser guardada. Por favor, inténtelo de nuevo.'));
			}
		}
		$bandejas = $this->Relacionbandejasestado->Bandeja->find('list');
		$estados = $this->Relacionbandejasestado->Estado->find('list');
		$this->set(compact('bandejas', 'estados'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Relacionbandejasestado->exists($id)) {
			throw new NotFoundException(__('La relación Bandeja - Estado no existe.'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Relacionbandejasestado->save($this->request->data)) {
				$this->Session->setFlash(__('La relación Bandeja - Estado ha sido guardada.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('La relación Bandeja - Estado no pudo ser guardada. Por favor, inténtelo de nuevo.'));
			}
		} else {
			$options = array('conditions' => array('Relacionbandejasestado.' . $this->Relacionbandejasestado->primaryKey => $id));
			$this->request->data = $this->Relacionbandejasestado->find('first', $options);
		}
		$bandejas = $this->Relacionbandejasestado->Bandeja->find('list');
		$estados = $this->Relacionbandejasestado->Estado->find('list');
		$this->set(compact('bandejas', 'estados'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Relacionbandejasestado->id = $id;
		if (!$this->Relacionbandejasestado->exists()) {
			throw new NotFoundException(__('La relación Bandeja - Estado no existe.'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Relacionbandejasestado->delete()) {
			$this->Session->setFlash(__('La relación Bandeja - Estado ha sido eliminada.'));
		} else {
			$this->Session->setFlash(__('La relación Bandeja - Estado no pudo ser eliminada. Por favor, inténtelo de nuevo.'));
		}
		return $this->redirect(array('action' => 'index'));
	}}
