<?php
App::uses('AppController', 'Controller');
App::uses('CakeTime', 'Utility');

/**
 * Auditorias Controller
 *
 * @property Auditoria $Auditoria
 * @property PaginatorComponent $Paginator
 */
class AuditoriasController extends AppController {

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
                if(isset($this->passedArgs['Search.Descripcion']) && !empty($this->passedArgs['Search.Descripcion']) ) {
                        $paginate['Auditoria.descripcion LIKE '] = "%".$this->passedArgs['Search.Descripcion']."%";

                }

                if(isset($this->passedArgs['Search.Accion']) && !empty($this->passedArgs['Search.Accion'])) {
                        $paginate['Auditoria.accion LIKE '] = '%'.$this->passedArgs['Search.Accion']."%";

                }
                
                 if(isset($this->passedArgs['Search.FechaDesde']) && !empty($this->passedArgs['Search.FechaDesde']) && $this->passedArgs['Search.FechaDesde']!="--") {                        
                        $paginate['Auditoria.created >= '] = $this->passedArgs['Search.FechaDesde']." 00:00";

                }
                
                if(isset($this->passedArgs['Search.FechaHasta']) && !empty($this->passedArgs['Search.FechaHasta'])  && $this->passedArgs['Search.FechaHasta']!="--") {                        
                        $paginate['Auditoria.created  <= '] = $this->passedArgs['Search.FechaHasta']." 23:59:59";

                }
                                         
		$this->Auditoria->recursive = 0;

                if(empty($paginate)){
		$this->set('auditorias', $this->Paginator->paginate());
                }else{
                    $this->set('auditorias', $this->Paginator->paginate('Auditoria',$paginate));                           
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
		if (!$this->Auditoria->exists($id)) {
			throw new NotFoundException(__('El registro log de auditoria no existe.'));
		}
                
		$options = array('conditions' => array('Auditoria.' . $this->Auditoria->primaryKey => $id));
		$this->set('auditoria', $this->Auditoria->find('first', $options));
	}

        public function search() {
		// the page we will redirect to
		$url=array();
            
                if($this->data['Auditoria']['accion_anterior']=='add'){
                    $url['action'] = 'add';
                }else if($this->data['Auditoria']['accion_anterior']=='index'){
                    $url['action'] = 'index';
                }

		// build a URL will all the search elements in it
		// the resulting URL will be 
		// example.com/cake/posts/index/Search.keywords:mykeyword/Search.tag_id:3
		foreach ($this->data as $k=>$v){                    
                    if($k!='Auditoria'){                                                
			foreach ($v as $kk=>$vv){ 
                            if($kk=="FechaDesde" || $kk=="FechaHasta"){ 
                                //$date=new DateTime($vv);
                                //$vv= $date->format('Y-m-d');
                                $fecha = explode('/',$vv);
                                
                                $vv=$fecha[2]."-".$fecha[1]."-".$fecha[0];
                            }
				$url[$k.'.'.$kk]=$vv; 
			}
                    }
                }

		// redirect the user to the url
		$this->redirect($url, null, true);
        }
}
