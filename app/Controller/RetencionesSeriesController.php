<?php
App::uses('AppController', 'Controller');

class RetencionesSeriesController extends AppController {

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

        $this->loadModel('Serie');
        $this->loadModel('RetencionesSerie');
        $this->loadModel('Unidadesmedida');
        $this->loadModel('Acciondisposicione');

        $this->RetencionesSerie->recursive = 0;

        $this->set('retencionesseries', $this->Paginator->paginate());
        
        $series = $this->Serie->find('list');
        $unidadMed = $this->Unidadesmedida->obtenerUnidadesMedida();
        $uMed = [];
        foreach ($unidadMed as $um) {
            $uMed[$um['Unidadesmedida']['id']] = $um['Unidadesmedida']['descripcion'];
        }

        //se obtienen las posibles acciones sobre los documentos en la retención documental
        $arrAcciones = $this->Acciondisposicione->obtenerAccionDisposicion();
        $acciones = [];
        foreach($arrAcciones as $ac) {
            $acciones[$ac['Acciondisposicione']['id']] = $ac['Acciondisposicione']['descripcion'];
        }

        $this->set(compact('series', 'uMed', 'acciones')); 
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
        $this->loadModel('Serie');
        $this->loadModel('RetencionesSerie');
        $this->loadModel('Unidadesmedida');
        $this->loadModel('Acciondisposicione');
            
		if ($this->request->is('post')) {

            //se valida si el documento ya tiene un registro de retención documental
            $regRetencion = $this->RetencionesSerie->obtenerRetencionPorDoc($this->request->data['RetencionesSerie']['serie_id']);

            if(!isset($regRetencion['0']['RetencionesSerie']['id'])){               
                $this->RetencionesSerie->create();
                if ($this->RetencionesSerie->save($this->request->data)) {
                    $this->Session->setFlash(__('La retención documental ha sido guardada.'));
                    return $this->redirect(array('action' => 'index'));
                } else {
                    $this->Session->setFlash(__('La retención documental no pudo ser guardada. Por favor, inténtelo de nuevo.'));
                }
            } else {
                $this->Session->setFlash(__('Ya existe un registro de retención documental para el documento seleccionado.'));
            }

		}

		$series = $this->Serie->find('list');
        $unidadMed = $this->Unidadesmedida->obtenerUnidadesMedida();
        $uMed = [];
        foreach($unidadMed as $um) {
            $uMed[$um['Unidadesmedida']['id']] = $um['Unidadesmedida']['descripcion'];
        }

        //se obtienen las posibles acciones sobre los documentos en la retención documental
        $arrAcciones = $this->Acciondisposicione->obtenerAccionDisposicion();
        $acciones = [];
        foreach($arrAcciones as $ac) {
            $acciones[$ac['Acciondisposicione']['id']] = $ac['Acciondisposicione']['descripcion'];
        }

        $this->set(compact('series', 'uMed', 'acciones')); 
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {        
        $this->loadModel('Serie');
        $this->loadModel('RetencionesSerie');
        $this->loadModel('Unidadesmedida');
        $this->loadModel('Acciondisposicione');

		if (!$this->RetencionesSerie->exists($id)) {
			throw new NotFoundException(__('El registro de retención documental no existe.'));
		}

		if ($this->request->is(array('post', 'put'))) {
			if ($this->RetencionesSerie->save($this->request->data)) {
				$this->Session->setFlash(__('El registro de retención documental ha sido actualizada.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('El registro de retención documental no pudo ser guardado. Por favor, inténtelo de nuevo.'));
			}
		}

        //se obtiene el registro de retención por id
        $retencion = $this->RetencionesSerie->obtenerRetencionPorId($id);

		$series = $this->Serie->find('list');
        $unidadMed = $this->Unidadesmedida->obtenerUnidadesMedida();
        $uMed = [];
        foreach($unidadMed as $um) {
            $uMed[$um['Unidadesmedida']['id']] = $um['Unidadesmedida']['descripcion'];
        }

        //se obtienen las posibles acciones sobre los documentos en la retención documental
        $arrAcciones = $this->Acciondisposicione->obtenerAccionDisposicion();
        $acciones = [];
        foreach($arrAcciones as $ac) {
            $acciones[$ac['Acciondisposicione']['id']] = $ac['Acciondisposicione']['descripcion'];
        }
        
        $this->set(compact('series', 'uMed', 'retencion', 'acciones')); 
	}
        
    public function search() {
    
        // the page we will redirect to
        $url=array();
        $url['action'] = 'index';

        foreach ($this->data as $k=>$v){
            if($k!='RetencionesSerie'){
                foreach ($v as $kk=>$vv){ 
                        $url[$k.'.'.$kk]=$vv; 
                } 
            }
        }

        // redirect the user to the url
        $this->redirect($url, null, true);
    }    
}
