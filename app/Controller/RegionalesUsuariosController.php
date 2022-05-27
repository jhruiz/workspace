<?php
App::uses('AppController', 'Controller');
/**
 * RegionalesUsuarios Controller
 *
 * @property RegionalesUsuario $RegionalesUsuario
 * @property PaginatorComponent $Paginator
 */
class RegionalesUsuariosController extends AppController {

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
	public function index($usuarioId = null) {
            $paginate['usuario_id'] = $usuarioId; 
            $this->RegionalesUsuario->recursive = 0;
            $this->set('regionalesUsuarios', $this->Paginator->paginate($paginate));
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->RegionalesUsuario->exists($id)) {
			throw new NotFoundException(__('Invalid regionales usuario'));
		}
		$options = array('conditions' => array('RegionalesUsuario.' . $this->RegionalesUsuario->primaryKey => $id));
		$this->set('regionalesUsuario', $this->RegionalesUsuario->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->RegionalesUsuario->create();
			if ($this->RegionalesUsuario->save($this->request->data)) {
				$this->Session->setFlash(__('The regionales usuario has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The regionales usuario could not be saved. Please, try again.'));
			}
		}
		$regionales = $this->RegionalesUsuario->Regionale->find('list');
		$usuarios = $this->RegionalesUsuario->Usuario->find('list');
		$this->set(compact('regionales', 'usuarios'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->RegionalesUsuario->exists($id)) {
			throw new NotFoundException(__('Invalid regionales usuario'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->RegionalesUsuario->save($this->request->data)) {
				$this->Session->setFlash(__('The regionales usuario has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The regionales usuario could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('RegionalesUsuario.' . $this->RegionalesUsuario->primaryKey => $id));
			$this->request->data = $this->RegionalesUsuario->find('first', $options);
		}
		$regionales = $this->RegionalesUsuario->Regionale->find('list');
		$usuarios = $this->RegionalesUsuario->Usuario->find('list');
		$this->set(compact('regionales', 'usuarios'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->RegionalesUsuario->id = $id;
		if (!$this->RegionalesUsuario->exists()) {
			throw new NotFoundException(__('La relación regional usuario no existe'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->RegionalesUsuario->delete()) {
			$this->Session->setFlash(__('La relación regional usuario ha sido eliminada.'));
		} else {
			$this->Session->setFlash(__('La relación regional usuario no pudo ser eliminada. Por favor, inténtelo de nuevo.'));
		}
		return $this->redirect(array('action' => 'index'));
	}}
