<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'] . '/moduloSeguridad/formAutenticarUsuario.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/moduloSeguridad/controlAutenticarUsuario.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/shared/viewMessageSistema.php');

function validarBoton($boton)
{
  return isset($boton);
}
function validarCamposLogin($txtEmail, $txtContrasena)
{
  return (strlen($txtEmail) > 3 and strlen($txtContrasena) > 3);
}

$btnSubmit = $_POST['btnSubmit'];

if (validarBoton($btnSubmit)) {
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $txtEmail = filter_input(INPUT_POST, 'txtEmail', FILTER_SANITIZE_EMAIL);
    $txtContrasena = $_POST['txtContrasena'];

    if (validarCamposLogin($txtEmail, $txtContrasena)) {
      $controlAutenticarUsuarioObj = new controlAutenticarUsuario();
      $controlAutenticarUsuarioObj->validarUsuario($txtEmail, $txtContrasena);
    } else {
      $formAutenticarUsuario = new formAutenticarUsuario();
      $formAutenticarUsuario->formAutenticarUsuarioShow();

      $viewMessageSistemaObject = new viewMessageSistema();
      $viewMessageSistemaObject->viewMessageSistemaShow('error', 'Campos inválidos', 'Los campos deben tener al menos 4 caracteres');
    }
  }
} else {
  $formAutenticarUsuario = new formAutenticarUsuario();
  $formAutenticarUsuario->formAutenticarUsuarioShow();

  $viewMessageSistemaObject = new viewMessageSistema();
  $viewMessageSistemaObject->viewMessageSistemaShow('error', 'Acceso denegado', 'No se ha enviado el formulario');
}
