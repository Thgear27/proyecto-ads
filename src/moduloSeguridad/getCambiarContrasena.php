<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'] . '/shared/viewMessageSistema.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/moduloSeguridad/formCambiarContrasena.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/moduloSeguridad/controlCambiarContrasena.php');


if (!isset($_SESSION['autenticado'])) {
  header('Location: /');
  exit();
}

$nombreCampoErroneo = '';
$mensajeError = '';

function validarBoton($btnCambiarContrasena)
{
  return isset($btnCambiarContrasena);
}

function validarCampos($txtContrasenaNueva, $txtContrasenaNuevaConfirmacion, $txtContrasenaActual)
{
  global $nombreCampoErroneo, $mensajeError;
  if (strlen($txtContrasenaNueva) < 4 || empty($txtContrasenaNueva)) {
    $nombreCampoErroneo = 'Contraseña Nueva';
    $mensajeError = 'El campo ' . $nombreCampoErroneo . ' tener al menos 4 caracteres';
    return false;
  } else if (strlen($txtContrasenaNuevaConfirmacion) < 4 || empty($txtContrasenaNuevaConfirmacion)) {
    $nombreCampoErroneo = 'Contraseña Nueva Confirmación';
    $mensajeError = 'El campo ' . $nombreCampoErroneo . ' tener al menos 4 caracteres';
    return false;
  } else if (strlen($txtContrasenaActual) < 4 || empty($txtContrasenaActual)) {
    $nombreCampoErroneo = 'Contraseña Actual';
    $mensajeError = 'El campo ' . $nombreCampoErroneo . ' tener al menos 4 caracteres';
    return false;
  }
  return true;
}

function recuperarDatosUsuarioSesion()
{
  return $_SESSION['email'];
}

function validarCoincidenciaContrasenas($txtContrasenaNueva, $txtContrasenaNuevaConfirmacion)
{
  global $mensajeError;
  if ($txtContrasenaNueva != $txtContrasenaNuevaConfirmacion) {
    $mensajeError = 'Error, las contraseñas no coindicen';
    return false;
  }
  return true;
}

$btnRegistrarse = $_POST['btnCambiarContrasena'];

if (validarBoton($btnRegistrarse)) {
  $txtContrasenaNueva = trim($_POST['contrasenaNueva']);
  $txtContrasenaNuevaConfirmacion = trim($_POST['contrasenaNuevaConfirmacion']);
  $txtContrasenaActual = trim($_POST['contrasenaActual']);

  if (validarCampos($txtContrasenaNueva, $txtContrasenaNuevaConfirmacion, $txtContrasenaActual)) {
    //OBTENIENDO DATOS DE LA SESION
    $txtEmail = recuperarDatosUsuarioSesion();
    if (validarCoincidenciaContrasenas($txtContrasenaNueva, $txtContrasenaNuevaConfirmacion)) {
      $controlCambiarContrasenaObject = new controlCambiarContrasena();
      $controlCambiarContrasenaObject->validarContrasenaUsuario($txtContrasenaActual, $txtEmail, $txtContrasenaNueva);
    } else {
      $formCambiarContrasenaObject = new formCambiarContrasena();
      $formCambiarContrasenaObject->formCambiarContrasenaShow();

      $viewMessageSistemaObject = new viewMessageSistema();
      $viewMessageSistemaObject->viewMessageSistemaShow('error', 'Error', $mensajeError);
    }
  } else {
    $formCambiarContrasenaObject = new formCambiarContrasena();
    $formCambiarContrasenaObject->formCambiarContrasenaShow();

    $viewMessageSistemaObject = new viewMessageSistema();
    $viewMessageSistemaObject->viewMessageSistemaShow('error', 'Campo invalido', $mensajeError);
  }
} else {
  $formCambiarContrasenaObject = new formCambiarContrasena();
  $formCambiarContrasenaObject->formCambiarContrasenaShow();

  $viewMessageSistemaObject = new viewMessageSistema();
  $viewMessageSistemaObject->viewMessageSistemaShow('error', 'Error', 'No se ha enviado el formulario');
}
