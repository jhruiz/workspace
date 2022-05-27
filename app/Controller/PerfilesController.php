<?php
App::uses('AppController', 'Controller');
App::import('Model', 'Auditoria');
/**
 * Perfiles Controller
 *
 * @property Perfile $Perfile
 * @property PaginatorComponent $Paginator
 */
class PerfilesController extends AppController {

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
                $paginate=array();
                if(isset($this->passedArgs['Search.Nombre'])) {
			$paginate['Perfile.descripcion LIKE'] = '%'.$this->passedArgs['Search.Nombre']."%";                        			
		}                

		$this->Perfile->recursive = 0;
                if(empty($paginate)){
                $this->set('perfiles', $this->Paginator->paginate());                           
            }else{
                $this->set('perfiles', $this->Paginator->paginate('Perfile',$paginate));                           
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
		if (!$this->Perfile->exists($id)) {
			throw new NotFoundException(__('El perfil no existe'));
		}
		$options = array('conditions' => array('Perfile.' . $this->Perfile->primaryKey => $id));
		$this->set('perfile', $this->Perfile->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Perfile->create();
			if ($this->Perfile->save($this->request->data)) {
				$this->Session->setFlash(__('El perfil ha sido guardado.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('El perfil no pudo ser guardado. Por favor, inténtelo de nuevo.'));
			}
		}
		$menus = $this->Perfile->Menu->find('list');
		$this->set(compact('menus'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {

		if (!$this->Perfile->exists($id)) {
			throw new NotFoundException(__('El Perfil no existe'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Perfile->save($this->request->data)) {
                             $this->Session->setFlash(__('El Perfil ha sido guardado.'));
                                return $this->redirect(array('action' => 'index'));
			}else {
				$this->Session->setFlash(__('El perfil no pudo ser guardado. Por favor, Inténtelo de nuevo.'));
			}
		} else {
			$options = array('conditions' => array('Perfile.' . $this->Perfile->primaryKey => $id));
			$this->request->data = $this->Perfile->find('first', $options);
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
		$this->Perfile->id = $id;
		if (!$this->Perfile->exists()) {
			throw new NotFoundException(__('El Perfil no existe'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Perfile->delete()) {
                     $this->Session->setFlash(__('El Perfil ha sido eliminado.'));
                        return $this->redirect(array('action' => 'index'));
		} else {
			 $this->Session->setFlash(__('El Perfil no pudo ser eliminado. Por favor, inténtelo de nuevo.'));
		}
                
                return $this->redirect(array('action' => 'index'));
	}
        
        public function search() {
		// the page we will redirect to
		$url=array();
            
                if($this->data['Perfile']['accion_anterior']=='add'){
                    $url['action'] = 'add';
                }else if($this->data['Perfile']['accion_anterior']=='index'){
                    $url['action'] = 'index';
                }                		                
                
		// build a URL will all the search elements in it
		// the resulting URL will be 
		// example.com/cake/posts/index/Search.keywords:mykeyword/Search.tag_id:3
		foreach ($this->data as $k=>$v){
                    if($k!='Perfile'){
			foreach ($v as $kk=>$vv){ 
				$url[$k.'.'.$kk]=$vv; 
			} 
                    }
		}

		// redirect the user to the url
		$this->redirect($url, null, true);
	}        
        
}         

