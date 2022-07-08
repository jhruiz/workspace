<?php
App::uses('AppModel', 'Model');

class Acciondisposicione extends AppModel {
    
    // se obtiene el listado de medidas
    public function obtenerAccionDisposicion(){
        $resp = $this->find('all');
        return $resp;
    }
}
