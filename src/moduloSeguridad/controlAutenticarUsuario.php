<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/modelos/Eusuario.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/moduloSeguridad/formAutenticarUsuario.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/moduloSeguridad/panelPrincipalSistema.php');
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
          $_SESSION['email'] = $txtEmail;
          $_SESSION['rol'] = $objUsuario->verificarRol($txtEmail);
          $_SESSION['autenticado'] = "SI";

          header('Location: /moduloSeguridad/indexPanelPrincipal.php');

          // $panelPrincipalObject = new panelPrincipalSistema();
          // $panelPrincipalObject->panelPrincipalSistemaShow();

          // $viewMessageSistemaObject = new viewMessageSistema();
          // $viewMessageSistemaObject->viewMessageSistemaShow('success', 'Usuario Autenticado', 'Usuario autenticado correctamente', '/moduloSeguridad/indexPanelPrincipal.php');
        }
      }
    }
  }
}
