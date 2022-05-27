<?php
App::uses('AppModel', 'Model');
/**
 * Observacione Model
 *
 * @property Paquete $Paquete
 */
class Observacione extends AppModel {

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
        
        
        /**
         * Guarda las observaciones de un paquete
         * @param integer $paqueteId
         * @return array Observaciones del paquete
         * @author jaiberruiz <jaiberruiz@datecsa.com>
         */        
        public static function saveObservaciones($obsId, $paqueteId, $obsGeneral){
            $data=array();                                        
            
            if($obsId != ""){
                $data['id'] = $obsId;
            }
            
            $data['descripcion'] = $obsGeneral;
            $data['paquete_id']=$paqueteId;
            
            
            $observacion = new Observacione();                         
            if($observacion->save($data)){
                return true;
            }else{
                return false;
            }
        }
        
        /**
         * Retorna las observaciones de un paquete
         * @param integer $paqueteId
         * @return array Observaciones del paquete
         * @author jaiberruiz <jaiberruiz@datecsa.com>
         */
        public function obtenerObservacionesPorPaqueteId($paqueteId){
            $observaciones = $this->find("all", array(
                'conditions' => array(
                    'paquete_id' => $paqueteId
                ),
                'order' => array('id' => 'ASC'),
                'recursive' => -1
            ));
            return $observaciones;
        }        
}
