<?php
App::uses('AppModel', 'Model');

class PaquetesUbicacionesfisica extends AppModel {
    
    /**
     * Se obtienen las ubicaciones fisicas hijas de un padre específico
     */
    public function obtenerUbicacionPaqueteU($paqueteId){
        $resp = $this->find('all', array('conditions' => array('PaquetesUbicacionesfisica.paquete_id' => $paqueteId), 'recursive' => -1));
        return $resp;
    }

    /**
     * Guarda la ubicacion seleccionada para el paquete
     */
    public function guardarUbicacion($idUbicacion, $idPaquete, $idUsuario, $fecha) {

        $datosPaqueteUbicacion['ubicacionesfisica_id'] = $idUbicacion;
        $datosPaqueteUbicacion['paquete_id'] = $idPaquete;
        $datosPaqueteUbicacion['usuario_id'] = $idUsuario;
        $datosPaqueteUbicacion['created'] = $fecha;  

        $objPaqueteUbicacion = new PaquetesUbicacionesfisica();
        if($objPaqueteUbicacion->save($datosPaqueteUbicacion)){
            return true;
        }else{
            return false;
        }  
    }

    /**
     * Se elimina la ubicación actual del paquete
     */
    public function eliminarUbicacionPaquete($id){
        $this->deleteAll(
            [
                'PaquetesUbicacionesfisica.id' => $id
            ],
            false
        );
    }   
}
