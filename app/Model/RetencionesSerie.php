<?php
App::uses('AppModel', 'Model');

class RetencionesSerie extends AppModel {

    // obtiene el registro de retencion de una serie específica
    public function obtenerRetencionPorDoc($serie_id) {
        $resp = $this->find('all', array('conditions' => array('RetencionesSerie.serie_id' => $serie_id)));
        return $resp;
    }

    // se obtiene el registro de retención por id
    public function obtenerRetencionPorId($id) {
        $resp = $this->find('first', array('conditions' => array('RetencionesSerie.id' => $id)));
        return $resp;
    }

}
