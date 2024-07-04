<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/moduloAlmacen/formEditarProductoAlmacen.php');

session_start();

if (!isset($_SESSION['autenticado'])) {
  header('Location: /');
  exit();
}

$rol = $_SESSION['rol'];

if ($rol != "almacen" && $rol != "administrador") {
  header('Location: /moduloSeguridad/indexPanelPrincipal.php');
  exit();
}

$id = $_GET['id'];
$nombre = $_GET['nombre'];

if ($id === null || $nombre === null) {
  header('Location: /moduloAlmacen/indexStockAlmacen.php');
  exit();
}

$_SESSION['productoEditando'] = $nombre;
$formEditarProductoAlmacenObject = new formEditarProductoAlmacen();
$formEditarProductoAlmacenObject->formEditarProductoAlmacenShow($id, $nombre);