<?php
App::uses('AppController', 'Controller');
/**
 * Tipodocumentos Controller
 *
 * @property Tipodocumento $Tipodocumento
 * @property PaginatorComponent $Paginator
 */
class TipodocumentosController extends AppController {

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
                
                if(isset($this->passedArgs['Search.Nombre']) && !empty($this->passedArgs['Search.Nombre'])) {
                        $paginate['Tipodocumento.descripcion LIKE '] = '%'.$this->passedArgs['Search.Nombre'].'%';
                }

                if(isset($this->passedArgs['Search.serie_id']) && !empty($this->passedArgs['Search.serie_id'])) {
                        $paginate['Tipodocumento.serie_id = '] = $this->passedArgs['Search.serie_id'];
                }
                
                if(isset($this->passedArgs['Search.codigo']) && !empty($this->passedArgs['Search.codigo'])) {
                        $paginate['Tipodocumento.codigo LIKE '] = '%'.$this->passedArgs['Search.codigo'].'%';
                }                
                
                $this->Tipodocumento->recursive = 0;

                if(empty($paginate)){
                    $this->set('tipodocumentos', $this->Paginator->paginate());                           
                }else{
                    $this->set('tipodocumentos', $this->Paginator->paginate('Tipodocumento',$paginate));                           
                }       
                
                $arrSerie = $this->Tipodocumento->Serie->find('all');
                foreach ($arrSerie as $clv => $val){
                    $listSerie[$val['Serie']['id']] = $val['Serie']['descripcion'];
                }
                
                $this->set(compact('listSerie'));
                
		
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Tipodocumento->exists($id)) {
			throw new NotFoundException(__('El tipo documento no es válido'));
		}
		$options = array('conditions' => array('Tipodocumento.' . $this->Tipodocumento->primaryKey => $id));
		$this->set('tipodocumento', $this->Tipodocumento->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
            
		if ($this->request->is('post')) {
			$this->Tipodocumento->create();
			if ($this->Tipodocumento->save($this->request->data)) {
				$this->Session->setFlash(__('El tipo documento ha sido guardado.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('Tl tipo documento no pudo ser guardado. Por favor, inténtelo de nuevo.'));
			}
		}
                
		$infoSeries = $this->Tipodocumento->Serie->find('all', array('recursive' => -1));
                for($i = 0; $i < count($infoSeries); $i++){
                    $series[$infoSeries[0]['Serie']['id']] = $infoSeries[0]['Serie']['descripcion']; 
                }

		$this->set(compact('series'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Tipodocumento->exists($id)) {
			throw new NotFoundException(__('El tipo documento no es válido.'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Tipodocumento->save($this->request->data)) {
				$this->Session->setFlash(__('El tipo documento ha sido guardado.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('El tipo documento no ha sido guardado. Por favor, inténtelo de nuevo.'));
			}
		} else {
			$options = array('conditions' => array('Tipodocumento.' . $this->Tipodocumento->primaryKey => $id));
			$this->request->data = $this->Tipodocumento->find('first', $options);
		}
		$infoSeries = $this->Tipodocumento->Serie->find('all', array('recursive' => -1));
                for($i = 0; $i < count($infoSeries); $i++){
                    $series[$infoSeries[0]['Serie']['id']] = $infoSeries[0]['Serie']['descripcion']; 
                }
		$this->set(compact('series'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Tipodocumento->id = $id;
		if (!$this->Tipodocumento->exists()) {
			throw new NotFoundException(__('El tipo documento no es válido.'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Tipodocumento->delete()) {
			$this->Session->setFlash(__('El tipo documento ha sido eliminado.'));
		} else {
			$this->Session->setFlash(__('El tipo documento no pudo ser eliminado. Por favor, inténtelo de nuevo.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

        public function search() {
		// the page we will redirect to
		$url=array();
            
                if($this->data['Tipodocumento']['accion_anterior']=='add'){
                    $url['action'] = 'add';
                }else if($this->data['Tipodocumento']['accion_anterior']=='index'){
                    $url['action'] = 'index';
                }      

		// build a URL will all the search elements in it
		// the resulting URL will be 
		// example.com/cake/posts/index/Search.keywords:mykeyword/Search.tag_id:3
		foreach ($this->data as $k=>$v){
                    if($k!='Tipodocumento'){
			foreach ($v as $kk=>$vv){ 
				$url[$k.'.'.$kk]=$vv; 
			} 
                    }
		}

		// redirect the user to the url
		$this->redirect($url, null, true);
	}          
}
