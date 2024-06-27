<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/modelos/usuario.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/moduloSeguridad/formAutenticarUsuario.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/shared/viewMessageSistema.php');

class controlAutenticarUsuario
{
  public function validarUsuario($txtEmail, $txtContrasena)
  {
    session_start();
    $objUsuario = new Eusuario();
    $respuesta = $objUsuario->validarUsuario($txtEmail);

    if ($respuesta == null) {
      $formAutenticarUsuario = new formAutenticarUsuario();
      $formAutenticarUsuario->formAutenticarUsuarioShow();

      $viewMessageSistemaObject = new viewMessageSistema();
      $viewMessageSistemaObject->viewMessageSistemaShow('error', 'Error', 'No se encontró el usuario');
    } else {
      $respuesta = $objUsuario->validarContrasenaUsuario($txtEmail, $txtContrasena);
      if ($respuesta == null) {
        $formAutenticarUsuario = new formAutenticarUsuario();
        $formAutenticarUsuario->formAutenticarUsuarioShow();

        $viewMessageSistemaObject = new viewMessageSistema();
        $viewMessageSistemaObject->viewMessageSistemaShow('error', 'Error', 'Contraseña incorrecta');
      } else {
        $respuesta = $objUsuario->validarEstado($txtEmail);
        if ($respuesta == null) {
          echo "Usuario inactivo";
          $formAutenticarUsuario = new formAutenticarUsuario();
          $formAutenticarUsuario->formAutenticarUsuarioShow();

          $viewMessageSistemaObject = new viewMessageSistema();
          $viewMessageSistemaObject->viewMessageSistemaShow('error', 'Error', 'Usuario inactivo');
        } else {
          $formAutenticarUsuario = new formAutenticarUsuario();
          $formAutenticarUsuario->formAutenticarUsuarioShow();

          echo "Usuario autenticado correctamente";

          $viewMessageSistemaObject = new viewMessageSistema();
          $viewMessageSistemaObject->viewMessageSistemaShow('success', 'Usuario Autenticado', 'Usuario autenticado correctamente');
        }
      }
    }
  }
}
