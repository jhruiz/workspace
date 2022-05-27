<?php
App::uses('AppModel', 'Model');
/**
 * Bandeja Model
 *
 * @property Estado $Estado
 * @property Bandejasestado $Bandejasestado
 * @property Permisousuariobandeja $Permisousuariobandeja
 * @property Semaforo $Semaforo
 */
class Bandeja extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
    
    	public $displayField = 'descripcion';
        
        
	public $validate = array(
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed


/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Bandejasestado' => array(
			'className' => 'Bandejasestado',
			'foreignKey' => 'bandeja_id',
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
			'foreignKey' => 'bandeja_id',
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
		'Estado' => array(
			'className' => 'Estado',
			'joinTable' => 'bandejas_estados',
			'foreignKey' => 'bandeja_id',
			'associationForeignKey' => 'estado_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
		)            
	);
        
        public function listaBandejas(){
            $arrListBandejas = $this->find('list');
            return $arrListBandejas;
        }
        
        public function infoBandejas(){
            $infoBandejas = $this->find('all', array('recursive' => 0));
            return $infoBandejas;
        }
        
        public function obtenerBandejaPorId($idBandeja){
            $bandejaPorId = $this->find('first', array('conditions' => array('Bandeja.id' => $idBandeja), 'recursive' => -1));
            return $bandejaPorId;
        }
        
        public function obtenerInfoBandejaPorId($idBandeja){
            $bandejaPorId = $this->find('first', array('conditions' => array('Bandeja.id' => $idBandeja)));
            return $bandejaPorId;
        }
        
        public function obtenerBandejasPorPaquetes($paqueteId){
            $arr_join = array(); 
            $bandejas = array();

            array_push($arr_join, array(
                'table' => 'relacionbandejasestados', 
                'alias' => 'RBE', 
                'type' => 'INNER',
                'conditions' => array(
                    'RBE.bandeja_id=Bandeja.id')
                
            ));
            
            array_push($arr_join, array(
                'table' => 'paquetes', 
                'alias' => 'PQ', 
                'type' => 'INNER',
                'conditions' => array(
                    'PQ.estado_id=RBE.estado_id')
                
            ));
            
            $arrBandejas = $this->find('all', array(
                'joins' => $arr_join,   
                'fields' => array(
                    'Bandeja.id',
                    ),                
                'conditions' => array(
                    'PQ.id' => $paqueteId
                    ),
                'group' => 'Bandeja.id',
                'recursive' => '-1'                
                ));
            
            if(count($arrBandejas) > 0){
                for($i = 0; $i < count($arrBandejas); $i++){
                    $bandejas[$i] = $arrBandejas[$i]['Bandeja']['id'];
                }
            }            
            return $bandejas;
        }
        
        //Se obtiene la bandeja inicial del proceso
        public function obtenerBandejaInicial(){
            $arr_join = array(); 
            array_push($arr_join, array(
                'table' => 'relacionbandejasestados', 
                'alias' => 'RBE', 
                'type' => 'INNER',
                'conditions' => array(
                    'RBE.bandeja_id=Bandeja.id')
                
            ));  

            array_push($arr_join, array(
                'table' => 'estados', 
                'alias' => 'E', 
                'type' => 'INNER',
                'conditions' => array(
                    'E.id=RBE.estado_id')
                
            ));  
            
            $arrBandeja = $this->find('first', array(
                'joins' => $arr_join,   
                'fields' => array(
                    'Bandeja.id',
                    'E.id'                    
                    ),                
                'conditions' => array(
                    'E.estadoinicial' => '1'
                    ),
                'recursive' => '-1'                
                ));
            return $arrBandeja;
        }
        
}