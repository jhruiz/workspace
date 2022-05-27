<?php
App::uses('AppModel', 'Model');
/**
 * Oficina Model
 *
 * @property Ciudade $Ciudade
 * @property Estadoregistro $Estadoregistro
 * @property Paquete $Paquete
 * @property Usuario $Usuario
 * @property Impresorasoficina $Impresorasoficina
 * @property Usuario $Usuario
 */
class Oficina extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'descripcion';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'ciudade_id' => array(
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
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Ciudade' => array(
			'className' => 'Ciudade',
			'foreignKey' => 'ciudade_id',
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
		'Paquete' => array(
			'className' => 'Paquete',
			'foreignKey' => 'oficina_id',
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
		'Impresorasoficina' => array(
			'className' => 'Impresorasoficina',
			'foreignKey' => 'oficina_id',
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

        public function obtenerListaOficinasPorCiudad($ciudadId){
            $arrOficinas = $this->find('list', array('conditions' => array('Oficina.estadoregistro_id' => 1, 'Oficina.ciudade_id' => $ciudadId)));
            return $arrOficinas;
        }    
        
        public function obtenerOficinaPorId($oficinaId){
            $arrOficinas = $this->find('first', array('conditions' => array('Oficina.id' => $oficinaId), 'recursive' => -1));
            return $arrOficinas;
        }
        
        public function obtenerInfoOficina($oficinaId){                                 
            $arrOficina = $this->find('first', array('conditions' => array('Oficina.id' => $oficinaId), 'recursive' => 0));
            return $arrOficina;
        }      
        
        public function obtenerOficinasPaquetes($paqueteId){
            $arr_join = array(); 
            $oficinas = array();
            
            array_push($arr_join, array(
                'table' => 'paquetes', 
                'alias' => 'PQ', 
                'type' => 'INNER',
                'conditions' => array(
                    'PQ.oficina_id=Oficina.id')
                
            ));
            
            $arrOficina = $this->find('all', array(
                'joins' => $arr_join,   
                'fields' => array(
                    'Oficina.id',
                    ),                
                'conditions' => array(
                    'PQ.id' => $paqueteId
                    ),
                'group' => 'Oficina.id',
                'recursive' => '-1'                
                ));
            
            if(count($arrOficina) > 0){
                for($i = 0; $i < count($arrOficina); $i++){
                    $oficinas[$i] = $arrOficina[$i]['Oficina']['id'];
                }
            }
            
            return $oficinas;
        }
        
        public function obtenerUbicacionOficina($oficinaId){
            $arr_join = array(); 
            
            array_push($arr_join, array(
                'table' => 'ciudades', 
                'alias' => 'C', 
                'type' => 'INNER',
                'conditions' => array(
                    'C.id=Oficina.ciudade_id')                
            ));            
			
            array_push($arr_join, array(
                'table' => 'regionales', 
                'alias' => 'R', 
                'type' => 'INNER',
                'conditions' => array(
                    'C.regionale_id=R.id')                
            ));         
            
            $arrUbicacion = $this->find('first', array(
                'joins' => $arr_join,   
                'fields' => array(
                    'C.id',
                    'C.regionale_id',
					'C.descripcion',
					'R.descripcion',
					'Oficina.descripcion'
                    ),                
                'conditions' => array(
                    'Oficina.id' => $oficinaId
                    ),
                'recursive' => '-1'                
                ));
            
            return $arrUbicacion;
        }
        
        public function obtenerListaOficinas(){
            $arrCiudades = $this->find('list', array('conditions' => array('Oficina.estadoregistro_id' => 1),'order' => array('Oficina.descripcion' => 'asc')));
            return $arrCiudades;
        }    
        
        public function obtenerInfoOficinasPorCiudad($ciudadId){
            $arrOficinas = $this->find('all', array('conditions' => array('Oficina.estadoregistro_id' => 1, 'Oficina.ciudade_id' => $ciudadId), 'recursive' => '-1'));
            return $arrOficinas;
        }           
        
}
