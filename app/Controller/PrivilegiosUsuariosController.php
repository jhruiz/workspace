<?php
App::uses('AppController', 'Controller');
/**
 * PrivilegiosUsuarios Controller
 *
 * @property PrivilegiosUsuario $PrivilegiosUsuario
 * @property PaginatorComponent $Paginator
 */
class PrivilegiosUsuariosController extends AppController {

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
		$this->PrivilegiosUsuario->recursive = 0;
		$this->set('privilegiosUsuarios', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->PrivilegiosUsuario->exists($id)) {
			throw new NotFoundException(__('No existe el Privilegio - Usuario'));
		}
		$options = array('conditions' => array('PrivilegiosUsuario.' . $this->PrivilegiosUsuario->primaryKey => $id));
		$this->set('privilegiosUsuario', $this->PrivilegiosUsuario->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->PrivilegiosUsuario->create();
			if ($this->PrivilegiosUsuario->save($this->request->data)) {
				$this->Session->setFlash(__('El Privilegio para el Usuario ha sido guardado.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('El Privilegio para el Usuario no ha sido guardado. Por favor, inténtelo de nuevo.'));
			}
		}
		$privilegios = $this->PrivilegiosUsuario->Privilegio->find('list');
		$usuarios = $this->PrivilegiosUsuario->Usuario->find('list');
		$this->set(compact('privilegios', 'usuarios'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->PrivilegiosUsuario->exists($id)) {
			throw new NotFoundException(__('No existe el Privilegio - Usuario'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->PrivilegiosUsuario->save($this->request->data)) {
				$this->Session->setFlash(__('El Privilegio para el Usuario ha sido guardado.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('El Privilegio para el Usuario no ha sido guardado. Por favor, inténtelo de nuevo.'));
			}
		} else {
			$options = array('conditions' => array('PrivilegiosUsuario.' . $this->PrivilegiosUsuario->primaryKey => $id));
			$this->request->data = $this->PrivilegiosUsuario->find('first', $options);
		}
		$privilegios = $this->PrivilegiosUsuario->Privilegio->find('list');
		$usuarios = $this->PrivilegiosUsuario->Usuario->find('list');
		$this->set(compact('privilegios', 'usuarios'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->PrivilegiosUsuario->id = $id;
		if (!$this->PrivilegiosUsuario->exists()) {
			throw new NotFoundException(__('No existe el Privilegio - Usuario.'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->PrivilegiosUsuario->delete()) {
			$this->Session->setFlash(__('El Privilegio para el Usuario ha sido Eliminado.'));
		} else {
			$this->Session->setFlash(__('El Privilegio para el Usuario no ha sido eliminado. Por favor, inténtelo de nuevo.'));
		}
		return $this->redirect(array('action' => 'index'));
	}}
