<?php
App::uses('AppModel', 'Model');
/**
 * Estado Model
 *
 * @property Bandeja $Bandeja
 * @property Trazabilidade $Trazabilidade
 * @property Bandejasestado $Bandejasestado
 * @property Paquete $Paquete
 */
class Estado extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'descripcion';


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Trazabilidade' => array(
			'className' => 'Trazabilidade',
			'foreignKey' => 'estado_id',
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
		'Bandejasestado' => array(
			'className' => 'Bandejasestado',
			'foreignKey' => 'estado_id',
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
		'Paquete' => array(
			'className' => 'Paquete',
			'foreignKey' => 'estado_id',
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
		'Bandeja' => array(
			'className' => 'Bandeja',
			'joinTable' => 'bandejas_estados',
			'foreignKey' => 'estado_id',
			'associationForeignKey' => 'bandeja_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
		)            
	);        
        
        public function obtenerEstadoPorId($estadoId){
            $arrEstado = $this->find('first', array('conditions' => array('Estado.id' => $estadoId), 'recursive' => 0));
            return $arrEstado;                    
        }
        
        public function estadoInicial($estadoId){
            $arrEstado = $this->find('first', array('fields' => 'Estado.estadoinicial', 'conditions' => array('Estado.id' => $estadoId), 'recursive' => -1));
            if(count($arrEstado) && $arrEstado['Estado']['estadoinicial'] == '1'){
                $boolResp = TRUE;
            }else{
                $boolResp = FALSE;
            }
            return $boolResp; 
        }
        
        public function obtenerInfoEstados(){
            $arrEstados = $this->find('all', array('recursive' => -1));
            return $arrEstados;
        }
        
        public function obtenerEstadosPorId($arrEstadoiId){
            $arrEstado = $this->find('all', array('conditions' => array('Estado.id' => $arrEstadoiId), 'recursive' => '-1'));
            return $arrEstado;              
        }
        
        public function obtenerListaEstados(){
            $arrEstado = $this->find('list');
            return $arrEstado;
        }
		
        public function obtenerEstadosFin(){
            $arrEstado = $this->find('all', array('conditions' => array('Estado.estadofinal' => '1'), 'recursive' => '-1'));
            return $arrEstado;
        }
        
        public function obtenerEstadosIniciales(){
            $arrEstados = $this->find('list', array('conditions' => array('Estado.estadoinicial' => '1'), 'recursive' => '-1'));
            return $arrEstados;
        }
}
