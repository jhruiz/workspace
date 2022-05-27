<?php
App::uses('AppModel', 'Model');
/**
 * PrivilegiosUsuario Model
 *
 * @property Privilegio $Privilegio
 * @property Usuario $Usuario
 */
class PrivilegiosUsuario extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'privilegio_id' => array(
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
		'Privilegio' => array(
			'className' => 'Privilegio',
			'foreignKey' => 'privilegio_id',
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
        
        public function obtenerPrivilegiosPorUsuario($usuarioId, $permisoId){
            $arrPrivilegios = $this->find('first', array('conditions' => array('PrivilegiosUsuario.usuario_id' => $usuarioId, 'PrivilegiosUsuario.privilegio_id' => $permisoId), 'recursive' => -1));                        
            return $arrPrivilegios;
        }
        
        public function obtenerPrivilegiosPorUsuarioId($usuarioId){
            $arrPrivilegios = $this->find('all', array('conditions' => array('PrivilegiosUsuario.usuario_id' => $usuarioId), 'recursive' => -1));                        
            return $arrPrivilegios;
        }

        public static function agregarPrivilegiosUsuario($privilegioId, $usuarioId){            
            $data=array();                                        
            $privilegiosUsuario = new PrivilegiosUsuario();                        
            
            $data['privilegio_id']=$privilegioId;
            $data['usuario_id']=$usuarioId;
            
            if($privilegiosUsuario->save($data)){
                return true;
            }else{
                return false;
            }
        }        
}
