<?php
App::uses('AppModel', 'Model');
/**
 * Regionale Model
 *
 * @property Estadoregistro $Estadoregistro
 * @property Ciudade $Ciudade
 * @property Usuario $Usuario
 */
class Regionale extends AppModel {

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
		'id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'descripcion' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
                        'unique' => array(
                            'rule' => 'isUnique',
                            'message' => 'El nombre de usuario ya esta en uso.'
                        )                    
		),
		'estadoregistro_id' => array(
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
		'Estadoregistro' => array(
			'className' => 'Estadoregistro',
			'foreignKey' => 'estadoregistro_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Ciudade' => array(
			'className' => 'Ciudade',
			'foreignKey' => 'regionale_id',
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
        
        /**
         * Funcion que retorna en una lista todas las regionales registradas en el sistema en orden alfabetico ascendente.
         * @return type
         */
        public function obtenerTodasRegionales(){
                        
            $regionales=$this->find('list', array(
                'conditions' => array('Regionale.estadoregistro_id' => 1),
                'order' => array('Regionale.descripcion' => 'asc'))
            );
            
            return $regionales;            
        }       
        
        public function obtenerRegionalPorId($id){
            
            $arrRegional = $this->find('first', array('conditions' => array('Regionale.id' => $id), 'recursive' => -1));
            return $arrRegional;
        }        

}
