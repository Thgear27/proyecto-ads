<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'] . '/moduloSeguridad/formAutenticarUsuario.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/moduloSeguridad/controlAutenticarUsuario.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/shared/viewMessageSistema.php');


$nombreCampoErroneo = '';
$mensajeError = '';

function validarBoton($boton)
{
  return isset($boton);
}

function validarCamposLogin($txtEmail, $txtContrasena)
{
  global $nombreCampoErroneo, $mensajeError;
  if (!filter_var($txtEmail, FILTER_VALIDATE_EMAIL)) {
    $nombreCampoErroneo = 'Email';
    $mensajeError = 'El campo ' . $nombreCampoErroneo . ' debe tener un formato de email válido';
    return false;
  } else if (strlen($txtContrasena) < 4 || empty($txtContrasena)) {
    $nombreCampoErroneo = 'Contraseña';
    $mensajeError = 'El campo ' . $nombreCampoErroneo . ' tener al menos 4 caracteres';
    return false;
  }
  return true;
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
      $viewMessageSistemaObject->viewMessageSistemaShow('error', 'Campo inválido', $mensajeError);
    }
  }
} else {
  $formAutenticarUsuario = new formAutenticarUsuario();
  $formAutenticarUsuario->formAutenticarUsuarioShow();

  $viewMessageSistemaObject = new viewMessageSistema();
  $viewMessageSistemaObject->viewMessageSistemaShow('error', 'Acceso denegado', 'No se ha enviado el formulario');
}
