<?php
App::uses('AppModel', 'Model');
/**
 * PaquetesUsuario Model
 *
 * @property Paquete $Paquete
 * @property Usuario $Usuario
 */
class PaquetesUsuario extends AppModel {

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
		'asignado' => array(
			'boolean' => array(
				'rule' => array('boolean'),
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
		),
		'Usuario' => array(
			'className' => 'Usuario',
			'foreignKey' => 'usuario_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
        
        public function obtenerFechaAsigPaquete($usuarioId){
            $paqAsig = $this->find('first', array(
                'fields' => 'created',
                'conditions' => array('PaquetesUsuario.usuario_id' => $usuarioId),
                'order' => array('PaquetesUsuario.id' => 'DESC'),
                'recursive' => -1
                ));
            if(count($paqAsig) > 0){
                $fechaAsig = $paqAsig['PaquetesUsuario']['created'];               
            }else{
                $fechaAsig = null;
            }
            return $fechaAsig;
        }
        
        public function obtenerPaqueteUsuarioPaqId($paqueteId){
            $paqAsig = $this->find('first', array(
                'fields' => 'PaquetesUsuario.id',
                'conditions' => array(
                    'PaquetesUsuario.paquete_id' => $paqueteId, 
                    'PaquetesUsuario.asignado' => '1'
                    ),
                'recursive' => -1
                ));
            if(count($paqAsig) > 0){
                $paqUsuId = $paqAsig['PaquetesUsuario']['id'];               
            }else{
                $paqUsuId = null;
            }
            return $paqUsuId;
        }

        public function retirarPaqueteUsuario($paqUsrId){
            $salida = false;
            $datosPaqUsr['id'] = $paqUsrId;
            $datosPaqUsr['asignado'] = '0';
            
            $objPaqUsr = new PaquetesUsuario();
            if ($objPaqUsr->save($datosPaqUsr)) {                 
                $salida = true;
            } 
            
            return $salida;
        }
        
        public static function asignarPaqueteUsuario($usuarioId, $paqueteId, $asignar){
            $datosPaqUsr['paquete_id'] = $paqueteId;
            $datosPaqUsr['usuario_id'] = $usuarioId;
            $datosPaqUsr['asignado'] = $asignar;            

            $objPaqUsr = new PaquetesUsuario();
            if($objPaqUsr->save($datosPaqUsr)){
                return $objPaqUsr->id;
            }else{
                return 0;
            }
        }
        
        public function obtenerPaquetesUsuario(){
            $this->Behaviors->load('Containable');

            
            $listadoPaquetes = array(
                'conditions' => array(
                    'PaquetesUsuario.asignado' => '1',
                    ),               
                'order' => array('Paquete.fecha_creacion' => 'ASC'),
                'limit' => 20,
                'paramType' => 'querystring',
                'recursive' => 0
                );                                 

            return $listadoPaquetes;               
        }
        
        public function obtenerPaquetesUsuarioAsignado($paqueteId){
            $paqAsig = $this->find('first', array(
                'conditions' => array(
                    'PaquetesUsuario.paquete_id' => $paqueteId, 
                    'PaquetesUsuario.asignado' => '1'
                    ),
                'recursive' => 0
                ));
            
            return $paqAsig;            
        }
        
        public function obtenerPaquetesUsuarioPorId($paqUsrId){
            $arrPaqUsr = $this->find('first', array('conditions' => array('PaquetesUsuario.id' => $paqUsrId), 'recursive' => -1));
            return $arrPaqUsr;
        }
        
        public function usuarioPaquetesUsuarioPorId($paqUsrId){
            $arrPaqUsr = $this->find('first', array('conditions' => array('PaquetesUsuario.id' => $paqUsrId), 'recursive' => 0));
            if(count($arrPaqUsr) > 0){
                $usuario = $arrPaqUsr['Usuario']['nombre'];
            } else{
                $usuario = "";
            }
            return $usuario;
        }
        
        public function obtenerPaquetesPorUsuarioId($usuarioId){
            $arr_join = array(); 
            
            array_push($arr_join, array(
                'table' => 'paquetes', 
                'alias' => 'PQ', 
                'type' => 'INNER',
                'conditions' => array(
                    'AND' => array(
                        'PQ.id=PaquetesUsuario.paquete_id')
                )
            ));
            
            array_push($arr_join, array(
                'table' => 'oficinas', 
                'alias' => 'OFI', 
                'type' => 'INNER',
                'conditions' => array(
                    'OFI.id=PQ.oficina_id')
            ));            
                            
            array_push($arr_join, array(
                'table' => 'estados',
                'alias' => 'EST',
                'type' => 'INNER',
                'conditions' => array(
                    'AND' => array(
                        'EST.id=PQ.estado_id')
                )
            ));
            
            array_push($arr_join, array(
                'table' => 'trazabilidades',
                'alias' => 'TZ',
                'type' => 'INNER',
                'conditions' => array(
                    'AND' => array(
                        'TZ.paquetesusuario_id=PaquetesUsuario.id',
                        'TZ.diaspromedio is null')
                )
            ));                          
                            
            $listadoPaquetesUsuario = $this->find('all', array(
                'joins' => $arr_join,   
                'fields' => array(
                    'PQ.numerosolicitud',
                    'PQ.numerocredencial',
					'PQ.fechacreacion',
                    'EST.descripcion',
                    'EST.trasladopaquete',
                    'TZ.created',
                    'OFI.descripcion',
                    'PaquetesUsuario.*'
                    ),
                'conditions' => array(
                    'PaquetesUsuario.usuario_id' => $usuarioId,
                    'PaquetesUsuario.asignado' => '1'), 
                'order' => 'PQ.estado_id',
                'paramType' => 'querystring',
                'recursive' => 0
                ));                                 

            return $listadoPaquetesUsuario;              
        }
        
        public function reasignarPaqueteUsuario($paqUsrId, $usuarioId){
            $datosPaqUsr['id'] = $paqUsrId;
            $datosPaqUsr['usuario_id'] = $usuarioId;          

            $objPaqUsr = new PaquetesUsuario();
            if($objPaqUsr->save($datosPaqUsr)){
                return $objPaqUsr->id;
            }else{
                return 0;
            }                        
        }

        public function obtenerUsuarioGestionPq($paqueteId){         

            $arrPaqUsr = $this->find('all', array(
                'conditions' => array(
                    'PaquetesUsuario.paquete_id' => $paqueteId,
                    'PaquetesUsuario.asignado' => '0'
                    ), 
                'order' => 'PaquetesUsuario.id ASC', 
                'recursive' => '-1'));
            
            return $arrPaqUsr;
        }
        
        public function activarPaqueteUsuario($paqUsrId){
            $salida = false;
            $datosPaqUsr['id'] = $paqUsrId;
            $datosPaqUsr['asignado'] = '1';
            
            $objPaqUsr = new PaquetesUsuario();
            if ($objPaqUsr->save($datosPaqUsr)) {                 
                $salida = true;
            } 
            
            return $salida;            
        }
        
        /**
         * obtiene los paquetes asignados a un usuario por estado
         */
        public function contadorPaquetesPorUsuarioId($usuarioId) {
            $arr_join = array(); 

            array_push($arr_join, array(
                'table' => 'paquetes',
                'alias' => 'P',
                'type' => 'INNER',
                'conditions' => array(
                    'P.id = PaquetesUsuario.paquete_id')
            ));                         

            array_push($arr_join, array(
                'table' => 'estados',
                'alias' => 'E',
                'type' => 'INNER',
                'conditions' => array(
                    'E.id = P.estado_id')
            ));                          
                            
            $PQUsuario = $this->find('all', array(
                'joins' => $arr_join,   
                'fields' => array(
                    'COUNT(P.estado_id) AS cantidad',
                    'E.descripcion'
                    ),
                'conditions' => array(
                    'PaquetesUsuario.usuario_id' => $usuarioId,
                    'PaquetesUsuario.asignado' => '1'), 
                'group' => 'P.estado_id',
                'paramType' => 'querystring',
                'recursive' => 0
            )); 
                
            return $PQUsuario;
        }

        /**
         * Se obtienen todos los paquetes en gestion por usuarios
         */
        public function obtenerPaquetesUsuarios() {
            $arr_join = array(); 

            array_push($arr_join, array(
                'table' => 'paquetes',
                'alias' => 'P',
                'type' => 'INNER',
                'conditions' => array(
                    'P.id = PaquetesUsuario.paquete_id')
            ));                         

            array_push($arr_join, array(
                'table' => 'estados',
                'alias' => 'E',
                'type' => 'INNER',
                'conditions' => array(
                    'E.id = P.estado_id')
            ));                          

            array_push($arr_join, array(
                'table' => 'usuarios',
                'alias' => 'U',
                'type' => 'INNER',
                'conditions' => array(
                    'U.id = PaquetesUsuario.usuario_id')
            ));                          
                            
            $PQUsuario = $this->find('all', array(
                'joins' => $arr_join,   
                'fields' => array(
                    'COUNT(E.id) AS cantidad',
                    'U.nombre'
                    ),
                'group' => 'U.id',
                'paramType' => 'querystring',
                'recursive' => 0
            )); 
                
            return $PQUsuario;  
        }
}
 