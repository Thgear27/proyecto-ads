<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'] . '/shared/viewMessageSistema.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/moduloSeguridad/formRegistrarUsuario.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/moduloSeguridad/controlRegistrarUsuario.php');

if (!isset($_SESSION['autenticado'])) {
  header('Location: /');
  exit();
}

function validarBoton($boton)
{
  return isset($boton);
}

function validarCampos($nombre, $ape_paterno, $ape_materno, $email, $contrasena, $telefono, $id_rol, $estado)
{
  // TODO: Implementar validación de campos
  return true;
}

$btnSubmit = $_POST['btnSubmit'];

if (validarBoton($btnSubmit)) {
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = htmlspecialchars($_POST['nombre'], ENT_QUOTES, 'UTF-8');
    $ape_paterno = htmlspecialchars($_POST['ape_paterno'], ENT_QUOTES, 'UTF-8');
    $ape_materno = htmlspecialchars($_POST['ape_materno'], ENT_QUOTES, 'UTF-8');
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $contrasena = htmlspecialchars($_POST['contrasena'], ENT_QUOTES, 'UTF-8');
    $telefono = htmlspecialchars($_POST['telefono'], ENT_QUOTES, 'UTF-8');
    $id_rol = filter_input(INPUT_POST, 'id_rol', FILTER_VALIDATE_INT);
    $estado = htmlspecialchars($_POST['estado'], ENT_QUOTES, 'UTF-8');

    if (validarCampos($nombre, $ape_paterno, $ape_materno, $email, $contrasena, $telefono, $id_rol, $estado)) {
      $controlRegistrarUsuarioObject = new controlRegistrarUsuario();
      $controlRegistrarUsuarioObject->buscarUsuario($nombre, $ape_paterno, $ape_materno, $email, $contrasena, $telefono, $id_rol, $estado); 
    } else {
      $formRegistrarUsuarioObject = new formRegistrarUsuario();
      $formRegistrarUsuarioObject->formRegistrarUsuarioShow();

      $viewMessageSistemaObject = new viewMessageSistema();
      $viewMessageSistemaObject->viewMessageSistemaShow('error', 'Campos inválidos', 'Los campos deben tener al menos 4 caracteres');
    }
  }
} else {
  $formRegistrarUsuarioObject = new formRegistrarUsuario();
  $formRegistrarUsuarioObject->formRegistrarUsuarioShow();

  $viewMessageSistemaObject = new viewMessageSistema();
  $viewMessageSistemaObject->viewMessageSistemaShow('error', 'Acceso denegado', 'No se ha enviado el formulario');
}
