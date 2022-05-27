<?php
App::uses('AppModel', 'Model');
/**
 * Relacionbandejasestado Model
 *
 * @property Bandeja $Bandeja
 * @property Estado $Estado
 */
class Relacionbandejasestado extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'bandeja_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
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
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Bandeja' => array(
			'className' => 'Bandeja',
			'foreignKey' => 'bandeja_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Estado' => array(
			'className' => 'Estado',
			'foreignKey' => 'estado_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
        
        
        //Retorna la información completa de los estados y las bandejas que se encuentren relacionadas
        public function infoBandejasEstados(){                         
            $arrInfoBandejasEstados = $this->find('all', array(             
                'paramType' => 'querystring',
                'recursive' => 0
                ));                                 

            return $arrInfoBandejasEstados;                          
        }
        
        public function obtenerInfoRelacionBE($estadoId){
            $arrInfoRelacion = $this->find('first', array('conditions' => array('Relacionbandejasestado.estado_id' => $estadoId), 'recursive' => '-1'));
            return $arrInfoRelacion;
        }        
        
        public function obtenerInfoRelacionBEPorBandeja($bandejaId){
            $arrInfoRelacion = $this->find('all', array('conditions' => array('Relacionbandejasestado.bandeja_id' => $bandejaId), 'recursive' => '-1'));
            return $arrInfoRelacion;
        }           
}
