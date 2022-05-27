<?php
App::uses('AppModel', 'Model');
/**
 * Ciudade Model
 *
 * @property Regionale $Regionale
 * @property Estadoregistro $Estadoregistro
 * @property Oficina $Oficina
 */
class Ciudade extends AppModel {

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
			'notempty' => array(
				'rule' => array('notempty'),
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
                        'message' => 'El nombre ya esta en uso.'
                    )
		),
		'regionale_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
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
		'Regionale' => array(
			'className' => 'Regionale',
			'foreignKey' => 'regionale_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
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
		'Oficina' => array(
			'className' => 'Oficina',
			'foreignKey' => 'ciudade_id',
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
        
        public function obtenerCiudadesPorId($id){
            
            $arrCiudades = $this->find('first', array('conditions' => array('Ciudade.id' => $id), 'recursive' => -1));
            return $arrCiudades;
        }
        
        public function obtenerListaCiudadesPorRegion($regionalId){
            $arrCiudades = $this->find('list', array('conditions' => array('Ciudade.estadoregistro_id' => 1, 'Ciudade.regionale_id' => $regionalId)));
            return $arrCiudades;
        }
        
        public function obtenerInfoCiudad($ciudadId){
            $arrCiudad = $this->find('first', array('conditions' => array('Ciudade.id' => $ciudadId), 'recursive' => 0));
            return $arrCiudad;
        }
        
        public function obtenerListaCiudades(){
            $arrCiudades = $this->find('list', array('conditions' => array('Ciudade.estadoregistro_id' => 1),'order' => array('Ciudade.descripcion' => 'asc')));
            return $arrCiudades;
        }     
        
        public function obtenerInfoCiudadesPorRegion($regionalId){
            $arrCiudades = $this->find('all', array('conditions' => array('Ciudade.estadoregistro_id' => 1, 'Ciudade.regionale_id' => $regionalId), 'recursive' => '-1'));
            return $arrCiudades;            
        }
}
