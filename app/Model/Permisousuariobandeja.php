<?php
App::uses('AppModel', 'Model');
/**
 * Permisousuariobandeja Model
 *
 * @property Bandeja $Bandeja
 * @property Usuario $Usuario
 * @property Permisobandeja $Permisobandeja
 */
class Permisousuariobandeja extends AppModel {

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
		'permisobandeja_id' => array(
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
		'Usuario' => array(
			'className' => 'Usuario',
			'foreignKey' => 'usuario_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Permisobandeja' => array(
			'className' => 'Permisobandeja',
			'foreignKey' => 'permisobandeja_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
        
        public static function agregarPermisoBandejasUsuario($idBandeja, $idUsuario, $idPermiso){            
            $data=array();                                        
            $permisousuariobandeja = new Permisousuariobandeja();                        
            
            $data['bandeja_id']=$idBandeja;
            $data['usuario_id']=$idUsuario;
            $data['permisobandeja_id']=$idPermiso;
            
            if($permisousuariobandeja->save($data)){
                return true;
            }else{
                return false;
            }
        }
                    
        /**
         * Se eliminan los permisos que un usuario tiene sobre las bandejas
         * 
         * @param type $usuario_id: id del usuario al q se le eliminan los permisos
         * @param type $permporcargo: Determina si se eliminaran los permisos que el usuario hereda del cargo(0), si son particulares del usuario(1) o todos(2)
         * @return type
         */
        public function eliminarPermisoBandejaUsuario($usuario_id){

            if(!empty($usuario_id)){ 
                $condiciones=array('usuario_id' => $usuario_id);
                $this->deleteAll(array($condiciones),false);
            }
        }                  
        
        public function obtenerPermisosUsuariosBandejas($idBandeja){
            $permisosBandejas = $this->find('all', array('conditions' => array('Permisousuariobandeja.bandeja_id' => $idBandeja), 'recursive' => 0));            
            return $permisosBandejas;
        }        
        
        public function obtenerPermisosUsrBandPerm($idBandeja, $idUsuario, $idPermisobandeja){
            $respuesta = true;
            $datosPermisoUsrBand = $this->find('first', array(
                'conditions' => array(
                    'Permisousuariobandeja.bandeja_id' => $idBandeja, 
                    'Permisousuariobandeja.usuario_id' => $idUsuario,
                    'Permisousuariobandeja.permisobandeja_id' => $idPermisobandeja
                    ),
                'recursive' => -1
                )
           );
            
            if(count($datosPermisoUsrBand) > 0){
                $respuesta = false;
            }
            
            return $respuesta;
        }
        
        public function obtenerPermisoXUsuario($idUsuario){
            $permisosUsuario = $this->find(
                    'all', array(
                        'conditions' => array(
                            'Permisousuariobandeja.usuario_id' => $idUsuario
                    ), 'recursive' => 0
                        ));            
            return $permisosUsuario;            
        }
        
        public function obtenerPermisosPorUsuBand($idBandeja, $idUsuario){
            $permisosBandejas = $this->find(
                    'first', array(
                        'conditions' => array(
                            'Permisousuariobandeja.bandeja_id' => $idBandeja, 
                            'Permisousuariobandeja.usuario_id' => $idUsuario
                    ), 'recursive' => 0)
                    );
            
            return $permisosBandejas;
        }           
}
