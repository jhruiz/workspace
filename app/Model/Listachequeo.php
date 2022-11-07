<?php
App::uses('AppModel', 'Model');

class Listachequeo extends AppModel {


    /**
     * Obtiene las listas de chequeos
     */
    public function obtenerListasChequeo(){
        $arrListCheck = $this->find('all', array(
            'recursive' => 0)
        );

        return $arrListCheck;
    }

}
