<?php
App::uses('AppModel', 'Model');
/**
 * Motivostraslado Model
 *
 * @property Paquete $Paquete
 */
class Motivostraslado extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'descripcion';


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
	public $hasAndBelongsToMany = array(
		'Paquete' => array(
			'className' => 'Paquete',
			'joinTable' => 'motivostraslados_paquetes',
			'foreignKey' => 'motivostraslado_id',
			'associationForeignKey' => 'paquete_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
		)
	);
        
        public function obtenerMotivosTraslado(){
            $arrListaTraslado = array();
            $arrListaTraslado = $this->find('list', array('order' => array('Motivostraslado.descripcion' => 'ASC')));
            return $arrListaTraslado;
        }                

}
