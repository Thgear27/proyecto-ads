<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'] . '/shared/viewMessageSistema.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/moduloSeguridad/formBuscarUsuario.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/moduloSeguridad/controlReestablecerContrasena.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/moduloSeguridad/formCodigoSeguridad.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/moduloSeguridad/formReestablecerContrasena.php');

$nombreCampoErroneo = '';
$mensajeError = '';

function validarBoton($boton)
{
  return isset($boton);
}

function validarCampoEmail($txtEmail)
{
  if (!filter_var($txtEmail, FILTER_VALIDATE_EMAIL)) {
    return false;
  }
  return true;
}

function validarCoincidenciaContrasenas($txtContrasenaNueva, $txtContrasenaNuevaConfirmacion)
{
  if ($txtContrasenaNueva != $txtContrasenaNuevaConfirmacion) {
    return false;
  }
  return true;
}

function validarContrasenas($txtContrasenaNueva, $txtContrasenaNuevaConfirmacion)
{
  global $mensajeError;

  if (strlen($txtContrasenaNueva) < 4) {
    $mensajeError = 'El campo contraseña nueva debe tener al menos 4 caracteres';
    return false;
  } else if (strlen($txtContrasenaNuevaConfirmacion) < 4) {
    $mensajeError = 'El campo de la confirmación de la contraseña nueva debe tener al menos 4 caracteres';
    return false;
  }
  return true;
}

function validarCodigoSeguridad($txtCodigoSeguridad, $txtCodigoSeguridadEnviado)
{
  if ($txtCodigoSeguridad != $txtCodigoSeguridadEnviado) {
    return false;
  }
  return true;
}

$btnAceptar = $_POST['btnBuscarUsuario'];
$btnCodigoSeguridad = $_POST['btnCodigoSeguridad'];
$btnReestablecerContrasena = $_POST['btnReestablecerContrasena'];

if (validarBoton($btnAceptar)) {
  $txtEmail = htmlspecialchars($_POST['txtEmail'], ENT_QUOTES, 'UTF-8');

  if (validarCampoEmail($txtEmail)) {
    $controlReestablecerContrasenaObject = new controlReestablecerContrasena();
    $controlReestablecerContrasenaObject->buscarUsuario($txtEmail);
  } else {
    $formBuscarUsuarioObject = new formBuscarUsuario();
    $formBuscarUsuarioObject->formBuscarUsuarioShow();

    $viewMessageSistemaObject = new viewMessageSistema();
    $viewMessageSistemaObject->viewMessageSistemaShow('error', 'Error', 'El email ingresado no es válido');
  }
} elseif (validarBoton($btnCodigoSeguridad)) {
  $txtCodigoSeguridad = htmlspecialchars($_POST['txtCodigoSeguridad'], ENT_QUOTES, 'UTF-8');
  $codigoSeguridadEnviado = "1234"; // TODO: Cambiar por el código enviado por email

  if (validarCodigoSeguridad($txtCodigoSeguridad, $codigoSeguridadEnviado)) {
    $controlReestablecerContrasenaObject = new controlReestablecerContrasena();
    $controlReestablecerContrasenaObject->mostrarFormularioReestablecer();
  } else {
    $formCodigoSeguridadObject = new formCodigoSeguridad();
    $formCodigoSeguridadObject->formCodigoSeguridadShow();

    $viewMessageSistemaObject = new viewMessageSistema();
    $viewMessageSistemaObject->viewMessageSistemaShow('error', 'Error', 'El código de seguridad ingresado no es válido');
  }
} elseif (validarBoton($btnReestablecerContrasena)) {
  $txtContrasenaNueva = htmlspecialchars($_POST['contrasenaNueva'], ENT_QUOTES, 'UTF-8');
  $txtContrasenaNuevaConfirmacion = htmlspecialchars($_POST['contrasenaNuevaConfirmacion'], ENT_QUOTES, 'UTF-8');

  if (validarContrasenas($txtContrasenaNueva, $txtContrasenaNuevaConfirmacion)) {
    if (validarCoincidenciaContrasenas($txtContrasenaNueva, $txtContrasenaNuevaConfirmacion)) {
      $txtEmail = $_SESSION['email'];
      $controlReestablecerContrasenaObject = new controlReestablecerContrasena();
      $controlReestablecerContrasenaObject->reestablecerContrasena($txtEmail, $txtContrasenaNueva);
    } else {
      $formReestablecerContrasenaObject = new formReestablecerContrasena();
      $formReestablecerContrasenaObject->formReestablecerContrasenaShow();

      $viewMessageSistemaObject = new viewMessageSistema();
      $viewMessageSistemaObject->viewMessageSistemaShow('error', 'Error', 'Las contraseñas no coinciden');
    }
  } else {
    $formReestablecerContrasenaObject = new formReestablecerContrasena();
    $formReestablecerContrasenaObject->formReestablecerContrasenaShow();

    $viewMessageSistemaObject = new viewMessageSistema();
    $viewMessageSistemaObject->viewMessageSistemaShow('error', 'Error', $mensajeError);
  }
} else {
  $formBuscarUsuarioObject = new formBuscarUsuario();
  $formBuscarUsuarioObject->formBuscarUsuarioShow();

  $viewMessageSistemaObject = new viewMessageSistema();
  $viewMessageSistemaObject->viewMessageSistemaShow('error', 'Error', 'No se ha enviado el formulario');
}
