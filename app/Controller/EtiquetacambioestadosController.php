<?php
App::uses('AppController', 'Controller');
/**
 * Etiquetacambioestados Controller
 *
 * @property Etiquetacambioestado $Etiquetacambioestado
 * @property PaginatorComponent $Paginator
 */
class EtiquetacambioestadosController extends AppController {

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
            
            $paginate = array();
            if (isset($this->passedArgs['Search.Nombre']) && !empty($this->passedArgs['Search.Nombre'])) {
                $paginate['Etiquetacambioestado.descripcion LIKE '] = '%' . $this->passedArgs['Search.Nombre'] . '%';
            }

            $this->Etiquetacambioestado->recursive = 0;

            if (empty($paginate)) {
                $this->set('etiquetacambioestados', $this->Paginator->paginate());
            } else {
                $this->set('etiquetacambioestados', $this->Paginator->paginate('Etiquetacambioestado', $paginate));
            }            
		
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Etiquetacambioestado->exists($id)) {
			throw new NotFoundException(__('La etiqueta para cambio de estado no existe'));
		}
		$options = array('conditions' => array('Etiquetacambioestado.' . $this->Etiquetacambioestado->primaryKey => $id));
		$this->set('etiquetacambioestado', $this->Etiquetacambioestado->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Etiquetacambioestado->create();
			if ($this->Etiquetacambioestado->save($this->request->data)) {
				$this->Session->setFlash(__('La etiqueta para cambio de estado ha sido guardada.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('La etiqueta para cambio de estado no pudo ser guardada. Por favor, inténtelo de nuevo.'));
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
		if (!$this->Etiquetacambioestado->exists($id)) {
			throw new NotFoundException(__('La etiqueta para cambio de estado no existe'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Etiquetacambioestado->save($this->request->data)) {
				$this->Session->setFlash(__('La etiqueta para cambio de estado ha sido guardada'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('La etiqueta para cambio de estado no pudo ser guardada. Por favor, inténtelo de nuevo.'));
			}
		} else {
			$options = array('conditions' => array('Etiquetacambioestado.' . $this->Etiquetacambioestado->primaryKey => $id));
			$this->request->data = $this->Etiquetacambioestado->find('first', $options);
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
		$this->Etiquetacambioestado->id = $id;
		if (!$this->Etiquetacambioestado->exists()) {
			throw new NotFoundException(__('La etiqueta para cambio de estado no existe'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Etiquetacambioestado->delete()) {
			$this->Session->setFlash(__('La etiqueta para cambio de estado ha sido eliminada.'));
		} else {
			$this->Session->setFlash(__('La etiqueta para cambio de estado pudo ser eliminada. Por favor, inténtelo de nuevo.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
        
    public function search() {
            // the page we will redirect to
            $url=array();
            if($this->data['Etiquetacambioestado']['accion_anterior']=='add'){
                $url['action'] = 'add';
            }else if($this->data['Etiquetacambioestado']['accion_anterior']=='index'){
                $url['action'] = 'index';
            }

            foreach ($this->data as $k=>$v){
                if($k!='Etiquetacambioestado'){
                    foreach ($v as $kk=>$vv){ 
                            $url[$k.'.'.$kk]=$vv; 
                    } 
                }
            }

            // redirect the user to the url
            $this->redirect($url, null, true);
    }        
}
