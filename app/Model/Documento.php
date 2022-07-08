<?php
App::uses('AppModel', 'Model');
/**
 * Documento Model
 *
 * @property Tipodocumento $Tipodocumento
 * @property Paquete $Paquete
 */
class Documento extends AppModel {

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
		'id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
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
		'tipodocumento_id' => array(
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
		'Tipodocumento' => array(
			'className' => 'Tipodocumento',
			'foreignKey' => 'tipodocumento_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
	public $hasAndBelongsToMany = array(
		'Paquete' => array(
			'className' => 'Paquete',
			'joinTable' => 'documentos_paquetes',
			'foreignKey' => 'documento_id',
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
        
	public function obtenerDocumentos(){
		$arrDocumentos = $this->find('list');
		return $arrDocumentos;
	}

	/**
	 * Obtiene las retenciones por documentos
	 */
	public function obtenerRetencionesDocs() {
		$arr_join = array(); 
            
		array_push($arr_join, array(
			'table' => 'tipodocumentos', 
			'alias' => 'TD', 
			'type' => 'INNER',
			'conditions' => array(
				'AND' => array(
					'TD.id=Documento.tipodocumento_id')
			)
		));
            
		array_push($arr_join, array(
			'table' => 'series', 
			'alias' => 'S', 
			'type' => 'INNER',
			'conditions' => array(
				'AND' => array(
					'S.id=TD.serie_id')
			)
		));
            
		array_push($arr_join, array(
			'table' => 'retenciones_series', 
			'alias' => 'RS', 
			'type' => 'INNER',
			'conditions' => array(
				'AND' => array(
					'RS.serie_id=S.id')
			)
		));
            
		array_push($arr_join, array(
			'table' => 'unidadesmedidas', 
			'alias' => 'UM', 
			'type' => 'INNER',
			'conditions' => array(
				'AND' => array(
					'UM.id=RS.unidadesmedida_id')
			)
		));
            
		array_push($arr_join, array(
			'table' => 'acciondisposiciones', 
			'alias' => 'AD', 
			'type' => 'INNER',
			'conditions' => array(
				'AND' => array(
					'AD.id=RS.acciondisposicione_id')
			)
		));

		$resp = $this->find('all', array(
			'joins' => $arr_join,   
			'fields' => array(
				'Documento.*',
				'RS.*',
				'UM.*',
				'AD.*'
			),
			'paramType' => 'querystring',
			'recursive' => -1
			)); 

		return $resp;
	}

}
