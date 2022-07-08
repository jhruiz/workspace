<?php
App::uses('AppModel', 'Model');

class Unidadesmedida extends AppModel {
    
    // se obtiene el listado de medidas
    public function obtenerUnidadesMedida(){
        $arrUnidades = $this->find('all');
        return $arrUnidades;
    }
}
