<?php
App::uses('AppController', 'Controller');
App::import('Model', 'Menu');
/**
 * Menus Controller
 *
 * @property Menu $Menu
 * @property PaginatorComponent $Paginator
 */
class ListachequeosController extends AppController {

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
            
        $listCheck = $this->Listachequeo->obtenerListasChequeo();   
        
        $this->set(compact('listCheck', 'listCheck'));                
	}


/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
                    
			$this->Listachequeo->create();
			if ($this->Listachequeo->save($this->request->data)) {    
                            $this->Session->setFlash(__('El item ha sido guardado.'));
                            return $this->redirect(array('action' => 'index'));                            
			} else {
				$this->Session->setFlash(__('El item no pudo ser guardado. Por favor, inténtelo de nuevo.'));
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
		if (!$this->Listachequeo->exists($id)) {
			throw new NotFoundException(__('El item no existe'));
		}

		if ($this->request->is(array('post', 'put'))) {
			if ($this->Listachequeo->save($this->request->data)) {
				$this->Session->setFlash(__('El item ha sido guardado.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('El item no pudo ser guardado. Por favor, inténtelo de nuevo.'));
			}
		} else {
			$options = array('conditions' => array('Listachequeo.' . $this->Listachequeo->primaryKey => $id));
			$this->request->data = $this->Listachequeo->find('first', $options);
		}
	}

}
