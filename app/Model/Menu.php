<?php
App::uses('AppModel', 'Model');
/**
 * Menu Model
 *
 * @property Menu $Menu
 * @property Menu $Menu
 * @property Perfile $Perfile
 */
class Menu extends AppModel {

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
        
/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Menu' => array(
			'className' => 'Menu',
			'foreignKey' => 'menu_id',
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
		'Perfile' => array(
			'className' => 'Perfile',
			'joinTable' => 'menus_perfiles',
			'foreignKey' => 'menu_id',
			'associationForeignKey' => 'perfile_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
		)
	);
        
        public function obtenerMenuPadrePorId($idPadre){
            $arrMenuPadre = $this->find('first', array('conditions' => array('Menu.id' => $idPadre),'recursive' => 0));
            return $arrMenuPadre;
        }
}
