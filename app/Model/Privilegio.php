<?php
App::uses('AppModel', 'Model');
/**
 * Privilegio Model
 *
 * @property Usuario $Usuario
 */
class Privilegio extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'descripcion';


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
	public $hasAndBelongsToMany = array(
		'Usuario' => array(
			'className' => 'Usuario',
			'joinTable' => 'privilegios_usuarios',
			'foreignKey' => 'privilegio_id',
			'associationForeignKey' => 'usuario_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
		)
	);
        
        public function obtenerIdPrivilegio($permisoDesc){
            $idDatoPrivilegi = "";

            switch ($permisoDesc) {                
                case 'Crear' : {
                        $idDatoPrivilegi = 1;
                        break;
                    }
                    
                case 'Adjuntar' : {
                        $idDatoPrivilegi = 2;
                        break;
                    }                    
                    
                case 'Traslado' : {
                        $idDatoPrivilegi = 3;
                        break;
                    }
                    
                case 'CambiarUsr' : {
                        $idDatoPrivilegi = 4;
                        break;                        
                    }
                
                case 'GestionFlujo' : {
                        $idDatoPrivilegi = 5;
                        break;                        
                    }                    


                default: {
                        '';
                        break;
                    }
            }

            return $idDatoPrivilegi;            
        }
}
