<?php
App::uses('AppModel', 'Model');
/**
 * Etiquetacambioestado Model
 *
 * @property Bandejasestado $Bandejasestado
 */
class Etiquetacambioestado extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'descripcion';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'descripcion' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Bandejasestado' => array(
			'className' => 'Bandejasestado',
			'foreignKey' => 'etiquetacambioestado_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);
        
        public function ListaEtiquetasCE(){
            $arrListEtiqCE = $this->find('list');
            return $arrListEtiqCE;
            
        }

}
