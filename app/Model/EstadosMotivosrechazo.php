<?php
App::uses('AppModel', 'Model');
/**
 * EstadosMotivosrechazo Model
 *
 * @property Estado $Estado
 * @property Motivosrechazo $Motivosrechazo
 */
class EstadosMotivosrechazo extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'estado_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'motivosrechazo_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
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
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Estado' => array(
			'className' => 'Estado',
			'foreignKey' => 'estado_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Motivosrechazo' => array(
			'className' => 'Motivosrechazo',
			'foreignKey' => 'motivosrechazo_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
        
        public function estadosMotivosRechazoEstId($estadoId){           
            
            $arrEstRech = $this->find(
                    'all', array(
                        'conditions' => array(
                            'EstadosMotivosrechazo.estado_id' => $estadoId), 
                        'recursive' => '0'));
            
            return $arrEstRech; 
        }      

}
