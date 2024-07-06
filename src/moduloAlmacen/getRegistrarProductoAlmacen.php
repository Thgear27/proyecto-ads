<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'] . '/shared/viewMessageSistema.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/moduloAlmacen/formRegistrarProductoAlmacen.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/moduloAlmacen/controlRegistrarProductoAlmacen.php');

if (!isset($_SESSION['autenticado'])) {
  header('Location: /');
  exit();
}

$rol = $_SESSION['rol'];

if ($rol != "almacen" && $rol != "administrador") {
  header('Location: /moduloSeguridad/indexPanelPrincipal.php');
  exit();
}

$nombreCampoErroneo = '';
$mensajeError = '';

function validarBoton($btnRegistrarProducto)
{
  return isset($btnRegistrarProducto);
}

function validarCampos($txtNombreProducto, $txtDescripcion, $txtCantidad, $txtPrecio)
{
  global $nombreCampoErroneo, $mensajeError;
  if (empty($txtNombreProducto) || strlen($txtNombreProducto) < 4 || strlen($txtNombreProducto) > 60) {
    $nombreCampoErroneo = 'Nombre Producto';
    $mensajeError = 'El campo ' . $nombreCampoErroneo . ' tener al menos 4 caracteres y máximo 60 caracteres';
    return false;
  } else if (empty($txtDescripcion) || strlen($txtDescripcion) < 4 || strlen($txtDescripcion) > 90) {
    $nombreCampoErroneo = 'Descripción';
    $mensajeError = 'El campo ' . $nombreCampoErroneo . ' tener al menos 4 caracteres y máximo 90 caracteres';
    return false;
  } else if (empty($txtCantidad) || $txtCantidad < 0) {
    $nombreCampoErroneo = 'Cantidad';
    $mensajeError = 'El campo ' . $nombreCampoErroneo . ' es invalido';
    return false;
  } else if (empty($txtPrecio) || $txtPrecio < 0) {
    $nombreCampoErroneo = 'Precio Unitario';
    $mensajeError = 'El campo ' . $nombreCampoErroneo . ' es invalido';
    return false;
  }
  return true;
}

$btnRegistrarProducto = $_POST['btnRegistrarProducto'];

if (validarBoton($btnRegistrarProducto)) {
  $txtProducto = trim($_POST['nombreProducto']);
  $txtDescripcion = trim($_POST['descripcion']);
  $txtCantidad = trim($_POST['cantidad']);
  $txtPrecio = trim($_POST['precio']);
  if (validarCampos($txtProducto, $txtDescripcion, $txtCantidad, $txtPrecio)) {
    $controlRegistrarProductoAlmacenObject = new controlRegistrarProductoAlmacen();
    $controlRegistrarProductoAlmacenObject->buscarProducto($txtProducto, $txtDescripcion, $txtCantidad, $txtPrecio);
  } else {
    $formRegistrarProductoAlmacenObject = new formRegistrarProductoAlmacen();
    $formRegistrarProductoAlmacenObject->formRegistrarProductoAlmacenShow();

    $viewMessageSistemaObject = new viewMessageSistema();
    $viewMessageSistemaObject->viewMessageSistemaShow('error', 'Error', $mensajeError);
  }
} else {
  $formRegistrarProductoAlmacenObject = new formRegistrarProductoAlmacen();
  $formRegistrarProductoAlmacenObject->formRegistrarProductoAlmacenShow();

  $viewMessageSistemaObject = new viewMessageSistema();
  $viewMessageSistemaObject->viewMessageSistemaShow('error', 'Error', 'No se ha enviado el formulario');
}
