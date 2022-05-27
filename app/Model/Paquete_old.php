<?php
App::uses('AppModel', 'Model');
/**
 * Paquete Model
 *
 * @property Estado $Estado
 * @property Oficina $Oficina
 * @property Observacione $Observacione
 * @property Trazabilidade $Trazabilidade
 * @property Eliminarmulti $Eliminarmulti
 * @property Usuario $Usuario
 * @property Documento $Documento
 */
class Paquete extends AppModel {

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
		'oficina_id' => array(
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
		'Oficina' => array(
			'className' => 'Oficina',
			'foreignKey' => 'oficina_id',
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
		'Observacione' => array(
			'className' => 'Observacione',
			'foreignKey' => 'paquete_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Trazabilidade' => array(
			'className' => 'Trazabilidade',
			'foreignKey' => 'paquete_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Mantenimientoservidore' => array(
			'className' => 'Mantenimientoservidore',
			'foreignKey' => 'paquete_id',
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
		'Usuario' => array(
			'className' => 'Usuario',
			'joinTable' => 'paquetes_usuarios',
			'foreignKey' => 'paquete_id',
			'associationForeignKey' => 'usuario_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
		),
		'Documento' => array(
			'className' => 'Documento',
			'joinTable' => 'documentos_paquetes',
			'foreignKey' => 'paquete_id',
			'associationForeignKey' => 'documento_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
		)
	);
        
        public function obtenerListadoPaquetes($estadoId, $usaurioId, $arrOficinas, $permisoUsuarioBandeja){
            
            $this->Behaviors->load('Containable');
            
            $arr_join = array(); 
            if($permisoUsuarioBandeja == 1){
                array_push($arr_join, array(
                    'table' => 'paquetes_usuarios', 
                    'alias' => 'PU', 
                    'type' => 'INNER',
                    'conditions' => array(
                        'AND' => array(
                            'PU.paquete_id=Paquete.id',
                            'PU.usuario_id' => $usaurioId,
                            'PU.asignado IS TRUE')
                        )
                    ));
            }
            
            $listadoPaquetes = array(
                'joins' => $arr_join,               
                'conditions' => array(
                    'Paquete.estado_id' => $estadoId,
                    'Paquete.oficina_id' => $arrOficinas,
                    ),               
                'order' => array('Paquete.fecha_creacion' => 'ASC'),
                'limit' => 10,
                'paramType' => 'querystring',
                'recursive' => 0
                );                                 

            return $listadoPaquetes;            
        }
        
        public static function actualizarDatosPaquete($paqueteId, $nuevoNumeroOficio, $nuevoEstadoId){
            $datosPaquete['id'] = $paqueteId;
            $datosPaquete['numero_oficio'] = $nuevoNumeroOficio;
            $datosPaquete['estado_id'] = $nuevoEstadoId;

            $objPaquete = new Paquete();
            if ($objPaquete->save($datosPaquete)) {                
                $salida = true;
            } else {
                $salida = false;
            }            
        }
        
        public static function actualizarFechaRecepcionOficio($paqueteId, $fechaRecepcion){
            $datosPaquete['id'] = $paqueteId;
            $datosPaquete['fecha_recepcion_embargo'] = $fechaRecepcion;

            $objPaquete = new Paquete();
            if ($objPaquete->save($datosPaquete)) {                
                $salida = true;
            } else {
                $salida = false;
            }            
        }
        
        public function obtenerInfoPaquete($paqueteId){
            $arrPaquete = $this->find('first', array('conditions' => array('Paquete.id' => $paqueteId), 'recursive' => 0));
            return $arrPaquete;
        }
        
        public static function actualizarOficioPorAdmin($paqueteId, $nuevoNumeroOficio){
            
            $salida = false;
            
            $datosPaquete['id'] = $paqueteId;
            $datosPaquete['numero_oficio'] = $nuevoNumeroOficio;

            $objPaquete = new Paquete();
            if ($objPaquete->save($datosPaquete)) {                
                $salida = true;
            } else {
                $salida = false;
            }   
            
            return $salida;
        }    
        
        public static function actualizarEstadoPaqueteAdmin($paqueteId, $nuevoEstadoId){
            $datosPaquete['id'] = $paqueteId;
            $datosPaquete['estado_id'] = $nuevoEstadoId;

            $objPaquete = new Paquete();
            if ($objPaquete->save($datosPaquete)) {                
                $salida = true;
            } else {
                $salida = false;
            }            
        }   
        
        public function obtenerPaqueteCargueArchivos($numOficio, $oficinaId){
            $arrPaquetes = $this->find('all', array('conditions' => array('Paquete.numero_oficio' => $numOficio, 'Paquete.oficina_id' => $oficinaId), 'recursive' => 0));
            return $arrPaquetes;
        }          
        
        public function obtenerSolicitudesCargue($credencial, $usuarioId){   
            $arr_join = array(); 
            
            array_push($arr_join, array(
                'table' => 'paquetes_usuarios', 
                'alias' => 'PU', 
                'type' => 'INNER',
                'conditions' => array(
                    'PU.paquete_id=Paquete.id'
                    )
                ));
            
            array_push($arr_join, array(
                'table' => 'estados', 
                'alias' => 'E', 
                'type' => 'INNER',
                'conditions' => array(
                    'E.id=Paquete.estado_id'
                    )
                )); 
            
            array_push($arr_join, array(
                'table' => 'oficinas', 
                'alias' => 'O', 
                'type' => 'INNER',
                'conditions' => array(
                    'O.id=Paquete.oficina_id'
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
                    'Paquete.*',
                    'E.descripcion',
                    'O.id',
                    'O.descripcion',
                    'C.id',
                    'C.descripcion',
                    'R.id',
                    'R.descripcion'
                    ),                
                'conditions' => array(
                    'Paquete.numerocredencial' => $credencial,
                    'PU.asignado' => '1',
                    'PU.usuario_id' => $usuarioId,
                    'E.estadofinal' => '0',
                    'E.adjuntararchivos' => '1'
                    ),
                'recursive' => '-1'                
                ));            
            
            return $arrPaquetes;
        }
        
        public static function crearPaquete($numeroCredencial, $oficinaId, $estadoId){
            $datosPaquete['numerocredencial'] = $numeroCredencial;
            $datosPaquete['fechacreacion'] = date('Y-m-d H:i:s');
            $datosPaquete['oficina_id'] = $oficinaId;
            $datosPaquete['estado_id'] = $estadoId;            
            
            $objPaquete = new Paquete();
            if($objPaquete->save($datosPaquete)){
                return $objPaquete->id;
            }else{
                return 0;
            }            
        }
        
        public function actualizarCredencial($paqueteId, $credencial){
            $datosPaquete['id'] = $paqueteId;
            $datosPaquete['numerocredencial'] = $credencial;

            $objPaquete = new Paquete();
            if ($objPaquete->save($datosPaquete)) {                
                $salida = true;
            } else {
                $salida = false;
            } 
            return $salida;
        }
        
        public function obtenerPaquetesEstadoPaquetes($arr_condiciones){
            
            $arr_join = array(); 
            
            array_push($arr_join, array(
                'table' => 'trazabilidades', 
                'alias' => 'T', 
                'type' => 'INNER',
                'conditions' => array(
                    'T.paquete_id=Paquete.id',
                    )
                ));            
            
            array_push($arr_join, array(
                'table' => 'estados', 
                'alias' => 'E', 
                'type' => 'INNER',
                'conditions' => array(
                    'E.id=Paquete.estado_id'
                    )
                )); 
            
            array_push($arr_join, array(
                'table' => 'paquetes_usuarios',
                'alias' => 'PU',
                'type' => 'INNER',
                'conditions' => array(
                    'PU.id=T.paquetesusuario_id'
                ) 
            ));
            
            array_push($arr_join, array(
                'table' => 'usuarios', 
                'alias' => 'U', 
                'type' => 'INNER',
                'conditions' => array(
                    'U.id=PU.usuario_id'
                    )
                ));             
            
            array_push($arr_join, array(
                'table' => 'oficinas', 
                'alias' => 'O', 
                'type' => 'INNER',
                'conditions' => array(
                    'O.id=Paquete.oficina_id'
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
                    'Paquete.*',
                    'E.descripcion',
                    'O.id',
                    'O.descripcion',
                    'U.nombre',
                    'C.id',
                    'C.descripcion',
                    'R.id',
                    'R.descripcion',
                    ),                
                'conditions' => array(
                    $arr_condiciones,
                    'Paquete.estado_id=T.estadodestino_id'
                    ),
                'order' => 'Paquete.id',
                'recursive' => '-1'                
                ));            
            
            return $arrPaquetes;            
        }

        
}