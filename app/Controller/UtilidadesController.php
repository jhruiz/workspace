<?php

App::uses('AppController', 'Controller');
include_once("..//Model/class.smtp.php");
require_once 'Swift-4.2.1/lib/swift_required.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UtilidadesController
 *
 * @author AdminRoot
 */
class UtilidadesController extends AppController {

    //put your code here

    public static function send_mail($subject, $nombreUsuario, $correoUsuario, $body) {

        if(is_null($correoUsuario) || $correoUsuario == ""){
            //ingresa si el usuario no tiene correo
        }else{
            //configuracion de la cuenta
            $objCuentaUtilizada = Array(
                'smtp' => 'smtp.gmail.com', //'msa.coomeva.com.co', //		//direccion del smtp
                'puerto' => 25, //puerto smtp
                'nombre' => 'Administrador del sistema', //nombre que aparecera en los correos
                'cuenta' => 'jaiber.ruiz@correounivalle.edu.co', //cuenta que vamos a usar (colocar con @)
                'usuario' => 'jaiber.ruiz@correounivalle.edu.co', //usuario de smtp
                'contrasena' => 'Diosesmiguia9002' //contrasena de smtp
            );

            //creamos el nuevo transporte de Swift con los datos de conexion
            $objTransporte = Swift_SmtpTransport::newInstance($objCuentaUtilizada['smtp'], $objCuentaUtilizada['puerto'])
                    ->setUsername($objCuentaUtilizada['usuario'])  //le indicamos el usuario smtp que vamos a usar
                    ->setPassword($objCuentaUtilizada['contrasena']) //contrasena del usuario smtp
            ;

            //instanciamos el mailer con los datos de conexion establecidos anteriormente
            $objMailer = Swift_Mailer::newInstance($objTransporte);

            //creamos el mensaje
            $objMensaje = Swift_Message::newInstance($subject)       //asunto del mensaje
                    ->setFrom(array($objCuentaUtilizada['cuenta'] => $objCuentaUtilizada['nombre'])) //quien esta enviando el mensaje?
                    ->setTo(array($correoUsuario => $nombreUsuario))        //a quien le enviamos el mensaje?
                    ->setBody($body)     //cuerpo del mensaje	
                    ->setContentType('text/html')              //mensaje en formato HTML
            ;
            //enviamos el mensaje
            if ($objMailer->send($objMensaje)) {
    //					echo 'El mensaje se envi&oacute; correctamente!';
            } else {
    //					echo 'El mensaje no fue enviado!';
            }
            
        }
    }

    public function asuntoCorreo($id) {
        $asuntoCorreo = "";
        if ($id == 0) {
            $asuntoCorreo = "Devolucion de Solicitud";
        }

        if ($id == 1) {
            $asuntoCorreo = "Usuario Bloqueado";
        }
        
        if ($id == 2) {
            $asuntoCorreo = "Usuario Desbloqueado";
        }
        

        return $asuntoCorreo;
    }

    public function mensajeCorreo($id) {
        $mensajeCorreo = "";
        if ($id == 0) {
            $mensajeCorreo = "Se ha rechazado el paquete con numero de oficio: ";
        }

        if ($id == 1) {
            $mensajeCorreo = "El usuario ha sido bloqueado. Id y nombre de usuario: ";
        }

        if ($id == 2) {
            $mensajeCorreo = "El usuario ha sido desbloqueado.";
        }        
        return $mensajeCorreo;
    }

}
