<?php
App::uses('AppModel', 'Model');
/**
 * DocumentosPaquete Model
 *
 * @property Documento $Documento
 * @property Paquete $Paquete
 */
class DocumentosPaquete extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'documento_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
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
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Documento' => array(
			'className' => 'Documento',
			'foreignKey' => 'documento_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Paquete' => array(
			'className' => 'Paquete',
			'foreignKey' => 'paquete_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
                
    public function guardarDocumentosPaquete($documentoId, $paqueteId, $url) {
        $data = array();

        $idDocumentoPaquete = 0;
        $documentospaquete = new Documentospaquete();

        $data['documento_id'] = $documentoId;
        $data['paquete_id'] = $paqueteId;
        $data['url_fisica'] = $url;
        $data['revisado'] = '1';

        if ($documentospaquete->save($data)) {
            $idDocumentoPaquete = $documentospaquete->id;
        }else{
        }
        return $idDocumentoPaquete;
    }

    /**
     * Retorna los registros de documentos paquete que no han sido gestionados, tiposdocumentales y padredocumental mediante, consultados por paqueteId
     * @param integer $paqueteId
     * @return array
     * @author amautave <andrestabares@datecsa.com>
     */
     public function obtenerDocsAprobarPaquetePorPaqteId($paqueteId,$tipoPermisos_id=null,$usuario_id=null) {
        $this->Behaviors->load('Containable');

        $documentosPaquete = $this->find("first", array(
            'contain' => array(
                'Tiposdocumentale' => array(
                    'Padredocumentale'
                )
            ),
            'conditions' => array('AND' => array(
                'paquete_id' => $paqueteId,
                'OR' => array('gestionado IS FALSE','gestionado IS NULL'),
                
            ))
        ));
        return $documentosPaquete;
    }
            
    /**
     * Retorna los documentos indexados a un paquete, se buscar por el id del paquete
     * @param integer $paqueteId: id del paquete a consultar
     * @return array
     * @author Andres Hernandez <andreshernandez@datecsa.com>
     */
    public function obtenerDocsPaquetePorPaqteId($paqueteId) {
        $documentosPaquete = $this->find("all", array(
            'conditions' => array('AND' => array(
                'paquete_id' => $paqueteId,
                'revisado' => 't'
            )),
            'order' => array('Documentospaquete.id' => 'ASC'),
            'recursive' => -1
        ));
        return $documentosPaquete;
    }     
    
    /**
     * Funcion que elimina un documento del paquete
     * 
     * @param type $docpaquete_id
     * @return boolean
     */
    public function desactivarDocPaquete($docpaquete_id){
        
        $datosDocumento['id'] = $docpaquete_id;
        $datosDocumento['revisado'] = '0';
        
        $objDocPaq = new DocumentosPaquete();
        
        if($objDocPaq->save($datosDocumento)){            
            $salida = true;
            } else {
                $salida = false;
            }         
    }
    
    
    /**
     * Retorna los documentos indexados a un paquete sin discriminar los que se han concatenado que no aparecen en el llamado en pantalla, se buscar por el id del paquete
     * @param integer $paqueteId: id del paquete a consultar
     * @return array
     * @author Andres Hernandez <andreshernandez@datecsa.com>
     */
    public function obtenerDocsPorPaqteId($paqueteId) {
        $documentosPaquete = $this->find("all", array(
            'conditions' => array('AND' => array(
                'paquete_id' => $paqueteId
            )),
            'order' => array('Documentospaquete.id' => 'ASC'),
            'recursive' => -1
        ));
        return $documentosPaquete;
    }      
}
