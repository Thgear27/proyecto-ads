<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/modelos/Eusuario.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/shared/viewMessageSistema.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/moduloSeguridad/formCodigoSeguridad.php');

class controlReestablecerContrasena
{
  function  reestablecerContrasena($txtEmail, $txtContrasenaNueva)
  {
    $objUsuario = new Eusuario();
    $objUsuario->actualizarContrasenaUsuario($txtEmail, $txtContrasenaNueva);
    header('Location: /index.php');
  }

  function mostrarFormularioReestablecer()
  {
    $formReestablecerContrasena = new formReestablecerContrasena();
    $formReestablecerContrasena->formReestablecerContrasenaShow();
  }

  function buscarUsuario($txtEmail)
  {
    $objUsuario = new Eusuario();
    $resultado = $objUsuario->buscarUsuarioPorEmail($txtEmail);

    if ($resultado == null) {
      $formBuscarUsuario = new formBuscarUsuario();
      $formBuscarUsuario->formBuscarUsuarioShow();

      $viewMessageSistemaObject = new viewMessageSistema();
      $viewMessageSistemaObject->viewMessageSistemaShow('error', 'Error', 'El email ingresado no se encuentra registrado');
    } else {
      $_SESSION['email'] = $txtEmail;

      // TODO: Enviar codigo por email

      $formCodigoSeguridadOject = new formCodigoSeguridad();
      $formCodigoSeguridadOject->formCodigoSeguridadShow();
    }
  }
}
