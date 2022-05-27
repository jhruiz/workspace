<?php
App::uses('AppModel', 'Model');
/**
 * Diasfestivo Model
 *
 */
class Diasfestivo extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'descripcion';
        
        public function obtenerDiasFestivos($fechaInicial, $fechaFinal){
            $arrDiasFestivos = $this->find(
                    'count', array(
                        'conditions' => array(
                            'Diasfestivo.fecha BETWEEN ? AND ?' => array($fechaInicial, $fechaFinal)
                        ),
                        'fields' => array('Diasfestivo.id')
                        ));
            
            return $arrDiasFestivos;
        }

}
