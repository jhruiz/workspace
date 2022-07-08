<?php
App::uses('AppController', 'Controller');
App::import('Model', 'Auditoria');

class PaquetesUbicacionesfisicasController extends AppController {

    /**
     * Components
     *
     * @var array
     */
	public $components = array('Paginator');

    /**
     * Muestra el modal con las ubicaciones seleccionadas o por seleccionar del paquete
     */
	public function mostrarUbicacion() {
        $this->loadModel('Ubicacionesfisica');
        $paqueteId = $this->request->data['paquete_id'];

        //se obtienen las ubicaciones padre 
        $ubPadre = $this->Ubicacionesfisica->obtenerUbicacionesPadre();
            
        $this->set(compact('ubPadre')); 
        
	}   
    
    /**
     * Guardar el paquete en la ubicacion seleccionada
     */
    public function guardarubicacion() {
        $this->autoRender=false;
        $idUbicacion = $this->request->data['idUbicacion'];
        $idPaquete = $this->request->data['idPaquete'];
        $idUsuario = $this->Auth->user('id');
        $fecha = date('Y-m-d H:i:s');

        //se valida si existe un regitro de almacenamiento para eliminarlo
        $ubPaquete = $this->PaquetesUbicacionesfisica->obtenerUbicacionPaqueteU($idPaquete);
        if(!empty($ubPaquete)) {
            // se elimina la ubicación actual del paquete
            $this->PaquetesUbicacionesfisica->eliminarUbicacionPaquete($ubPaquete['0']['PaquetesUbicacionesfisica']['id']);
            
        }

        $resp = $this->PaquetesUbicacionesfisica->guardarUbicacion($idUbicacion, $idPaquete, $idUsuario, $fecha);

        //se valida si existe ubicación para el paquete
        $ubPaquete = $this->PaquetesUbicacionesfisica->obtenerUbicacionPaqueteU($idPaquete);

        $ubicacion = [];
        
        if(!empty($ubPaquete)) {
            // se obtiene la ubicación de forma recursiva 
            $ubicacion = $this->obtenerUbicacionPaquete($ubPaquete['0']['PaquetesUbicacionesfisica']['ubicacionesfisica_id']);
        }

        echo json_encode(array('resp' => $resp, 'ubicacion' => $ubicacion));
    }

    /**
     * Se obtiene la ubicación del paquete de forma recursiva
     */
    public function obtenerUbicacionPaquete($ubicacionId) {

        $this->loadModel('Ubicacionesfisica');

        $esPadre = false;
        $ubicacion = [];

        while (!$esPadre) {

            $ubicacion[] = $this->Ubicacionesfisica->obtenerUbicacion($ubicacionId)['0'];

            // Valida si la ubicación es padre sin padre
            if($ubicacion[count($ubicacion) - 1]['Ubicacionesfisica']['ubicacionesfisica_id'] != ""){
                $ubicacionId = $ubicacion[count($ubicacion) - 1]['Ubicacionesfisica']['ubicacionesfisica_id'];
            } else {
                $esPadre = true;
            }
        }

        return array_reverse($ubicacion);

    }

    /**
     * Retorna la ubicación completa del paquete de documentos en su disposición física
     */
    public function ubicacionPaquete() {
        $this->autoRender=false;
        $paqueteId = $this->request->data['idPaquete'];
     
        //se valida si existe ubicación para el paquete
        $ubPaquete = $this->PaquetesUbicacionesfisica->obtenerUbicacionPaqueteU($paqueteId);
        
        $ubicacion = [];
        
        if(!empty($ubPaquete)) {
           // se obtiene la ubicación de forma recursiva 
            $ubicacion = $this->obtenerUbicacionPaquete($ubPaquete['0']['PaquetesUbicacionesfisica']['ubicacionesfisica_id']);
        }
        
        echo json_encode($ubicacion);
    }
}         

