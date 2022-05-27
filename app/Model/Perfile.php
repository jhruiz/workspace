<?php
App::uses('AppModel', 'Model');
/**
 * Perfile Model
 *
 * @property Usuario $Usuario
 * @property Menu $Menu
 */
class Perfile extends AppModel {

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
                            'message' => 'El nombre de usuario ya esta en uso.'
                        )
		)
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Usuario' => array(
			'className' => 'Usuario',
			'foreignKey' => 'perfile_id',
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
 * hasAndBelongsToMany associations
 *
 * @var array
 */
	public $hasAndBelongsToMany = array(
		'Menu' => array(
			'className' => 'Menu',
			'joinTable' => 'menus_perfiles',
			'foreignKey' => 'perfile_id',
			'associationForeignKey' => 'menu_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
		)
	);
        
         public function beforeDelete($cascade=false){
            
            ///Se verifica si tiene registros asociados en las tablas con las que se relaciona, si 
            /// hay registros, no se permite eliminar 
            $countUsuario=$this->Usuario->find("count",array(
                'conditions' => array('Usuario.perfile_id' => $this->id)
            ));                        
            
            if($countUsuario==0){
                return true;
            }else{
                return false;
            }
            
        }
        
        public function obtenerListaPerfiles(){
            $arrListPerfiles = $this->find('list');
            return $arrListPerfiles;
        }
        
        public function obtenerDatosPerfiles(){
            $arrInfoPerfiles = $this->find('all', array('recursive' => -1));
            return $arrInfoPerfiles; 
        }
        

}
