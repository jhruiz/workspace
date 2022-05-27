<?php
App::uses('AppModel', 'Model');
/**
 * MotivostrasladosPaquete Model
 *
 * @property Motivostraslado $Motivostraslado
 * @property Paquete $Paquete
 * @property Usuario $Usuario
 * @property Usuarionuevo $Usuarionuevo
 */
class MotivostrasladosPaquete extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'created';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'motivostraslado_id' => array(
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
		'usuario_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'usuarionuevo_id' => array(
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
		'Motivostraslado' => array(
			'className' => 'Motivostraslado',
			'foreignKey' => 'motivostraslado_id',
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
		),
		'Usuario' => array(
			'className' => 'Usuario',
			'foreignKey' => 'usuario_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Usuarionuevo' => array(
			'className' => 'Usuarionuevo',
			'foreignKey' => 'usuarionuevo_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
        
        public function crearTrasladoOficio($motivoTrasladoId, $paqueteId, $usuarioActualId, $usuarioNuevoId){
            $datosTraslado = array();
            $datosTraslado['motivostraslado_id'] = $motivoTrasladoId;
            $datosTraslado['paquete_id'] = $paqueteId;            
            $datosTraslado['usuario_id'] = $usuarioActualId;
            $datosTraslado['usuarionuevo_id'] = $usuarioNuevoId;
            
            $objMotivosTraslado = new MotivostrasladosPaquete();
            if($objMotivosTraslado->save($datosTraslado)){
                $salida = true;
            }else{
                $salida = false;
            }                        
        }        
        
        public function obtenerMotivosTrasladoPaquete($condiciones, $motivoId, $nombreUsuario){
            $condMotivo = array();
            if(empty($motivoId)){
                $condMotivo = "";
            }else{
                array_push($condMotivo, array('MotivostrasladosPaquete.motivostraslado_id' => $motivoId));
            }
            
            $condUsuario = array();
            if(empty($nombreUsuario)){
                $condUsuario = "";
            }else{
                array_push($condUsuario, array('U.nombre like ' => '%' . $nombreUsuario . '%'));
            }
            
            $arr_join = array(); 

            array_push($arr_join, array(
                'table' => 'motivostraslados', 
                'alias' => 'MT', 
                'type' => 'INNER',
                'conditions' => array(
                    'MT.id=MotivostrasladosPaquete.motivostraslado_id')                
            ));            
			
            array_push($arr_join, array(
                'table' => 'paquetes', 
                'alias' => 'PQ', 
                'type' => 'INNER',
                'conditions' => array(
                    'PQ.id=MotivostrasladosPaquete.paquete_id',
                    $condiciones)                
            ));  
            
            array_push($arr_join, array(
                'table' => 'usuarios', 
                'alias' => 'USU', 
                'type' => 'INNER',
                'conditions' => array(
                    'USU.id=MotivostrasladosPaquete.usuario_id',
                    $condUsuario)                
            ));              
            
            array_push($arr_join, array(
                'table' => 'usuarios', 
                'alias' => 'U', 
                'type' => 'INNER',
                'conditions' => array(
                    'U.id=MotivostrasladosPaquete.usuarionuevo_id')                
            ));    
            
            array_push($arr_join, array(
                'table' => 'oficinas', 
                'alias' => 'O', 
                'type' => 'INNER',
                'conditions' => array(
                    'O.id=PQ.oficina_id')                
            ));     

            array_push($arr_join, array(
                'table' => 'ciudades', 
                'alias' => 'C', 
                'type' => 'INNER',
                'conditions' => array(
                    'C.id=O.ciudade_id')                
            ));               

            array_push($arr_join, array(
                'table' => 'regionales', 
                'alias' => 'R', 
                'type' => 'INNER',
                'conditions' => array(
                    'R.id=C.regionale_id')                
            ));               
            
            $arrTrasladoPaquetes = $this->find('all', array(
                'joins' => $arr_join,   
                'fields' => array(
                    'PQ.fechacreacion',
                    'PQ.numerocredencial',
                    'PQ.numerosolicitud',
                    'USU.nombre', 
                    'MotivostrasladosPaquete.created',
                    'U.nombre',                       
                    'MT.descripcion',
                    'R.descripcion',
                    'C.descripcion',
                    'O.descripcion'
                    ),                
                'conditions' => array(
                    $condMotivo
                    ),
                'recursive' => '-1'                
                ));
            
            return $arrTrasladoPaquetes;            
        }
}
