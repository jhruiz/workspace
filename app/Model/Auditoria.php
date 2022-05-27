<?php
App::uses('AppModel', 'Model');
/**
 * Auditoria Model
 *
 * @property Usuario $Usuario
 */
class Auditoria extends AppModel {


/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'notempty' => array(
				'rule' => array('notempty'),
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
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'descripcion' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'accion' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'created' => array(
			'datetime' => array(
				'rule' => array('datetime'),
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
		'Usuario' => array(
			'className' => 'Usuario',
			'foreignKey' => 'usuario_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
        
        
        /**
        * logAuditoria method
        *
        * Registra un registro log en la tabla de Auditoria 
        *         
        * @param integer $usuario
        * @param integer $descripcion   Descripcion del log a registrar.
        * @param integer $accion     Accion del log a registrar.
        * @return boolean
        */
        public static function logAuditoria($usuario, $descripcion, $accion){
            
            $data=array();                        
                
            $auditoria=new Auditoria();                        
            
            $data['usuario_id']=$usuario;
            $data['descripcion']=$descripcion;
            $data['accion']=$accion;
            
            if($auditoria->save($data)){
                return true;
            }else{
                return false;
            }
        }
        
        public function afterFind($results, $primary = false) {
            foreach ($results as $key => $val) {
                if (isset($val['Auditoria']['created'])) {
                    $results[$key]['Auditoria']['created'] = $this->dateFormatAfterFind($val['Auditoria']['created']);
                }
            }
            return $results;
        }

        public function dateFormatAfterFind($dateString) {                        
            
            return date('d/m/Y', strtotime($dateString));
        }     
        
        public function accionAuditoria($id){
            $accionAud = "";
            if($id == '0'){
                $accionAud = "Cambio de Estado";
            }
            
            if($id == '1'){
                $accionAud = "Eliminacion Documento";
            }
            
            if($id == '2'){
                $accionAud = "Cambio de Usuario-Paquete";
            }
            
            if($id == '3'){
                $accionAud = "Cambio numero de credencial";
            }
            
            if($id == '4'){
                $accionAud = "Cargue documento";
            }
            
            if($id == '5'){
                $accionAud = "Usuario Inactivo";
            }            
            
            if($id == '6'){
                $accionAud = "Usuario Activo";
            }             

            if($id == '7'){
                $accionAud = "Usuario Bloqueado";
            }   
            
            return $accionAud;
        }
        
        public function descripcionAuditoria($id, $arrDescripcionAud){
            $descripcionAud = "";
            if($id == '0'){
                $descripcionAud = "La solicitud " . $arrDescripcionAud['numOficio'] . " se gestionó del estado " . $arrDescripcionAud['estOrigen'] . " al estado " . $arrDescripcionAud['estDestino'] . ".";
            }
            
            if($id == '1'){
                $descripcionAud = "Se elimina el documento de la solicitud " . $arrDescripcionAud['numOficio'] . ".";
            }
            
            if($id == '2'){
                $descripcionAud = "Se cambia la solicitud " . $arrDescripcionAud['numOficio'] . " al usuario " . $arrDescripcionAud['nombreUsuario'] . ".";
            }
            
            if($id == '3'){
                $descripcionAud = "Se cambia el numero de credencial " . $arrDescripcionAud['numOficio'] . " por " . $arrDescripcionAud['numOficioNuevo'] . ".";
            }
            
            if($id == '4'){
                $descripcionAud = "Se carga a la solicitud " . $arrDescripcionAud['numOficio'] . " el documento " . $arrDescripcionAud['nomDocumento'] . ".";
            }
            
            if($id == '5'){
                $descripcionAud = "Se " . $arrDescripcionAud['estado'] . " el usuario con nombre: " . $arrDescripcionAud['nombre'] . ", identificacion: " . $arrDescripcionAud['identificacion'] . " y login: " . $arrDescripcionAud['username'] . ".";
            }
            
            
            
            return $descripcionAud;
        }
}
