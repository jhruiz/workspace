<?php
App::uses('AppController', 'Controller');
/**
 * MenusPerfiles Controller
 *
 * @property MenusPerfile $MenusPerfile
 * @property PaginatorComponent $Paginator
 */
class MenusPerfilesController extends AppController {

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
            if (isset($this->passedArgs['Search.menus']) && !empty($this->passedArgs['Search.menus'])) {
                $paginate['MenusPerfile.menu_id = '] = $this->passedArgs['Search.menus'];
            }
            
            if (isset($this->passedArgs['Search.perfiles']) && !empty($this->passedArgs['Search.perfiles'])) {
                $paginate['MenusPerfile.perfile_id ='] = $this->passedArgs['Search.perfiles'];
            }

            $this->MenusPerfile->recursive = 0;

            if (empty($paginate)) {
                $this->set('menusPerfiles', $this->Paginator->paginate());
            } else {
                $this->set('menusPerfiles', $this->Paginator->paginate('MenusPerfile', $paginate));
            }
            
            $listMenus = $this->MenusPerfile->Menu->find('list');
            $this->set(compact('listMenus')); 
            
            $listPerfiles = $this->MenusPerfile->Perfile->find('list');
            $this->set(compact('listPerfiles'));             
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->MenusPerfile->exists($id)) {
			throw new NotFoundException(__('La relación Menú - Perfil no existe'));
		}
		$options = array('conditions' => array('MenusPerfile.' . $this->MenusPerfile->primaryKey => $id));
		$this->set('menusPerfile', $this->MenusPerfile->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {                    
                    //Se obtienen los menus que ya tiene asignado el perfil
                    $arrMenuPerfil = $this->MenusPerfile->obtenerMenusPerfiles($this->request->data['MenusPerfile']['menu_id'], $this->request->data['MenusPerfile']['perfile_id']);
                    
                    if(count($arrMenuPerfil)>0){
                            $this->Session->setFlash(__('Ya existe la relación Menú - Perfil.'));
                            return $this->redirect(array('action' => 'index'));                        
                    }else{
			$this->MenusPerfile->create();
			if ($this->MenusPerfile->save($this->request->data)) {
                            $this->Session->setFlash(__('La relación Menú - Perfil ha sido guardada.'));
                            return $this->redirect(array('action' => 'index'));  
			} else {
				$this->Session->setFlash(__('La relación Menú - Perfil no pudo ser guardada. Por favor, inténtelo de nuevo.'));
			}                        
                    }                    

		}
		$menus = $this->MenusPerfile->Menu->find('list');
		$perfiles = $this->MenusPerfile->Perfile->find('list');
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
		if (!$this->MenusPerfile->exists($id)) {
			throw new NotFoundException(__('La relación Menú - Perfil no existe'));
		}   
                
		if ($this->request->is(array('post', 'put'))) {
                    //Se obtienen los menus que ya tiene asignado el perfil
                    $arrMenuPerfil = $this->MenusPerfile->obtenerMenusPerfiles($this->request->data['MenusPerfile']['menu_id'], $$this->request->data['MenusPerfile']['perfile_id']);
                    
                    if(count($arrMenuPerfil)>0){
                            $this->Session->setFlash(__('Ya existe la relación Menú - Perfil.'));
                            return $this->redirect(array('action' => 'index'));                        
                    }else{
			if ($this->MenusPerfile->save($this->request->data)) {
				$this->Session->setFlash(__('La relación Menú - Perfil ha sido guardada.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('La relación Menú - Perfil no pudo ser guardada. Por favor, inténtelo de nuevo.'));
			}                        
                    }                     

		} else {
			$options = array('conditions' => array('MenusPerfile.' . $this->MenusPerfile->primaryKey => $id));
			$this->request->data = $this->MenusPerfile->find('first', $options);
		}
		$menus = $this->MenusPerfile->Menu->find('list');
		$perfiles = $this->MenusPerfile->Perfile->find('list');
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
		$this->MenusPerfile->id = $id;
		if (!$this->MenusPerfile->exists()) {
			throw new NotFoundException(__('La relación Menú - Perfil no existe'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->MenusPerfile->delete()) {
			$this->Session->setFlash(__('La relación Menú - Perfil ha sido eliminada.'));
		} else {
			$this->Session->setFlash(__('La relación Menú - Perfil no pudo ser eliminado. Por favor, inténtelo de nuevo.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
        
        public function search() {
                // the page we will redirect to
                $url=array();
                if($this->data['Menusperfile']['accion_anterior']=='add'){
                    $url['action'] = 'add';
                }else if($this->data['Menusperfile']['accion_anterior']=='index'){
                    $url['action'] = 'index';
                }

                foreach ($this->data as $k=>$v){
                    if($k!='Menusperfile'){
                        foreach ($v as $kk=>$vv){ 
                                $url[$k.'.'.$kk]=$vv; 
                        } 
                    }
                }

                // redirect the user to the url
                $this->redirect($url, null, true);
        }         
        
}
