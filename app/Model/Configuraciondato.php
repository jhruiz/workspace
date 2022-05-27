<?php

App::uses('AppModel', 'Model');

/**
 * Configuraciondato Model
 *
 */
class Configuraciondato extends AppModel {

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
        'id' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
            'numeric' => array(
                'rule' => array('numeric'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'nombre' => array(
            'notempty' => array(
                'rule' => array('notempty'),
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
            'maxlength' => array(
                'rule' => array('maxlength',50),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
            'unique' => array(
                'rule' => 'isUnique',
                'message' => 'El nombre del dato de configuracion ya esta en uso.'
            )
        ),
        'valor' => array(
            'maxlength' => array(
                'rule' => array('maxlength',150),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
    );

    ///Funcion para obtener el id de un dato de configuracion 
    public function obtenerIdDatoConfig($dato) {
        $idDatoConfig = "";

        switch ($dato) {
            case 'url_raizproyserver' : {
                    $idDatoConfig = 8;
                    break;
                }
            case 'dirPaquetes' : {
                $idDatoConfig = 2;
                break;
            }
            case 'dirTemp' : {
                $idDatoConfig = 1;
                break;                
            }
            case 'jvm' : {
                $idDatoConfig = 21;
                break;
            }
            case 'Agente_ConsolidaPDF' : {
                $idDatoConfig = 22;
                break;
            }
            default: {
                    '';
                    break;
                }
        }

        return $idDatoConfig;
    }

    ///Funcion para obtener la informacion de un dato de configuracion por medio de su id
    public function obtenerValorDatoConfig($idDatoConfig) {

        $valorDato = "";
        if (!empty($idDatoConfig)) {
            $infoDatoConfig = $this->find('all', array('conditions' => array('id' => $idDatoConfig), 'recursive' => 0));
            $valorDato = $infoDatoConfig[0]['Configuraciondato']['valor'];
        }
        return $valorDato;
    }

    /**
     * Consulta en la tabla Configuraciondato el valor de la variable pasada como parametro
     * @param type $dato Nombre  de la variable a otbener
     * @return type
     */
    public function obtenerInfo($dato) {
        return $this->obtenerValorDatoConfig($this->obtenerIdDatoConfig($dato));
    }

}
