<?php
App::uses('AppModel', 'Model');
/**
 * Trazabilidade Model
 *
 * @property Estado $Estado
 * @property Estadodestino $Estadodestino
 * @property Paquete $Paquete
 * @property Usuario $Usuario
 * @property Paquetesusuario $Paquetesusuario
 */
class Trazabilidade extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
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
		'estadodestino_id' => array(
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
		'indicador_actual' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'paquetesusuario_id' => array(
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
		'Estado' => array(
			'className' => 'Estado',
			'foreignKey' => 'estado_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Estadodestino' => array(
			'className' => 'Estado',
			'foreignKey' => 'estadodestino_id',
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
		)
	);

    public function consultarTrazasPorPaqueteId($paquete_id) {
        if (!empty($paquete_id)) {

            $trazas = $this->find("all", array(
                'conditions' => array('Trazabilidade.paquete_id' => $paquete_id),
                'order' => 'Trazabilidade.id ASC',
                'recursive' => 0
            ));
            
            return $trazas;
        }
    }

    public function consultarTrazasPorId($id) {
        if (!empty($id)) {
            $this->Behaviors->load('Containable');

            $trazas = $this->find("first", array(
                'contain' => array(
                    'Bandejaflujodestino.id' => array(
                        'Bandeja',
                        'Permisousuariobandeja' => array('Usuario.correoelectronico')),
                    'Bandejasflujo.id' => array('Bandeja'),
                    'Usuario.nombre',
                    'Observacione.valor',
                    'PaquetesUsuario' => array('Usuario')
                ),
                'conditions' => array('Trazabilidade.id' => $id),                
            ));

            return $trazas;
        }
    }
    
    /**
     * Retorna el ultimo registro de trazabilidad para un paquete
     * @param type $paquete_id: Id del paquete a consultar
     * @return type
     */
    public function consultarUltimaTrazaPaquete($paquete_id) {
        
        if (!empty($paquete_id)) {

            $trazas = $this->find("first", array(
                'conditions' => array(
                    'Trazabilidade.paquete_id' => $paquete_id),
                'order' => array('Trazabilidade.id' => 'DESC'),
                'limit' => '1',
                'recursive' => -1
            )); 
            
            return $trazas;
        }
    }
    
    /**
     * Retorna el primer registro de trazabilidad para un paquete
     * @param type $paquete_id: Id del paquete a consultar
     * @return type
     */
    public function consultarTrazaPreviaActual($paquete_id) {
        
        if (!empty($paquete_id)) {            
            $trazas = $this->find("first", array(                
                'conditions' => array('Trazabilidade.paquete_id' => $paquete_id),
                'order' => array('Trazabilidade.id' => 'DESC')
            ));
            
            return $trazas;
        }
    }
    
    public static function actualizarUltimaTraza($trazaId,$diasEspera){
        
            $datosTraza['id'] = $trazaId;
            $datosTraza['diaspromedio'] = $diasEspera;
            
            $objTraza = new Trazabilidade();
            if($objTraza->save($datosTraza)){
                $salida = true;
            }else{
                $salida = false;
            }    
    }
    
    public function guardarTrazabilidad($estadoId, $nuevoEstadoId, $paqueteId, $usuarioId, $paqUsrId){
        
        $salida = false;
        
        $datosTraza['estado_id'] = $estadoId;
        $datosTraza['estadodestino_id'] = $nuevoEstadoId;
        $datosTraza['paquete_id'] = $paqueteId;
        $datosTraza['usuario_id'] = $usuarioId; 
        $datosTraza['paquetesusuario_id'] = $paqUsrId;
        
        $objTraza = new Trazabilidade();
            if($objTraza->save($datosTraza)){
                $salida = true;             
            }          
        return $salida;
    }
	
    public function obtenerTrazabilidadPaquetes($arr_condiciones){
            $arr_join = array(); 
            
            array_push($arr_join, array(
                'table' => 'usuarios', 
                'alias' => 'U', 
                'type' => 'INNER',
                'conditions' => array(
                    'U.id=Trazabilidade.usuario_id'
                    )
                ));            
            
            array_push($arr_join, array(
                'table' => 'paquetes', 
                'alias' => 'P', 
                'type' => 'INNER',
                'conditions' => array(
                    'P.id=Trazabilidade.paquete_id'
                    )
                )); 
            
            array_push($arr_join, array(
                'table' => 'estados', 
                'alias' => 'E', 
                'type' => 'INNER',
                'conditions' => array(
                    'E.id=Trazabilidade.estado_id'
                    )
                ));   
            
            array_push($arr_join, array(
                'table' => 'oficinas', 
                'alias' => 'O', 
                'type' => 'INNER',
                'conditions' => array(
                    'O.id=P.oficina_id'
                    )
                ));             
            
            array_push($arr_join, array(
                'table' => 'ciudades', 
                'alias' => 'C', 
                'type' => 'INNER',
                'conditions' => array(
                    'C.id=O.ciudade_id'
                    )
                ));   

            array_push($arr_join, array(
                'table' => 'regionales', 
                'alias' => 'R', 
                'type' => 'INNER',
                'conditions' => array(
                    'R.id=C.regionale_id'
                    )
                ));                           
            $arrPaquetes = $this->find('all', array(
                'joins' => $arr_join,   
                'fields' => array(
                    'P.numerosolicitud',
                    'P.numerocredencial',
                    'E.descripcion',
                    'O.id',
                    'O.descripcion',
                    'U.nombre',
                    'C.id',
                    'C.descripcion',
                    'R.id',
                    'R.descripcion',
                    'Trazabilidade.created',
                    'Trazabilidade.diaspromedio'
                    ),                
                'conditions' => array(
                    $arr_condiciones
                    ),
                'recursive' => '-1'                
                ));            
            
            return $arrPaquetes;          
    }	
	

	    public function obtnerInfoTrazabilidad($arr_condiciones){

            $arr_join = array(); 

            array_push($arr_join, array(
                'table' => 'paquetes', 
                'alias' => 'P', 
                'type' => 'INNER',
                'conditions' => array(
                    'P.id=Trazabilidade.paquete_id',
                    )
                )); 
            
            array_push($arr_join, array(
                'table' => 'estados', 
                'alias' => 'E', 
                'type' => 'INNER',
                'conditions' => array(
                    'E.id=P.estado_id'
                    )
                )); 
            
            array_push($arr_join, array(
                'table' => 'usuarios', 
                'alias' => 'U', 
                'type' => 'INNER',
                'conditions' => array(
                    'U.id=Trazabilidade.usuario_id'
                    )
                ));  
            
            array_push($arr_join, array(
                'table' => 'oficinas', 
                'alias' => 'O', 
                'type' => 'INNER',
                'conditions' => array(
                    'O.id=P.oficina_id'
                    )
                ));             
            
            $arrPaquetes = $this->find('all', array(
                'joins' => $arr_join,   
                'fields' => array(                    
                    'P.numerocredencial',
                    'P.numerosolicitud',
                    'E.descripcion',
                    'O.descripcion',
                    'U.nombre',
                    'Trazabilidade.created',
                    'Trazabilidade.diaspromedio'
                    ),   
                'conditions' => array(
                    $arr_condiciones
                    ),
                'recursive' => '-1',
                'limit' => '25000'
                ));            
            
            return $arrPaquetes;         
    }
    
    public function obtnerJoinsTraza(){
            $arr_join = array(); 

            array_push($arr_join, array(
                'table' => 'paquetes', 
                'alias' => 'P', 
                'type' => 'INNER',
                'conditions' => array(
                    'P.id=Trazabilidade.paquete_id',
                    )
                )); 
            
            array_push($arr_join, array(
                'table' => 'estados', 
                'alias' => 'E', 
                'type' => 'INNER',
                'conditions' => array(
                    'E.id=P.estado_id'
                    )
                )); 
            
            array_push($arr_join, array(
                'table' => 'usuarios', 
                'alias' => 'U', 
                'type' => 'INNER',
                'conditions' => array(
                    'U.id=Trazabilidade.usuario_id'
                    )
                ));  
            
            array_push($arr_join, array(
                'table' => 'oficinas', 
                'alias' => 'O', 
                'type' => 'INNER',
                'conditions' => array(
                    'O.id=P.oficina_id'
                    )
                ));                
            
            return $arr_join;          
    }
    
    
}
