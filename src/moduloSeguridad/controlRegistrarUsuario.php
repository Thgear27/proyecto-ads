<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/modelos/Eusuario.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/moduloSeguridad/formRegistrarUsuario.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/moduloSeguridad/panelPrincipalSistema.php');

class controlRegistrarUsuario
{
  function registrarUsuario($txtNombre, $txtApePaterno, $txtApeMaterno, $txtEmail, $txtContrasena, $txtTelefono, $id_rol)
  {
    $objUsuario = new Eusuario();
    $respuesta = $objUsuario->buscarUsuarioPorEmail($txtEmail);
    if ($respuesta != null) {
      $formRegistrarUsuario = new formRegistrarUsuario();
      $formRegistrarUsuario->formRegistrarUsuarioShow();

      $viewMessageSistemaObject = new viewMessageSistema();
      $viewMessageSistemaObject->viewMessageSistemaShow('error', 'Error', 'Existe un usuario con el mismo email');
    } else {
      $respuesta = $objUsuario->guardarUsuario($txtNombre, $txtApePaterno, $txtApeMaterno, $txtEmail, $txtContrasena, $txtTelefono, $id_rol);
      if ($respuesta == null) {
        $formRegistrarUsuario = new formRegistrarUsuario();
        $formRegistrarUsuario->formRegistrarUsuarioShow();

        $viewMessageSistemaObject = new viewMessageSistema();
        $viewMessageSistemaObject->viewMessageSistemaShow('error', 'Error', 'Hubo un error mientras registrabamos al nuevo usuario');
      } else {
        $panelPrincipalObject = new panelPrincipalSistema();
        $panelPrincipalObject->panelPrincipalSistemaShow();

        $viewMessageSistemaObject = new viewMessageSistema();
        $viewMessageSistemaObject->viewMessageSistemaShow('success', 'Registro exitoso', 'Usuario registrado correctamente');
      }
    }
  }
}
