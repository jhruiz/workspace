<?php
App::uses('AppModel', 'Model');

class Ubicacionesfisica extends AppModel {
    
    /**
     * Se obtienen las ubicaciones fisicas hijas de un padre específico
     */
    public function obtenerUbicacionesFisicarHijas($id){
        $resp = $this->find('all', array('conditions' => array('Ubicacionesfisica.ubicacionesfisica_id' => $id), 'recursive' => -1));
        return $resp;
    }

    /**
     * Se obtiene una ubicación por su id
     */
    public function obtenerUbicacion($id) {
        $resp = $this->find('all', array('conditions' => array('Ubicacionesfisica.id' => $id), 'recursive' => -1));
        return $resp;
    }

    /**
     * Obtiene las ubicaciones padre
     */
    public function obtenerUbicacionesPadre(){
        $resp = $this->find('all', array('conditions' => array('Ubicacionesfisica.ubicacionesfisica_id is null'), 'recursive' => -1));
        return $resp;
    }
}
