<?php
App::uses('AppController', 'Controller');
/**
 * Solicitudreportes Controller
 *
 * @property Solicitudreporte $Solicitudreporte
 * @property PaginatorComponent $Paginator
 */
class SolicitudreportesController extends AppController {

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
	public function index($tipoReporte = null) {
                       
                $estados = array('0' => '2', '1' => '3', '2' => '4'); //Estados validos para mostrar el registro del reporte, 2 = generado con exito, 3 = error en generacion
                $paginate['Solicitudreporte.estadosolicitud'] = $estados;
                $paginate['Solicitudreporte.tiporeporte'] = $tipoReporte;
		$this->Solicitudreporte->recursive = 0;
		$this->set('solicitudreportes', $this->Paginator->paginate('Solicitudreporte', $paginate));
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Solicitudreporte->exists($id)) {
			throw new NotFoundException(__('Invalid solicitudreporte'));
		}
		$options = array('conditions' => array('Solicitudreporte.' . $this->Solicitudreporte->primaryKey => $id));
		$this->set('solicitudreporte', $this->Solicitudreporte->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Solicitudreporte->create();
			if ($this->Solicitudreporte->save($this->request->data)) {
				$this->Session->setFlash(__('The solicitudreporte has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The solicitudreporte could not be saved. Please, try again.'));
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
		if (!$this->Solicitudreporte->exists($id)) {
			throw new NotFoundException(__('Invalid solicitudreporte'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Solicitudreporte->save($this->request->data)) {
				$this->Session->setFlash(__('The solicitudreporte has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The solicitudreporte could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Solicitudreporte.' . $this->Solicitudreporte->primaryKey => $id));
			$this->request->data = $this->Solicitudreporte->find('first', $options);
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null, $redirect = null, $idTipoReporte = null) {
		$this->Solicitudreporte->id = $id;
		if (!$this->Solicitudreporte->exists()) {
			throw new NotFoundException(__('La solicitud del reporte no es válida'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Solicitudreporte->delete()) {
			$this->Session->setFlash(__('La solicitud del reporte ha sido eliminada.'));
		} else {
			$this->Session->setFlash(__('La solicitud del reporte no ha sido eliminada. Por favor, intételo de nuevo.'));
		}
		return $this->redirect(array('action' => $redirect . '/' . $idTipoReporte));
	}
        
        public function reportegeneral(){
            
            $this->loadModel('Regionale');
            $this->loadModel('Ciudade');
            $this->loadModel('Oficina');
            $this->loadModel('Estado');
            
            $regional = $this->Regionale->obtenerTodasRegionales();
            $ciudad = $this->Ciudade->obtenerListaCiudades();            
            $oficina = $this->Oficina->obtenerListaOficinas();
            $estado = $this->Estado->obtenerListaEstados();
            
            $this->set(compact('oficina', 'regional', 'ciudad', 'estado'));
        }
        
        public function generarReporteGeneral(){
            $this->autoRender = false;
            
            $estadoActual = $this->request->data['Solicitudreporte']['estado'];
            $tiporeporte = $this->request->data['Solicitudreporte']['tiporeporte'];
            $fecha_inicio = $this->request->data['Solicitudreporte']['fecha_inicio'];
            $fecha_fin = $this->request->data['Solicitudreporte']['fecha_fin'];
            $regional = $this->request->data['Solicitudreporte']['regional'];
            if($this->request->data['Reporte']['ciudad']){
                $ciudad = $this->request->data['Reporte']['ciudad'];
            }else{
                $ciudad = $this->request->data['Solicitudreporte']['ciudad'];
            }  
            $oficina = $this->request->data['Reporte']['oficina'];
            $usuarioSolicitud = $this->Auth->user('id');
          
            if ($this->Solicitudreporte->guardarSolicitudReporte($estadoActual,$tiporeporte,$fecha_inicio,$fecha_fin,$regional,$ciudad,$oficina, $auditor = null, $ejecutivo = null,$usuarioSolicitud)) {
                    $this->Session->setFlash(__('Se ha realizado la solicitud del reporte.'));
                    return $this->redirect(array('action' => 'reportegeneral'));
            } else {
                    $this->Session->setFlash(__('No se ha realizado la solicitud del reporte. Por favor, inténtelo de nuevo.'));
            }
            
        }
        
        public function cargastrabajoauditor(){
            $this->loadModel('Regionale');
            $this->loadModel('Ciudade');
            $this->loadModel('Oficina');
            $this->loadModel('Estado');
            $this->loadModel('Usuario');
            
            $regional = $this->Regionale->obtenerTodasRegionales();
            $ciudad = $this->Ciudade->obtenerListaCiudades();            
            $oficina = $this->Oficina->obtenerListaOficinas();
            $usuarioAuditor = $this->Usuario->obtenerListaUsuariosPerfil($perfilId = '5');
            
            $this->set(compact('oficina', 'regional', 'ciudad', 'usuarioAuditor'));
        }    
        
        
        public function generarReporteCargasAuditor(){
            $this->autoRender = false;
            $auditor = $this->request->data['Solicitudreporte']['usuario'];
            $tiporeporte = $this->request->data['Solicitudreporte']['tiporeporte'];
            $fecha_inicio = $this->request->data['Solicitudreporte']['fecha_inicio'];
            $fecha_fin = $this->request->data['Solicitudreporte']['fecha_fin'];
            $regional = $this->request->data['Solicitudreporte']['regional'];
            if($this->request->data['Reporte']['ciudad']){
                $ciudad = $this->request->data['Reporte']['ciudad'];
            }else{
                $ciudad = $this->request->data['Solicitudreporte']['ciudad'];
            }  
            $oficina = $this->request->data['Reporte']['oficina'];
            $usuarioSolicitud = $this->Auth->user('id');
          
            if ($this->Solicitudreporte->guardarSolicitudReporte($estadoActual = null,$tiporeporte,$fecha_inicio,$fecha_fin,$regional,$ciudad,$oficina, $auditor, $ejecutivo = null,$usuarioSolicitud)) {
                    $this->Session->setFlash(__('Se ha realizado la solicitud del reporte.'));
                    return $this->redirect(array('action' => 'cargastrabajoauditor'));
            } else {
                    $this->Session->setFlash(__('No se ha realizado la solicitud del reporte. Por favor, inténtelo de nuevo.'));
            }            
        }
        
        public function cargastrabajoejecutivo(){
            $this->loadModel('Regionale');
            $this->loadModel('Ciudade');
            $this->loadModel('Oficina');
            $this->loadModel('Estado');
            $this->loadModel('Usuario');
            
            $regional = $this->Regionale->obtenerTodasRegionales();
            $ciudad = $this->Ciudade->obtenerListaCiudades();            
            $oficina = $this->Oficina->obtenerListaOficinas();
            $perfilId = array('0' => '3', '1' => '4');
            $usuarioEjecutivo = $this->Usuario->obtenerListaUsuariosPerfil($perfilId);
            
            $this->set(compact('oficina', 'regional', 'ciudad', 'usuarioEjecutivo'));
        }          
        
        public function generarReporteCargasEjecutivo(){
            $this->autoRender = false;
            $ejecutivo = $this->request->data['Solicitudreporte']['usuario'];
            $tiporeporte = $this->request->data['Solicitudreporte']['tiporeporte'];
            $fecha_inicio = $this->request->data['Solicitudreporte']['fecha_inicio'];
            $fecha_fin = $this->request->data['Solicitudreporte']['fecha_fin'];
            $regional = $this->request->data['Solicitudreporte']['regional'];
            if($this->request->data['Reporte']['ciudad']){
                $ciudad = $this->request->data['Reporte']['ciudad'];
            }else{
                $ciudad = $this->request->data['Solicitudreporte']['ciudad'];
            }            
            $oficina = $this->request->data['Reporte']['oficina'];
            $usuarioSolicitud = $this->Auth->user('id');
            
            if ($this->Solicitudreporte->guardarSolicitudReporte($estadoActual = null,$tiporeporte,$fecha_inicio,$fecha_fin,$regional,$ciudad,$oficina, $auditor = null, $ejecutivo,$usuarioSolicitud)) {
                    $this->Session->setFlash(__('Se ha realizado la solicitud del reporte.'));
                    return $this->redirect(array('action' => 'cargastrabajoejecutivo'));
            } else {
                    $this->Session->setFlash(__('No se ha realizado la solicitud del reporte. Por favor, inténtelo de nuevo.'));
            }             
        }
        
        public function listacargastrabajoejecutivo($tipoReporte = null){                    
                $estados = array('0' => '2', '1' => '4'); //Estados validos para mostrar el registro del reporte, 2 = generado con exito, 3 = error en generacion
                $paginate['Solicitudreporte.estadosolicitud'] = $estados;
                $paginate['Solicitudreporte.tiporeporte'] = $tipoReporte;
		$this->Solicitudreporte->recursive = 0;
		$this->set('solicitudreportes', $this->Paginator->paginate('Solicitudreporte', $paginate));          
        }
        
        public function listacargastrabajoauditor($tipoReporte = null){                    
                $estados = array('0' => '2', '1' => '4'); //Estados validos para mostrar el registro del reporte, 2 = generado con exito, 3 = error en generacion
                $paginate['Solicitudreporte.estadosolicitud'] = $estados;
                $paginate['Solicitudreporte.tiporeporte'] = $tipoReporte;
		$this->Solicitudreporte->recursive = 0;
		$this->set('solicitudreportes', $this->Paginator->paginate('Solicitudreporte', $paginate));          
        }

        public function listareportegeneral($tipoReporte = null){                       
                $estados = array('0' => '2', '1' => '4'); //Estados validos para mostrar el registro del reporte, 2 = generado con exito, 3 = error en generacion
                $paginate['Solicitudreporte.estadosolicitud'] = $estados;
                $paginate['Solicitudreporte.tiporeporte'] = $tipoReporte;
		$this->Solicitudreporte->recursive = 0;
		$this->set('solicitudreportes', $this->Paginator->paginate('Solicitudreporte', $paginate));          
        }        
        
}
