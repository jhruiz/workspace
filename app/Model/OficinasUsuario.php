<?php
App::uses('AppModel', 'Model');
/**
 * OficinasUsuario Model
 *
 * @property Oficina $Oficina
 * @property Usuario $Usuario
 */
class OficinasUsuario extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'oficina_id';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
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
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Oficina' => array(
			'className' => 'Oficina',
			'foreignKey' => 'oficina_id',
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
        
        //Se obtienen las oficinas relacionadas a un usuario por medio del id del usuario
        public function obtenerOficinasUsuario($usuarioId){
            $arrOficinasUsuario = $this->find('all', array('conditions' => array('OficinasUsuario.usuario_id' => $usuarioId), 'recursive' => 0));
            return $arrOficinasUsuario;
        }              
        
        //Se guarda cada oficina seleccionada para el usuario
        public static function saveOficinaUsuario($usuarioId, $oficinaId){
            $data = array();

            $oficinasUsuario = new OficinasUsuario();

            $data['oficina_id'] = $oficinaId;
            $data['usuario_id'] = $usuarioId;

            if ($oficinasUsuario->save($data)) {
                $respuesta = true;
            }else{
                $respuesta = false;
            }
        }     
        
        public function obtenerListaOficinasUsuarios($usuarioId){
           
            $this->Behaviors->load('Containable');
            
            $arr_join = array(); 
            
            array_push($arr_join, array(
                'table' => 'oficinas', 
                'alias' => 'OFI', 
                'type' => 'INNER',
                'conditions' => array(
                    'AND' => array(
                        'OFI.id=OficinasUsuario.oficina_id')
                )
            ));
            
                
            array_push($arr_join, array(
                'table' => 'ciudades',
                'alias' => 'CIU',
                'type' => 'INNER',
                'conditions' => array(
                    'AND' => array(
                        'CIU.id=OFI.ciudade_id')
                )
            ));
            
            array_push($arr_join, array(
                'table' => 'regionales',
                'alias' => 'REG',
                'type' => 'INNER',
                'conditions' => array(
                    'AND' => array(
                        'REG.id=CIU.regionale_id'
                    )
                )                
            ));
                            
            $listadoOficinasUsuario = array(
                'joins' => $arr_join,   
                'fields' => array(
                    'REG.descripcion',
                    'CIU.descripcion',
                    'OFI.descripcion',
                    'Usuario.nombre',
                    'OficinasUsuario.*'
                    ),
                'conditions' => array(
                    'OficinasUsuario.usuario_id' => $usuarioId),               
                'paramType' => 'querystring',
                'recursive' => 0
                );                                 

            return $listadoOficinasUsuario;              
        }
        
        public function listaOficinasUsuario($usuarioId){
            $arr_join = array(); 
            
            array_push($arr_join, array(
                'table' => 'oficinas', 
                'alias' => 'OFI', 
                'type' => 'INNER',
                'conditions' => array(
                    'AND' => array(
                        'OFI.id=OficinasUsuario.oficina_id')
                )
            ));
                            
            array_push($arr_join, array(
                'table' => 'ciudades',
                'alias' => 'CIU',
                'type' => 'INNER',
                'conditions' => array(
                    'AND' => array(
                        'CIU.id=OFI.ciudade_id')
                )
            ));
            
            array_push($arr_join, array(
                'table' => 'regionales',
                'alias' => 'REG',
                'type' => 'INNER',
                'conditions' => array(
                    'AND' => array(
                        'REG.id=CIU.regionale_id'
                    )
                )                
            ));
                            
            $listadoOficinasUsuario = $this->find('all', array(
                'joins' => $arr_join,   
                'fields' => array(
                    'REG.descripcion',
                    'CIU.descripcion',
                    'OFI.descripcion',
                    'Usuario.nombre',
                    'OficinasUsuario.*'
                    ),
                'conditions' => array(
                    'OficinasUsuario.usuario_id' => $usuarioId),               
                'paramType' => 'querystring',
                'recursive' => 0
                ));                                 

            return $listadoOficinasUsuario;              
            
        }
        
        public function obtenerOficinaUsuarioPorId($ofiUsrId){
            $infoOfiUsr = $this->find('first', array('conditions' => array('OficinasUsuario.id' => $ofiUsrId), 'recursive' => -1));
            return $infoOfiUsr;
        }
        
        public function validarPermisosUsuario($oficinaId, $usuarioId, $bandejaId){

            $arr_join = array();
            
            array_push($arr_join, array(
                'table' => 'usuarios',
                'alias' => 'U',
                'type' => 'INNER',
                'conditions' => array(
                    'U.id=OficinasUsuario.usuario_id'
                    )
                ));    
            
            array_push($arr_join, array(
                'table' => 'permisousuariobandejas',
                'alias' => 'PUB',
                'type' => 'INNER',
                'conditions' => array(
                    'PUB.usuario_id=U.id'                    
                    )
                ));                          
            
            $arrPermisoUsr = $this->find('first', array(
                'joins' => $arr_join,
                'conditions' => array(
                    'OficinasUsuario.oficina_id' => $oficinaId,
                    'U.id' => $usuarioId,
                    'U.estadoregistro_id' => '1',
                    'PUB.bandeja_id' => $bandejaId,
                    'PUB.permisobandeja_id' => '1'
                ),
                'recursive' => '-1'                
            ));     
            
            return $arrPermisoUsr; 
        }
        
}
