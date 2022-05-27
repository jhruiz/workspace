<?php
App::uses('AppModel', 'Model');
/**
 * Usuario Model
 *
 * @property Perfile $Perfile
 * @property Estadoregistro $Estadoregistro
 * @property Oficina $Oficina
 * @property Auditoria $Auditoria
 * @property Permisousuariobandeja $Permisousuariobandeja
 * @property Trazabilidade $Trazabilidade
 * @property Regionale $Regionale
 * @property Paquete $Paquete
 */
class Usuario extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'nombre';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'nombre' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'identificacion' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'correoelectronico' => array(
                        'Valid email' => array(
                            'rule' => array('email'),
                            'message' => 'Por favor ingrese una dirección valida',
                        ),
		),
		'password' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'perfile_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'estadoregistro_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),	
		'username' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
                        'unique' => array(
                            'rule' => 'isUnique',
                            'message' => 'El nombre de usuario ya esta en uso.'
                        )
		)
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Perfile' => array(
			'className' => 'Perfile',
			'foreignKey' => 'perfile_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Estadoregistro' => array(
			'className' => 'Estadoregistro',
			'foreignKey' => 'estadoregistro_id',
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
		'Auditoria' => array(
			'className' => 'Auditoria',
			'foreignKey' => 'usuario_id',
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
		'Permisousuariobandeja' => array(
			'className' => 'Permisousuariobandeja',
			'foreignKey' => 'usuario_id',
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
			'foreignKey' => 'usuario_id',
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
		'Regionale' => array(
			'className' => 'Regionale',
			'joinTable' => 'oficinas_usuarios',
			'foreignKey' => 'usuario_id',
			'associationForeignKey' => 'oficina_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
		),
		'Paquete' => array(
			'className' => 'Paquete',
			'joinTable' => 'paquetes_usuarios',
			'foreignKey' => 'usuario_id',
			'associationForeignKey' => 'paquete_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
		)
	);

        public function obtenerUsuarioPorId($id){                         
        
            if (!empty($id)) {
                $arrUsuario = $this->find('first', array('conditions' => array('Usuario.id' => $id), 'recursive' => -1));
                return $arrUsuario;
            }
            
        }
        
    public function validarcontrasenaanterior($usuario_id,$contrasena){
        
        $valido=false;
        
        if(!empty($usuario_id) && !empty($contrasena)){
            
            $datosUser = $this->find('first', array('conditions' => array('Usuario.id' => $usuario_id), 'recursive' => -1));

            $tamArray = count($datosUser);
            if ($tamArray > 0) {
                //Se obtienen la contrasena dle usuario guardada en la bd
                $prePass = $datosUser['Usuario']['password'];

                ///Se encripta la contrasena ingresada como anterior por el usuario para comparar
                $passCript = AuthComponent::password($contrasena);
                if ($prePass == $passCript)
                    $valido=true;
            }
        }
        
        return $valido;
    }    
    
    public function obtenerListaUsuarios(){
        $arrListaUsuarios = $this->find('list');
        return $arrListaUsuarios;
    }
    
    public function obtenerInfoUsuarios(){
        $arrInfoUsuarios = $this->find('all', array('recursive' => -1));
        return $arrInfoUsuarios;
    }
    
    public function obtenerUsuarioPorPerfil($idPerfil){
        $datosUsuarioPerfil = $this->find('all', array(
            'conditions' => array(
                'Usuario.perfile_id' => $idPerfil, 
                'Usuario.estadoregistro_id' => 1
                ),
            'order' => 'Usuario.id',
            'recursive' => -1
            ));
        
        return $datosUsuarioPerfil;
    }
    
    public function obtenerUsuariosCargaPaquetes($regionalId, $bandejaId){
            $arr_join = array(); 
            array_push($arr_join, array(
                'table' => 'oficinas_usuarios', 
                'alias' => 'RU', 
                'type' => 'INNER',
                'conditions' => array(
                    'RU.usuario_id = Usuario.id',
                    'RU.oficina_id' => $regionalId
                    )
                ));  
            
            array_push($arr_join, array(
                'table' => 'permisousuariobandejas', 
                'alias' => 'PUB', 
                'type' => 'INNER',
                'conditions' => array(
                        'PUB.usuario_id = Usuario.id',
                        'PUB.bandeja_id' => $bandejaId,
                        'PUB.permisobandeja_id' => '1'
                    )
                ));    
            
            $listadoUsuario = $this->find('all', array(
                'joins' => $arr_join,    
                'conditions' => array('Usuario.estadoregistro_id' => '1'),
                'recursive' => -1                    
                ));
            
            return $listadoUsuario;
    }
    
    
    public function obtenerUsuariosPorOficinaId($arrOficinasId){
    
        $arr_join = array(); 

        array_push($arr_join, array(
            'table' => 'oficinas_usuarios', 
            'alias' => 'OFIU', 
            'type' => 'INNER',
            'conditions' => array(
                'AND' => array(
                    'OFIU.usuario_id = Usuario.id')
            )
        ));        

        $infoUsuarioOficina = $this->find('all', array(
            'joins' => $arr_join,   
            'fields' => array(
                'Usuario.nombre',
                'Usuario.identificacion'
                ),
            'conditions' => array(
                'OFIU.oficina_id' => $arrOficinasId),               
            'paramType' => 'querystring',
            'group' => array('Usuario.nombre','Usuario.identificacion', 'Usuario.id'),
            'recursive' => 0
        ));                                 

        return $infoUsuarioOficina;
    }
    
    //Retorna los usuarios con permisos de gestión sobre las bandejas en las oficinas de los paquetes a trasladar
    public function obtenerUsuarioGestionPaquete($arrOficinas, $arrBandejas, $usuarioId){
        $arr_join = array();

        array_push($arr_join, array(
            'table' => 'oficinas_usuarios', 
            'alias' => 'OFIU', 
            'type' => 'INNER',
            'conditions' => array(
                'OFIU.usuario_id = Usuario.id')
        ));         
        
        array_push($arr_join, array(
            'table' => 'permisousuariobandejas', 
            'alias' => 'PUB', 
            'type' => 'INNER',
            'conditions' => array(
                'PUB.usuario_id = Usuario.id')
        ));    

        $arrUsuarios = $this->find('all', array(
            'joins' => $arr_join,   
            'fields' => array(
                'Usuario.id',
                'Usuario.nombre',
                'OFIU.oficina_id',
                'PUB.bandeja_id'
                ),
            'conditions' => array(
                'OFIU.oficina_id' => $arrOficinas,
                'PUB.bandeja_id' => $arrBandejas,
                'PUB.permisobandeja_id' => '1',
                'Usuario.id <>' => $usuarioId,
                'Usuario.estadoregistro_id' => '1'
                ),               
            'paramType' => 'querystring',
            'recursive' => 0
        )); 
        
        return $arrUsuarios;
    }
    
    public function obtenerListaUsuariosPerfil($perfilId){
        $arrListaUsuarios = $this->find('list', array('conditions' => array('Usuario.perfile_id' => $perfilId), 'order' => 'Usuario.nombre ASC'));
        return $arrListaUsuarios;
    }    
}
