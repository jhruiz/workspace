<?php
App::uses('AppModel', 'Model');
/**
 * BandejasEstado Model
 *
 * @property Bandeja $Bandeja
 * @property Estado $Estado
 * @property Etiquetacambioestado $Etiquetacambioestado
 */
class BandejasEstado extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'id';

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
		'etiquetacambioestado_id' => array(
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
		),
		'Etiquetacambioestado' => array(
			'className' => 'Etiquetacambioestado',
			'foreignKey' => 'etiquetacambioestado_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
        
        public function infoBandejaEstados(){
            $arrInfoBandejasEstados = $this->find('all', array('recursive' => 0));
            return $arrInfoBandejasEstados;
        }
        
        public static function guardarBandejasEstados($bandejaInicial,$estadoSiguiente,$etiquetaCambio,$analisisCargas){
            
            $data = array();

            $bandejaEstado = new Bandejasestado();

            $data['analisiscargas'] = $analisisCargas;
            $data['bandeja_id'] = $bandejaInicial;
            $data['estado_id'] = $estadoSiguiente;
            $data['etiquetacambioestado_id'] = $etiquetaCambio;
            $data['etiquetacambioestado_id'] = $etiquetaCambio;

            if ($bandejaEstado->save($data)) {
               return true;
           }else{
               return false;
           }       
         }
         
         public function relacionSecuenciaExiste($idBandeja, $idEstado){
             $respuesta = false;
             $relacionSec = $this->find('first', array(
                 'conditions' => array(
                     'Bandejasestado.bandeja_id' => $idBandeja,
                     'Bandejasestado.estado_id' => $idEstado
                     ),
                 'recursive' => -1
                 ));
             
             if(count($relacionSec) > 0){
                 $respuesta = true;
             }
             return $respuesta;
         }
         
         public function obtenerEstadosPorBandeja($bandejaId){
             $arrEstadosBandejas = $this->find('all', array(
                 'conditions' => array(
                     'Bandejasestado.bandeja_id' => $bandejaId
                 ), 
                 'order' => 'Bandejasestado.etiquetacambioestado_id',
                 'recursive' => 0
             ));
             
             return $arrEstadosBandejas;
         }     
         
         
         public function secuenciaFlujo($idBandeja, $idEstado){
             $relacionSec = $this->find('first', array(
                 'conditions' => array(
                     'Bandejasestado.bandeja_id' => $idBandeja,
                     'Bandejasestado.estado_id' => $idEstado
                     ),
                 'recursive' => -1
                 ));
             return $relacionSec;
         }         
}
