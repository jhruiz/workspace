<?php
App::uses('AppController', 'Controller');
/**
 * OficinasUsuarios Controller
 *
 * @property OficinasUsuario $OficinasUsuario
 * @property PaginatorComponent $Paginator
 */
class OficinasUsuariosController extends AppController {

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
            $this->Paginator->settings = $this->OficinasUsuario->obtenerListaOficinasUsuarios($usuarioId);
            $arrOficinasUsuarios = $this->Paginator->paginate('OficinasUsuario');
            $this->set(compact('arrOficinasUsuarios'));   
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->OficinasUsuario->exists($id)) {
			throw new NotFoundException(__('Invalid oficinas usuario'));
		}
		$options = array('conditions' => array('OficinasUsuario.' . $this->OficinasUsuario->primaryKey => $id));
		$this->set('oficinasUsuario', $this->OficinasUsuario->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->OficinasUsuario->create();
			if ($this->OficinasUsuario->save($this->request->data)) {
				$this->Session->setFlash(__('The oficinas usuario has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The oficinas usuario could not be saved. Please, try again.'));
			}
		}
		$oficinas = $this->OficinasUsuario->Oficina->find('list');
		$usuarios = $this->OficinasUsuario->Usuario->find('list');
		$this->set(compact('oficinas', 'usuarios'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->OficinasUsuario->exists($id)) {
			throw new NotFoundException(__('Invalid oficinas usuario'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->OficinasUsuario->save($this->request->data)) {
				$this->Session->setFlash(__('The oficinas usuario has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The oficinas usuario could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('OficinasUsuario.' . $this->OficinasUsuario->primaryKey => $id));
			$this->request->data = $this->OficinasUsuario->find('first', $options);
		}
		$oficinas = $this->OficinasUsuario->Oficina->find('list');
		$usuarios = $this->OficinasUsuario->Usuario->find('list');
		$this->set(compact('oficinas', 'usuarios'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
            //Se obtienen la información completa del registro
            $arrOfiUsr = $this->OficinasUsuario->obtenerOficinaUsuarioPorId($id);
            $this->OficinasUsuario->id = $id;
            if (!$this->OficinasUsuario->exists()) {
                    throw new NotFoundException(__('La relacion Oficina-Usuario no existe'));
            }
            $this->request->onlyAllow('post', 'delete');
            if ($this->OficinasUsuario->delete()) {
                    $this->Session->setFlash(__('La oficina ha sido eliminada.'));                        
            } else {
                    $this->Session->setFlash(__('La oficina no pudo ser eliminada. Por favor, intente de nuevo.'));
            }
            return $this->redirect(array('action' => 'index/' . $arrOfiUsr['OficinasUsuario']['usuario_id']));
	}}
