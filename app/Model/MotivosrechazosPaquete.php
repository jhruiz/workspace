<?php
App::uses('AppModel', 'Model');
/**
 * MotivosrechazosPaquete Model
 *
 * @property Motivosrechazo $Motivosrechazo
 * @property Paquete $Paquete
 */
class MotivosrechazosPaquete extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
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
		'Motivosrechazo' => array(
			'className' => 'Motivosrechazo',
			'foreignKey' => 'motivosrechazo_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Paquete' => array(
			'className' => 'Paquete',
			'foreignKey' => 'paquete_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

        public function guardarEstadoMotivoRechazo($motivoId, $paqueteId){            
            $data=array();                                        
            $motivoPaquete=new MotivosrechazosPaquete();                        
            
            $data['motivosrechazo_id']=$motivoId;
            $data['paquete_id']=$paqueteId;
            
            if($motivoPaquete->save($data)){
                return true;
            }else{
                return false;
            }                        
        }        
        
        public function obtenerUltimoMotivoPaquete($paqueteId){
            $arrMotivoPaquete = $this->find(
                    'first', array(
                        'conditions' => array(
                            'MotivosrechazosPaquete.paquete_id' => $paqueteId), 
                        'order' => array(
                            'MotivosrechazosPaquete.id' => 'DESC'), 
                        'recursive' => '-1'));
            
            return $arrMotivoPaquete;                    
            
        }
}
 