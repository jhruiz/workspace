<?php
App::uses('AppModel', 'Model');
/**
 * Motivosrechazo Model
 *
 * @property Paquete $Paquete
 * @property Estado $Estado
 */
class Motivosrechazo extends AppModel {

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
			'joinTable' => 'motivosrechazos_paquetes',
			'foreignKey' => 'motivosrechazo_id',
			'associationForeignKey' => 'paquete_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
		),
		'Estado' => array(
			'className' => 'Estado',
			'joinTable' => 'estados_motivosrechazos',
			'foreignKey' => 'motivosrechazo_id',
			'associationForeignKey' => 'estado_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
		)
	);
        
        public function obtenerMotivoPorId($motivoId){
            $arrMotivo = $this->find('first', array('conditions' => array('Motivosrechazo.id' => $motivoId), 'recursive' => '-1'));
            return $arrMotivo;
        }        
              

}
