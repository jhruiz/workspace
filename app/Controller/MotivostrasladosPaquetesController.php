<?php
App::uses('AppController', 'Controller');
/**
 * MotivostrasladosPaquetes Controller
 *
 * @property MotivostrasladosPaquete $MotivostrasladosPaquete
 * @property PaginatorComponent $Paginator
 */
class MotivostrasladosPaquetesController extends AppController {

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
		$this->MotivostrasladosPaquete->recursive = 0;
		$this->set('motivostrasladosPaquetes', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->MotivostrasladosPaquete->exists($id)) {
			throw new NotFoundException(__('Invalid motivostraslados paquete'));
		}
		$options = array('conditions' => array('MotivostrasladosPaquete.' . $this->MotivostrasladosPaquete->primaryKey => $id));
		$this->set('motivostrasladosPaquete', $this->MotivostrasladosPaquete->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->MotivostrasladosPaquete->create();
			if ($this->MotivostrasladosPaquete->save($this->request->data)) {
				$this->Session->setFlash(__('The motivostraslados paquete has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The motivostraslados paquete could not be saved. Please, try again.'));
			}
		}
		$motivostraslados = $this->MotivostrasladosPaquete->Motivostraslado->find('list');
		$paquetes = $this->MotivostrasladosPaquete->Paquete->find('list');
		$usuarios = $this->MotivostrasladosPaquete->Usuario->find('list');
		$usuarionuevos = $this->MotivostrasladosPaquete->Usuarionuevo->find('list');
		$this->set(compact('motivostraslados', 'paquetes', 'usuarios', 'usuarionuevos'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->MotivostrasladosPaquete->exists($id)) {
			throw new NotFoundException(__('Invalid motivostraslados paquete'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->MotivostrasladosPaquete->save($this->request->data)) {
				$this->Session->setFlash(__('The motivostraslados paquete has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The motivostraslados paquete could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('MotivostrasladosPaquete.' . $this->MotivostrasladosPaquete->primaryKey => $id));
			$this->request->data = $this->MotivostrasladosPaquete->find('first', $options);
		}
		$motivostraslados = $this->MotivostrasladosPaquete->Motivostraslado->find('list');
		$paquetes = $this->MotivostrasladosPaquete->Paquete->find('list');
		$usuarios = $this->MotivostrasladosPaquete->Usuario->find('list');
		$usuarionuevos = $this->MotivostrasladosPaquete->Usuarionuevo->find('list');
		$this->set(compact('motivostraslados', 'paquetes', 'usuarios', 'usuarionuevos'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->MotivostrasladosPaquete->id = $id;
		if (!$this->MotivostrasladosPaquete->exists()) {
			throw new NotFoundException(__('Invalid motivostraslados paquete'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->MotivostrasladosPaquete->delete()) {
			$this->Session->setFlash(__('The motivostraslados paquete has been deleted.'));
		} else {
			$this->Session->setFlash(__('The motivostraslados paquete could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}}
