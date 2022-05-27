<?php

App::uses('AppController', 'Controller');
App::import('Model', 'Auditoria');
App::import('Model', 'Regionale');
App::import('Model', 'Ciudade');
App::import('Model', 'Oficina');
App::import('Model', 'Usuario');
App::import('Model', 'RegionalesUsuario');
App::import('Model', 'Menu');
App::uses ('UtilidadesController', 'Controller');

/**
 * Usuarios Controller
 *
 * @property Usuario $Usuario
 * @property PaginatorComponent $Paginator
 */
class UsuariosController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator');

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $title = array();
        $paginate = array();
        if (isset($this->passedArgs['Search.Nombre'])) {
            $paginate['Usuario.nombre LIKE'] = '%' . $this->passedArgs['Search.Nombre'] . "%";
        }

        if (isset($this->passedArgs['Search.Login']) && !empty($this->passedArgs['Search.Login'])) {
            $paginate['Usuario.username LIKE'] = '%' . $this->passedArgs['Search.Login'] . "%";
        }
        
        if (isset($this->passedArgs['Search.perfile_id']) && !empty($this->passedArgs['Search.perfile_id'])) {
            $paginate['Usuario.perfile_id ='] = $this->passedArgs['Search.perfile_id'];
        }
        
        if (isset($this->passedArgs['Search.oficina_id']) && !empty($this->passedArgs['Search.oficina_id'])) {
            $paginate['Usuario.oficina_id ='] = $this->passedArgs['Search.oficina_id'];
        }        

        $this->Usuario->recursive = 0;

        if (empty($paginate)) {
            $this->set('usuarios', $this->Paginator->paginate());
        } else {
            $this->set('usuarios', $this->Paginator->paginate('Usuario', $paginate));
        }
        
        $listPerfile = $this->Usuario->Perfile->find('list');
        
        $this->set(compact('listPerfile', 'listOficina'));
        
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {

        if (!$this->Usuario->exists($id)) {
            throw new NotFoundException(__('Invalid usuario'));
        }
        $options = array('conditions' => array('Usuario.' . $this->Usuario->primaryKey => $id));
        $this->set('usuario', $this->Usuario->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {

        if ($this->request->is('post')) {
            $this->Usuario->create();
            $datosUsuario = $this->request->data("Usuario");
            $datosUsuario['password'] = AuthComponent::password($datosUsuario['password']);

            //Se guarda el usuario
            if ($this->Usuario->save($datosUsuario)) {
                ////Se le asignan los permisos del perfil al nuevo usuario
                $this->agregarPermisosPerfil($datosUsuario['perfile_id'],$this->Usuario->id);                        
                $this->Session->setFlash(__('El usuario ha sido guardado.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('El usuario no pudo ser guardado. Por favor, inténtelo de nuevo.'));
            }
        }
        $perfiles = $this->Usuario->Perfile->find('list');
        $estadoregistros = $this->Usuario->Estadoregistro->find('list');
        $regionales = $this->Usuario->Regionale->find('list');

        $this->set(compact('perfiles', 'estadoregistros', 'oficinas', 'regionales', 'paquetes', 'ciudades'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->Usuario->exists($id)) {
            throw new NotFoundException(__('Invalid usuario'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->Usuario->save($this->request->data)) {
				$this->agregarPermisosPerfil($this->request->data['Usuario']['perfile_id'],$id);
                $this->Session->setFlash(__('El usuario ha sido actualizado.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('El usuario no pudo ser actualizado. Por favor, intentelo de nuevo.'));
            }
        } else {
            $options = array('conditions' => array('Usuario.' . $this->Usuario->primaryKey => $id));
            $this->request->data = $this->Usuario->find('first', $options);
        }
        $perfiles = $this->Usuario->Perfile->find('list');
        $estadoregistros = $this->Usuario->Estadoregistro->find('list');
        $regionales = $this->Usuario->Regionale->find('list');
        $paquetes = $this->Usuario->Paquete->find('list');
        $this->set(compact('perfiles', 'estadoregistros', 'oficinas', 'regionales', 'paquetes'));
    }

	
	
    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null) {
        $this->Usuario->id = $id;
        if (!$this->Usuario->exists()) {
            throw new NotFoundException(__('Invalid usuario'));
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->Usuario->delete()) {
            $this->Session->setFlash(__('The usuario has been deleted.'));
        } else {
            $this->Session->setFlash(__('The usuario could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('action' => 'index'));
    }

    public function obtenerciudades() {
        $this->layout = 'ajax';

        if ($this->request->is('post')) {
            $id = $this->request->data('opcion');
            //obtener las ciudades
            $this->loadModel('Ciudade');

            $ciudades = $this->Ciudade->obtenerListaCiudadesPorRegion($id); 
            
            $this->set(compact('ciudades'));
        }
    }

    public function obteneroficinas() {
        $this->layout = 'ajax';
        if ($this->request->is('post')) {
            $id = $this->request->data('opcion');
            $obtenerUsuarios = $this->request->data('obtenerUsuarios');

            $this->loadModel('Oficina');
            //obtener las oficinas               
            $oficinas = $this->Oficina->obtenerListaOficinasPorCiudad($id);
            $this->set(compact('oficinas'));
            $this->set('obtenerUsuarios', $obtenerUsuarios);
        }
    }

    public function search() {
        $url = array();

        if ($this->data['Usuario']['accion_anterior'] == 'add') {
            $url['action'] = 'add';
        } else if ($this->data['Usuario']['accion_anterior'] == 'index') {
            $url['action'] = 'index';
        }

        foreach ($this->data as $k => $v) {
            if ($k != 'Usuario') {
                foreach ($v as $kk => $vv) {
                    $url[$k . '.' . $kk] = $vv;
                }
            }
        }
        // redirect the user to the url
        $this->redirect($url, null, true);
    }

    public function inactivar($id = null) {
        $this->loadModel('Auditoria');
        $this->Usuario->id = $id;
        if (!$this->Usuario->exists()) {
            throw new NotFoundException(__('Usuario Inválido'));
        }
        $this->request->onlyAllow('post', 'delete');
        $id = $this->request->params['pass'][0];
        $datosUsuario = $this->Usuario->obtenerUsuarioPorId($id);
        $estadReg = $datosUsuario['Usuario']['estadoregistro_id'];
        if ($estadReg == 1) {
            $newEst = 2;
        } else {
            $newEst = 1;
        }
        if ($this->Usuario->updateAll(array('estadoregistro_id' => $newEst, 'num_intentos' => 0), array('id' => $id))) {
            
            /*Se realiza el registro en auditoria para el usuario inactivado*/
            $accionAud = $this->Auditoria->accionAuditoria('5');
            $arrDescripcionAud['nombre'] = $datosUsuario['Usuario']['nombre'];
            $arrDescripcionAud['identificacion'] = $datosUsuario['Usuario']['identificacion'];
            $arrDescripcionAud['username'] = $datosUsuario['Usuario']['username'];
            $arrDescripcionAud['estado'] = "Inactiva";
            $descripcionAud = $this->Auditoria->descripcionAuditoria('5', $arrDescripcionAud);
            $this->Auditoria->logAuditoria($this->Auth->user('id'), $descripcionAud, $accionAud);              
            
            
            $this->Session->setFlash(__('Se ha cambiado el estado del Usuario'));
            return $this->redirect(array('action' => 'index'));
        } else {
            $this->Session->setFlash(__('Se produjo un error, intentelo de nuevo'));
        }
    }

    public function activar($id = null) {
        $this->loadModel('Auditoria');
        $this->Usuario->id = $id;
        if (!$this->Usuario->exists()) {
            throw new NotFoundException(__('El usuario no existe'));
        }
        $this->request->onlyAllow('post', 'delete');
        $id = $this->request->params['pass'][0];
        $datosUsuario = $this->Usuario->obtenerUsuarioPorId($id);
        $estadReg = $datosUsuario['Usuario']['estadoregistro_id'];
        if ($estadReg == 2) {
            $newEst = 1;
        } else {
            $newEst = 2;
        }
        if ($this->Usuario->updateAll(array('estadoregistro_id' => $newEst, 'num_intentos' => 0), array('id' => $id))) {
            
            /*Se realiza el registro en auditoria para el usuario activado*/
            $accionAud = $this->Auditoria->accionAuditoria('6');
            $arrDescripcionAud['nombre'] = $datosUsuario['Usuario']['nombre'];
            $arrDescripcionAud['identificacion'] = $datosUsuario['Usuario']['identificacion'];
            $arrDescripcionAud['username'] = $datosUsuario['Usuario']['username'];
            $arrDescripcionAud['estado'] = "Activa";
            $descripcionAud = $this->Auditoria->descripcionAuditoria('5', $arrDescripcionAud);
            $this->Auditoria->logAuditoria($this->Auth->user('id'), $descripcionAud, $accionAud);
            
            //Se realiza la gestion para el envio del correo al administrador.  
//            $utilidad = new UtilidadesController();
//            $utilidad->send_mail(
//                    $utilidad->asuntoCorreo(2), 
//                    $datosUsuario['Usuario']['nombre'], 
//                    $datosUsuario['Usuario']['correoelectronico'], 
//                    $descripcionAud
//            ); 
            $this->Session->setFlash(__('Se ha cambiado el estado del Usuario'));
            return $this->redirect(array('action' => 'index'));
        } else {
            $this->Session->setFlash(__('Se produjo un error, intentelo de nuevo'));
        }
    }

    public function login() {

        $this->loadModel('Auditoria');
        if ($this->request->is('post')) {
            $username = $this->request->data['Usuario']['username'];
            $datosUser = $this->Usuario->find('first', array('conditions' => array('Usuario.username' => $username), 'recursive' => -1));            
            $tamArray = count($datosUser);
            if ($tamArray == 0) {
                $this->Session->setFlash(__('El usuario no existe'));
            } else {
                foreach ($datosUser as $key => $value) {
                    $id = $value['id'];
                    $numIntentos = $value['num_intentos'];
                    $estado = $value['estadoregistro_id'];
                    break;
                }
                if ($estado == 1) {
                    if ($this->Auth->login()) {
                        $this->Usuario->updateAll(
                                array('num_intentos' => 0), array('usuario.id' => $id)
                        );
                        $this->redirect(array('action' => 'paginainicio')); // Se redirecciona al index de usuarios
                    } else {
                        if ($numIntentos == 2) {
                            $this->Usuario->updateAll(
                                    array('estadoregistro_id' => 2), array('id' => $id)
                            );
                            
                            
                            /*Se realiza el registro en auditoria para el usuario inactivado*/
                            $accionAud = $this->Auditoria->accionAuditoria('7');
                            $arrDescripcionAud['nombre'] = $datosUser['Usuario']['nombre'];
                            $arrDescripcionAud['identificacion'] = $datosUser['Usuario']['identificacion'];
                            $arrDescripcionAud['username'] = $datosUser['Usuario']['username'];
                            $arrDescripcionAud['estado'] = "Bloquea";
                            $descripcionAud = $this->Auditoria->descripcionAuditoria('5', $arrDescripcionAud);
                            $this->Auditoria->logAuditoria($datosUser['Usuario']['id'], $descripcionAud, $accionAud);   

                            $this->Session->setFlash(__('Su usuario ha sido bloqueado por 3 intentos fallidos de autenticacion, se le notificara cuando quede activo'));
                        } else {
                            $this->Usuario->updateAll(
                                    array('num_intentos' => $numIntentos + 1), array('id' => $id)
                            );
                            $this->Session->setFlash(__('Contraseña y/o el nombre de usuario incorrectos. Por favor, intente de nuevo'));
                        }
                    }
                } else {
                    $this->Session->setFlash(__('Usuario bloqueado, no puede loguearse.Por favor contactar al administrador'));
                }
            }
        }
        if ($this->Session->check('Auth.User')) {
            $this->redirect(array('action' => 'index'));
        }
    }

    public function beforeFilter() {
        parent::beforeFilter();
        Security::setHash('md5');
    }

    public function logout() {
        return $this->redirect($this->Auth->logout());
    }

    //Pagina inicial que se le muestra al usuario.
    public function paginainicio() {
        //Pagina de inicio que se muestra a los usuarios
    }

    public function isAuthorized($user) {
        return true;
    }

    public function relacionoficinausuario($id = null) {
        if ($this->request->is('post')) {
            $oficinas = $this->request->data['Oficina']['Oficina'];
            
            //Se obtienen las oficinas que ya tiene asignadas el usuario
            $this->loadModel('OficinasUsuario');
            
            //Se obtiene un listado de Id de las oficinas asociadas a un usuario
            $arrOficinas = $this->OficinasUsuario->obtenerOficinasUsuario($id);
            foreach($arrOficinas as $clv => $val){
                $arrIdReg[$clv] = $val['OficinasUsuario']['oficina_id'];
            }

            //Se recorre el arreglo para asociar las regionales al usuario pero se descartan las que ya tiene asociadas
            for ($i = 0; $i < count($oficinas); $i++) {
                if (in_array($oficinas[$i], $arrIdReg)) {
                    continue;
                } else {
                    $this->OficinasUsuario->saveOficinaUsuario($id, $oficinas[$i]);
                }
            }
            $this->Session->setFlash(__('Se realizó el registro de oficinas para el usuario'));
            return $this->redirect(array('action' => 'relacionoficinausuario/' . $id));
        }       

        //Se obtienen informacion de las oficinas que el usuario tiene relacionadas
        $this->loadModel('OficinasUsuario'); 
        $oficinas = $this->OficinasUsuario->obtenerOficinasUsuario($id); 

        //Se carga el listado de regionales existentes en la aplicación para crear el select y gestionar los permisos correspondientes
        $this->loadModel('Regionale');
        $regionales = $this->Regionale->find('list', array('conditions' => array('Regionale.estadoregistro_id' => 1)));
       
        $arrOficinasUsuarios = $this->OficinasUsuario->listaOficinasUsuario($id);   
        
        $arrInfoUsuario = $this->Usuario->obtenerUsuarioPorId($id);

        $this->set(compact('regionales', 'oficinas', 'arrOficinasUsuarios', 'arrInfoUsuario'));
    }

    public function ordenarItemsMenu($arrMenuPerfil){    

        $this->loadModel('Configuraciondato');
        $urlRaizProyDesarrollo = $this->Configuraciondato->obtenerInfo("url_raizproyserver");

        $menu = array();
        foreach($arrMenuPerfil as $key => $val) {
            if(empty($val['Menu']['menu_id'])) {
                $menu[$val['Menu']['id']]['descMenu'] =  $val['Menu']['descripcion'];
                $menu[$val['Menu']['id']]['urlMenu'] =  !empty($val['Menu']['url'])  ? $urlRaizProyDesarrollo . $val['Menu']['url'] : "";
            } else {
                $menu[$val['Menu']['menu_id']]['submenu'][$val['Menu']['id']]['descripcion'] = $val['Menu']['descripcion'];
                $menu[$val['Menu']['menu_id']]['submenu'][$val['Menu']['id']]['url'] = !empty($val['Menu']['url'])  ? $urlRaizProyDesarrollo . $val['Menu']['url'] : "";
            }
        }

        return $menu;
    }

    public function generarMenuDinamico() {
        $this->loadModel('Menu');
        $perfil = $this->request->data('perfil');

        $join = array(array('table' => 'menus_perfiles', 'type' => 'INNER', 'alias' => 'MP',
                'conditions' => array('MP.menu_id = Menu.id', 'MP.perfile_id = ' . $perfil)));

        $arrMenuPerfil = $this->Menu->find('all', array('order' => array('Menu.id'), 'joins' => $join, 'recursive' => -1));

        $strDibujoMenu = "";
        if(count($arrMenuPerfil) > 0){
            $strDibujoMenu = $this->dibujarMenu($this->ordenarItemsMenu($arrMenuPerfil));            
        }
        print_r($strDibujoMenu);

        exit();
    }

    public function dibujarMenu($arrMenuPerfil) { 
        
        $strMenu = "";

        foreach ($arrMenuPerfil as $submenus) {
 
            if(!isset($submenus['descMenu'])) {
                continue;
            } else {
                $strMenu .= "<li><a href='" . $submenus['urlMenu'] . "'> <span>" . $submenus['descMenu'] . "</span></a>";

                if(isset($submenus['submenu'])){
                    $strMenu .= "<ul>";
                    foreach( $submenus['submenu'] as $subme) {
                        $strMenu .= "<li><a href='" . $subme['url'] . "'> <span>" . $subme['descripcion'] . "</span></a></li>";
                    }
                    $strMenu .= "</ul>";
                }

            }
        }
        
        $strMenu .= "</li>";

        return $strMenu;
    }
    
    public function usercambiocontrasenia() {

        $userSess = $this->Auth->user('id');

        if ($this->request->is(array('post', 'put'))) {
            $dataUsuario = $this->Usuario->obtenerUsuarioPorId($userSess);
            $prePass = $dataUsuario['Usuario']['password'];
            $prePassV = $this->request->data['Usuario']['passwordAnt'];
            $newPass = $this->request->data['Usuario']['password'];
            $newPassConf = $this->request->data['Usuario']['contraseniaConf'];
            $passCript = AuthComponent::password($prePassV);
            if ($prePass == $passCript) {
                if ($newPass == $newPassConf) {
                    $newCript = AuthComponent::password($newPass);
                    $this->Usuario->updateAll(
                            array('password' => "'$newCript'"), array('Usuario.id' => $userSess));
                    $this->Session->setFlash(__('Contraseña Actualizada.'));
                    return $this->redirect(array('action' => 'paginainicio'));
                } else {
                    $mensaje = "La contraseña nueva no coincide con la del campo de confirmacion.";
                    $this->set(compact('mensaje'));
                }
            } else {
                $mensaje = "La contraseña anterior ingresada no es correcta.";
                $this->set(compact('mensaje'));
            }
        }
        
        $this->set('usuario_id',$userSess);
        
    }
    
    public function validarcontrasenaantes(){
        
        $this->layout="ajax";
        $this->autoRender=false;
        $response=array();
        $response['estado']=false;
        $response['valido']=false;
        
        if($this->request->is("post")){
            
            $usuario=$this->request->data("usuario");
            $contrasena=$this->request->data("contrasenaAnt");
            
            if(!empty($usuario) && !empty($contrasena)){
                $response['estado']=true;
                $response['valido']=$this->Usuario->validarcontrasenaanterior($usuario,$contrasena);
            }
        }
        
        echo json_encode($response);
    }    
    
    public function admcontrasenia($usuarioId = null){
        $this->loadModel('Usuario');
        $datosUsuario = $this->Usuario->obtenerUsuarioPorId($usuarioId);
        $nombreUsuario = $datosUsuario['Usuario']['nombre'];          

        $this->set(compact('nombreUsuario', 'usuarioId'));   

        if ($this->request->is(array('post', 'put'))) {
            $id = $this->request->data['Usuario']['idUsuario'];
            $newPass = $this->request->data['Usuario']['password'];
            $newPassEnc = AuthComponent::password($newPass);
            $this->Usuario->updateAll(
                    array('Usuario.password' => "'$newPassEnc'"),
                    array('Usuario.id' => $id));
            //$this->send_mail($id); 
            $this->Session->setFlash(__('Password Actualizado.'));
            return $this->redirect(array('action' => 'listausuariosadmcontrasenia'));
        }		
    }
    
       public function searchAdmContrasenia() {
		// the page we will redirect to
		$url=array();
            
                $url['action'] = 'listausuariosadmcontrasenia';
                    
		foreach ($this->data as $k=>$v){
                    if($k!='Usuario'){
			foreach ($v as $kk=>$vv){ 
				$url[$k.'.'.$kk]=$vv; 
			} 
                   }
		}
		// redirect the user to the url
		$this->redirect($url, null, true);
	} 
        
        public function listausuariosadmcontrasenia(){

            $paginate=array();
            if(isset($this->passedArgs['Search.Nombre']) && !empty($this->passedArgs['Search.Nombre'])) {
                $paginate['Usuario.nombre LIKE'] = '%'.$this->passedArgs['Search.Nombre']."%";                        			
            }                
            if(isset($this->passedArgs['Search.Identificacion']) && !empty($this->passedArgs['Search.Identificacion'])) {
                $paginate['Usuario.identificacion LIKE'] = '%'.$this->passedArgs['Search.Identificacion']."%";                        			
            }                
            $this->Usuario->recursive = 0;		
                
            if(empty($paginate)){
                $this->set('usuarios', $this->Paginator->paginate());                           
            }else{
                $this->set('usuarios', $this->Paginator->paginate('Usuario',$paginate));                           
            }
	}     
        
        public function listausuarios(){
            $this->loadModel('OficinasUsuario');
            
            $usuarioId = $this->Auth->user('id');
            
            //se obtienen las oficinas a las cuales el usuario tiene permiso
            $arrOficinas = $this->OficinasUsuario->obtenerOficinasUsuario($usuarioId);
            
            for($i = 0; $i < count($arrOficinas); $i++){
                $arrOficinasId[$i] = $arrOficinas[$i]['OficinasUsuario']['oficina_id'];
            }

            //Se obtienen los usuarios que tienen permisos sobre las oficinas consultadas
            $arrUsuarios = $this->Usuario->obtenerUsuariosPorOficinaId($arrOficinasId);

            $this->set(compact('arrUsuarios'));
            
        }
        
        public function agregarPermisosPerfil($perfilId,$usuarioId){
		
            $this->loadModel('Permisousuariobandeja');
            $this->loadModel('PrivilegiosUsuario');
            $this->autoRender=false;
           
            /*Se obtiene un usuario con perfil similar al nuevo usuario*/
            $arrUsuario = $this->Usuario->obtenerUsuarioPorPerfil($perfilId);
			
			/*Se borran los permisos y las bandejas que tiene el usuario actualmente sobre as bandejas asignadas.*/
			$this->Permisousuariobandeja->eliminarPermisoBandejaUsuario($usuarioId);

            /*Se obtienen los permisos que el usuario consultado tiene por bandejas*/
            $arrPermUB = $this->Permisousuariobandeja->obtenerPermisoXUsuario($arrUsuario['0']['Usuario']['id']);
            
            /*Se asignan los permisos sobre bandejas del usuario consultado al nuevo creado*/
            foreach($arrPermUB as $permiso){
                $this->Permisousuariobandeja->agregarPermisoBandejasUsuario($permiso['Bandeja']['id'], $usuarioId, $permiso['Permisobandeja']['id']);
            }
            
            /*Se obtienen los privilegios que tiene el usuario consultado*/
            $arrPrivilegios = $this->PrivilegiosUsuario->obtenerPrivilegiosPorUsuarioId($arrUsuario['0']['Usuario']['id']);
            
            /*Se asignan los privilegios del usuario consultado al usuario nuevo*/
            foreach($arrPrivilegios as $privilegio){
                $this->PrivilegiosUsuario->agregarPrivilegiosUsuario($privilegio['PrivilegiosUsuario']['privilegio_id'], $usuarioId);
            } 
        }
}
