<?php
App::uses('AppController', 'Controller');
App::import('Model', 'Menu');
/**
 * Menus Controller
 *
 * @property Menu $Menu
 * @property PaginatorComponent $Paginator
 */
class MenusController extends AppController {

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
                $paginate['Menu.descripcion LIKE '] = '%' . $this->passedArgs['Search.Nombre'] . '%';
            }
            
            if (isset($this->passedArgs['Search.menupadre_id']) && !empty($this->passedArgs['Search.menupadre_id'])) {
                $paginate['Menu.menu_id'] = $this->passedArgs['Search.menupadre_id'];
            }

            $this->Paginator->settings = array(
                'order' => array('Menu.id' => 'ASC'),                            
                'limit' => 20,
                'paramType' => 'querystring',
                'recursive' => -1
            );
            if (empty($paginate)) {
                $menus = $this->Paginator->paginate('Menu');
            } else {
                $menus = $this->Paginator->paginate('Menu', $paginate);
            }   
            
            for($i=0; $i<count($menus); $i++){
                $menuPadre = $this->Menu->obtenerMenuPadrePorId($menus[$i]['Menu']['menu_id']);
                if(count($menuPadre)>0){
                    $menus[$i]['Menu']['menu_id'] = $menuPadre['Menu']['descripcion'];
                }else{
                    continue;
                }
            }
                
                $listMenuPadre = $this->Menu->find('list');
               
                $this->set(compact('menus', 'listMenuPadre'));                
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Menu->exists($id)) {
			throw new NotFoundException(__('El menú no existe'));
		}
                $this->Paginator->settings = array(
                    'conditions' => array('Menu.id' => $id), 
                    'order' => array('Menu.id' => 'ASC'),                            
                    'limit' => 20,
                    'paramType' => 'querystring',
                    'recursive' => -1
                );

                $menu = $this->Paginator->paginate('Menu'); 

                for($i=0; $i<count($menu); $i++){
                    $menuPadre = $this->Menu->obtenerMenuPadrePorId($menu[$i]['Menu']['menu_id']);
                    if(count($menuPadre)>0){
                        $menu[$i]['Menu']['menu_id'] = $menuPadre['Menu']['descripcion'];
                    }else{
                        continue;
                    }
                }           
               
		$this->set(compact('menu')); 
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
                    
			$this->Menu->create();
			if ($this->Menu->save($this->request->data)) {    
                            $this->asignarOrden($this->Menu->id, $this->request->data['Menu']['menu_id']);
                            $this->Session->setFlash(__('El menú ha sido guardado.'));
                            return $this->redirect(array('action' => 'index'));                            
			} else {
				$this->Session->setFlash(__('El menú no pudo ser guardado. Por favor, inténtelo de nuevo.'));
			}
		}
		$menus = $this->Menu->Menu->find('list');
		$perfiles = $this->Menu->Perfile->find('list');
		$this->set(compact('menus', 'perfiles'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Menu->exists($id)) {
			throw new NotFoundException(__('El menú no existe'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Menu->save($this->request->data)) {
                            $this->asignarOrden($this->request->data['Menu']['id'], $this->request->data['Menu']['menu_id']);
				$this->Session->setFlash(__('El menú ha sido guardado.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('El menú no pudo ser guardado. Por favor, inténtelo de nuevo.'));
			}
		} else {
			$options = array('conditions' => array('Menu.' . $this->Menu->primaryKey => $id));
			$this->request->data = $this->Menu->find('first', $options);
		}
		$menus = $this->Menu->Menu->find('list');
		$perfiles = $this->Menu->Perfile->find('list');
		$this->set(compact('menus', 'perfiles'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Menu->id = $id;
		if (!$this->Menu->exists()) {
			throw new NotFoundException(__('El menú no existe'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Menu->delete()) {
			$this->Session->setFlash(__('El menú ha sido eliminado.'));
		} else {
			$this->Session->setFlash(__('El menú no pudo ser eliminado. Por favor, inténtelo de nuevo.'));
		}
		return $this->redirect(array('action' => 'index'));
	} 
        
        public function asignarOrden($idMenu, $idPadre){  
            
            if(is_null($idPadre) || $idPadre == ""){
                $this->Menu->id = $idMenu;
                $this->Menu->saveField('orden', $idMenu);                              
            }else{
                $this->Menu->id = $idMenu;
                $this->Menu->saveField('orden', $idPadre);                
            }            
            $this->Session->setFlash(__('El menú ha sido guardado.'));
            return $this->redirect(array('action' => 'index'));
        }
        
        public function obtenerbandejasflujoajax(){
            $this->layout = 'ajax';
            $bandejasusr = array();

            if ($this->request->is('post')) {
                ///Se obtiene el id del usuario que viene como parametro
                $user_id = $this->request->data('user_id');

                /*** Cargamos las bandejas del usuario ***/ 
                $this->loadModel('Permisousuariobandeja');
                $bandejasusr = $this->Permisousuariobandeja->obtenerPermisoXUsuario($user_id);
                $this->set(compact('bandejasusr'));
            }                
        }
        
        public function search() {
                // the page we will redirect to
                $url=array();
                if($this->data['Menu']['accion_anterior']=='add'){
                    $url['action'] = 'add';
                }else if($this->data['Menu']['accion_anterior']=='index'){
                    $url['action'] = 'index';
                }

                foreach ($this->data as $k=>$v){
                    if($k!='Menu'){
                        foreach ($v as $kk=>$vv){ 
                                $url[$k.'.'.$kk]=$vv; 
                        } 
                    }
                }

                // redirect the user to the url
                $this->redirect($url, null, true);
        }        
        
}
