<?php
App::uses('AppModel', 'Model');
/**
 * Permisobandeja Model
 *
 * @property Permisousuariobandeja $Permisousuariobandeja
 */
class Permisobandeja extends AppModel {

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
		'nombre' => array(
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
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Permisousuariobandeja' => array(
			'className' => 'Permisousuariobandeja',
			'foreignKey' => 'permisobandeja_id',
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
        
        
           ///Dado el tipo de permiso de bandeja en un string, se retorna el id de la base de datos
        //correspondiente al tipo de permiso de bandeja en la tabla permisobandejas
        public function obtenerIdPermisoBandeja($tipoPermiso){
            
            $idPermiso=0;
            
            switch($tipoPermiso){
                case "gestionar": $idPermiso = 1; ;break; 
                case "consultar": $idPermiso = 2; ;break;                
            }
            
            return $idPermiso;
        }
        
        public function obtenerListaPermisoBandeja(){
            $arrListaPermisoBandeja = $this->find('list');
            return $arrListaPermisoBandeja;
        }
        

}
