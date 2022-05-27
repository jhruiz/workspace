<?php
App::uses('AppModel', 'Model');
/**
 * Eliminarmulti Model
 *
 * @property Paquete $Paquete
 */
class Eliminarmulti extends AppModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'eliminarmulti';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'paquete_id' => array(
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
		'Paquete' => array(
			'className' => 'Paquete',
			'foreignKey' => 'paquete_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
        
        public static function registroEliminarMulti($paqueteId){
            
            $data=array();                        
                
            $eliminarMulti=new Eliminarmulti();                        
            
            $data['paquete_id'] = $paqueteId;
            $data['estado'] = 't';
            
            if($eliminarMulti->save($data)){
                return true;
            }else{
                return false;
            }            
        }
}
