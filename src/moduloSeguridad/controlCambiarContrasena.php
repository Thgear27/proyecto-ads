<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/modelos/Eusuario.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/shared/viewMessageSistema.php');

class controlCambiarContrasena
{

  function limpiarDatosSesion()
  {
    session_destroy();
  }

  function validarContrasenaUsuario($txtContrasenaActual, $txtEmail, $txtContrasenaNueva)
  {
    $objUsuario = new Eusuario();
    $resultado = $objUsuario->validarContrasenaUsuario($txtEmail, $txtContrasenaActual);
    if ($resultado == null) {
      $formCambiarContrasena = new formCambiarContrasena();
      $formCambiarContrasena->formCambiarContrasenaShow();

      $viewMessageSistemaObject = new viewMessageSistema();
      $viewMessageSistemaObject->viewMessageSistemaShow('error', 'Error', 'Error la contraseña no coincide con la del usuario');
    } else {
      $objUsuario->actualizarContrasenaUsuario($txtEmail, $txtContrasenaNueva);
      $this->limpiarDatosSesion();
      //MOSTRAR INDEX 
      header('Location: /index.php');
    }
  }
}
