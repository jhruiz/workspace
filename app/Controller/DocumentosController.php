<?php
App::uses('AppController', 'Controller');
/**
 * Documentos Controller
 *
 * @property Documento $Documento
 * @property PaginatorComponent $Paginator
 */
class DocumentosController extends AppController {

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
                $paginate['Documento.descripcion LIKE '] = '%' . $this->passedArgs['Search.Nombre'] . '%';
            }
            
            if (isset($this->passedArgs['Search.tipodocumentale_id']) && !empty($this->passedArgs['Search.tipodocumentale_id'])) {
                $paginate['Documento.tipodocumento_id = '] = $this->passedArgs['Search.tipodocumentale_id'];
            }

            $this->Documento->recursive = 0;

            if (empty($paginate)) {
                $this->set('documentos', $this->Paginator->paginate());
            } else {
                $this->set('documentos', $this->Paginator->paginate('Documento', $paginate));
            }        
            
            $tipodocumental = $this->Documento->Tipodocumento->find('list');
            $this->set(compact('tipodocumental')); 
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
            
		if (!$this->Documento->exists($id)) {
			throw new NotFoundException(__('El documento no es válido'));
		}
		$options = array('conditions' => array('Documento.' . $this->Documento->primaryKey => $id));
		$this->set('documento', $this->Documento->find('first', $options));
                
                
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
            
		if ($this->request->is('post')) {
			$this->Documento->create();
			if ($this->Documento->save($this->request->data)) {
				$this->Session->setFlash(__('El documento ha sido guardado.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('El documento no pudo ser guardado. Por favor, inténtelo de nuevo.'));
			}
		}
		$tipodocumentos = $this->Documento->Tipodocumento->find('list');
		$paquetes = $this->Documento->Paquete->find('list');
		$this->set(compact('tipodocumentos', 'paquetes'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {             
		if (!$this->Documento->exists($id)) {
			throw new NotFoundException(__('El documento no existe'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Documento->save($this->request->data)) {
				$this->Session->setFlash(__('El documento ha sido guardado.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('El documento no pudo ser guardado. Por favor, inténtelo de nuevo.'));
			}
		} else {
			$options = array('conditions' => array('Documento.' . $this->Documento->primaryKey => $id));
			$this->request->data = $this->Documento->find('first', $options);
		}
		$tipodocumentos = $this->Documento->Tipodocumento->find('list');
		$paquetes = $this->Documento->Paquete->find('list');
		$this->set(compact('tipodocumentos', 'paquetes'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
            
		$this->Documento->id = $id;
		if (!$this->Documento->exists()) {
			throw new NotFoundException(__('El documento no es válido'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Documento->delete()) {
			$this->Session->setFlash(__('El documento ha sido eliminado.'));
		} else {
			$this->Session->setFlash(__('El documento no pudo ser eliminado. Por favor, inténtelo de nuevo.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

	/**
	 * Retorna el listado de documentos
	 */
	public function obtenerdocumentos(){
        $this->layout="ajax";
        $this->autoRender=false;
		
		$documentos = $this->Documento->obtenerDocumentos();
        
        echo json_encode($documentos);
	}
        
    public function search() {
            // the page we will redirect to
            $url=array();
            if($this->data['Documento']['accion_anterior']=='add'){
                $url['action'] = 'add';
            }else if($this->data['Documento']['accion_anterior']=='index'){
                $url['action'] = 'index';
            }

            foreach ($this->data as $k=>$v){
                if($k!='Documento'){
                    foreach ($v as $kk=>$vv){ 
                            $url[$k.'.'.$kk]=$vv; 
                    } 
                }
            }

            // redirect the user to the url
            $this->redirect($url, null, true);
    }    
}
