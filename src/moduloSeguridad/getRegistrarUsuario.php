<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'] . '/shared/viewMessageSistema.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/moduloSeguridad/formRegistrarUsuario.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/moduloSeguridad/controlRegistrarUsuario.php');

if (!isset($_SESSION['autenticado'])) {
  header('Location: /');
  exit();
}

$rol = $_SESSION['rol'];

if ($rol != "administrador") {
  header('Location: /moduloSeguridad/indexPanelPrincipal.php');
  exit();
}

$nombreCampoErroneo = '';
$mensajeError = '';

function validarBoton($btnRegistrarse)
{
  return isset($btnRegistrarse);
}

function validarCampos($txtNombre, $txtApePaterno, $txtApeMaterno, $txtEmail, $txtContrasena, $txtTelefono, $id_rol)
{
  global $nombreCampoErroneo, $mensajeError;

  if (empty($txtNombre) || strlen($txtNombre) < 4) {
    $nombreCampoErroneo = 'Nombre';
    $mensajeError = 'El campo ' . $nombreCampoErroneo . ' tener al menos 4 caracteres';
    return false;
  } elseif (empty($txtApePaterno) || strlen($txtApePaterno) < 4) {
    $nombreCampoErroneo = 'Apellido Paterno';
    $mensajeError = 'El campo ' . $nombreCampoErroneo . ' tener al menos 4 caracteres';
    return false;
  } elseif (empty($txtApeMaterno) || strlen($txtApeMaterno) < 4) {
    $nombreCampoErroneo = 'Apellido Materno';
    $mensajeError = 'El campo ' . $nombreCampoErroneo . ' tener al menos 4 caracteres';
    return false;
  } elseif (!filter_var($txtEmail, FILTER_VALIDATE_EMAIL)) {
    $nombreCampoErroneo = 'Email';
    $mensajeError = 'El email no es válido';
    return false;
  } elseif (empty($txtContrasena) || strlen($txtContrasena) < 4) {
    $nombreCampoErroneo = 'Contraseña';
    $mensajeError = 'El campo ' . $nombreCampoErroneo . ' tener al menos 4 caracteres';
    return false;
  } elseif (empty($txtTelefono) || strlen($txtTelefono) < 4) {
    $nombreCampoErroneo = 'Telefono';
    $mensajeError = 'El campo ' . $nombreCampoErroneo . ' tener al menos 4 caracteres';
    return false;
  } elseif (empty($id_rol)) {
    $nombreCampoErroneo = 'Rol';
    $mensajeError = 'El campo ' . $nombreCampoErroneo . ' es requerido';
    return false;
  }
  return true;
}

$btnRegistrarse = $_POST['btnRegistrarse'];

if (validarBoton($btnRegistrarse)) {
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $txtNombre = htmlspecialchars($_POST['nombre'], ENT_QUOTES, 'UTF-8');
    $txtApePaterno = htmlspecialchars($_POST['ape_paterno'], ENT_QUOTES, 'UTF-8');
    $txtApeMaterno = htmlspecialchars($_POST['ape_materno'], ENT_QUOTES, 'UTF-8');
    $txtEmail = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $txtContrasena = htmlspecialchars($_POST['contrasena'], ENT_QUOTES, 'UTF-8');
    $txtTelefono = htmlspecialchars($_POST['telefono'], ENT_QUOTES, 'UTF-8');
    $id_rol = filter_input(INPUT_POST, 'id_rol', FILTER_VALIDATE_INT);

    if (validarCampos($txtNombre, $txtApePaterno, $txtApeMaterno, $txtEmail, $txtContrasena, $txtTelefono, $id_rol)) {
      $controlRegistrarUsuarioObject = new controlRegistrarUsuario();
      $controlRegistrarUsuarioObject->registrarUsuario($txtNombre, $txtApePaterno, $txtApeMaterno, $txtEmail, $txtContrasena, $txtTelefono, $id_rol);
    } else {
      $formRegistrarUsuarioObject = new formRegistrarUsuario();
      $formRegistrarUsuarioObject->formRegistrarUsuarioShow();

      $viewMessageSistemaObject = new viewMessageSistema();
      $viewMessageSistemaObject->viewMessageSistemaShow('error', 'Campos inválidos', $mensajeError);
    }
  }
} else {
  $formRegistrarUsuarioObject = new formRegistrarUsuario();
  $formRegistrarUsuarioObject->formRegistrarUsuarioShow();

  $viewMessageSistemaObject = new viewMessageSistema();
  $viewMessageSistemaObject->viewMessageSistemaShow('error', 'Acceso denegado', 'No se ha enviado el formulario');
}
