<?php
App::uses('AppController', 'Controller');
App::import('Model', 'Auditoria');
/**
 * Ciudades Controller
 *
 * @property Ciudade $Ciudade
 * @property PaginatorComponent $Paginator
 */
class CiudadesController extends AppController {

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
           
                $title = array();
                $paginate=array();
                if(isset($this->passedArgs['Search.Nombre']) && !empty($this->passedArgs['Search.Nombre'])) {
                        $paginate['Ciudade.descripcion LIKE '] = '%'.$this->passedArgs['Search.Nombre']."%";
                }
                
                if(isset($this->passedArgs['Search.regionales']) && !empty($this->passedArgs['Search.regionales'])) {
                        $paginate['Ciudade.regionale_id ='] = $this->passedArgs['Search.regionales'];
                }
                
                $this->Ciudade->recursive = 0;

                if(empty($paginate)){
                    $this->set('ciudades', $this->Paginator->paginate());                           
                }else{
                    $this->set('ciudades', $this->Paginator->paginate('Ciudade',$paginate));                           
                }
                
            $regionales = $this->Ciudade->Regionale->find('list');
            $this->set(compact('regionales'));                 
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
            
		if (!$this->Ciudade->exists($id)) {
			throw new NotFoundException(__('La ciudad no existe.'));
		}
		$options = array('conditions' => array('Ciudade.' . $this->Ciudade->primaryKey => $id));
		$this->set('ciudade', $this->Ciudade->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Ciudade->create();
			if ($this->Ciudade->save($this->request->data)) {
				$this->Session->setFlash(__('La ciudad ha sido guardada'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('La ciudad no ha sido guardada'));
			}
		}
                
		$regionales = $this->Ciudade->Regionale->find('list',array('conditions'=>array('Regionale.estadoregistro_id'=>1)));
		$estadoregistros = $this->Ciudade->Estadoregistro->find('list');
		$this->set(compact('regionales', 'estadoregistros'));   
                
                $title = array();
                $paginate=array();
                if(isset($this->passedArgs['Search.Nombre']) && !empty($this->passedArgs['Search.Nombre'])) {
                        $paginate['Ciudade.nombre LIKE '] = str_replace('*','%',$this->passedArgs['Search.Nombre']);

                }
                                         
            $this->Ciudade->recursive = 0;
            
            if(empty($paginate)){
                $this->set('ciudades', $this->Paginator->paginate());                           
            }else{
                $this->set('ciudades', $this->Paginator->paginate('Ciudade',$paginate));                           
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
		if (!$this->Ciudade->exists($id)) {
			throw new NotFoundException(__('La ciudad no existe.'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Ciudade->save($this->request->data)) {
                                $this->Session->setFlash(__('La ciudad ha sido guardada'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('La ciudad no ha sido guardada'));
			}
		} else {
			$options = array('conditions' => array('Ciudade.' . $this->Ciudade->primaryKey => $id));
			$this->request->data = $this->Ciudade->find('first', $options);
		}
		
                $regionales = $this->Ciudade->Regionale->find('list',array('conditions'=>array('Regionale.estadoregistro_id'=>1)));
		$estadoregistros = $this->Ciudade->Estadoregistro->find('list');
		$this->set(compact('regionales', 'estadoregistros'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
            
		$this->Ciudade->id = $id;
		if (!$this->Ciudade->exists()) {
			throw new NotFoundException(__('La ciudad no existe.'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Ciudade->delete()) {
			$this->Session->setFlash(__('La ciudad ha sido eliminada.'));
		} else {
			$this->Session->setFlash(__('La ciudad no pudo ser eliminada. Por favor intente de nuevo.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
        
        public function search() {
		// the page we will redirect to
		$url=array();
            
                if($this->data['Ciudade']['accion_anterior']=='add'){
                    $url['action'] = 'add';
                }else if($this->data['Ciudade']['accion_anterior']=='index'){
                    $url['action'] = 'index';
                }                
                
		foreach ($this->data as $k=>$v){
                    if($k!='Ciudade'){
			foreach ($v as $kk=>$vv){ 
				$url[$k.'.'.$kk]=$vv; 
			} 
                    }
		}

		// redirect the user to the url
		$this->redirect($url, null, true);
	}
        
         public function inactivar($id = null) {
             
                $this->Ciudade->id = $id;
                
                if (!$this->Ciudade->exists()) {
                    throw new NotFoundException(__('La ciudad no existe'));
                }          
                
                $this->request->onlyAllow('post', 'delete');
                $id = $this->request->params['pass'][0];
                $datos= $this->Ciudade->obtenerCiudadesPorId($id);
                $estadReg = $datos['Ciudade']['estadoregistro_id'];
                $mensaje="";
                
                if($estadReg == 1){
                    $newEst = 2;
                    $mensaje="Inactiva";
                }else{
                    $newEst = 1;
                    $mensaje="Activa";
                }
                
                if($this->Ciudade->updateAll(
                        
                        array('Ciudade.estadoregistro_id' => $newEst),
                        array('Ciudade.id' => $id)                       
                )){                    
                    $this->Session->setFlash(__('Se ha cambiado el estado de la Ciudad a '.$mensaje));
                    return $this->redirect(array('action' => 'index'));               
                }else{
                    $this->Session->setFlash(__('Se produjo un error, intentelo de nuevo'));
                }
        }                  
}
