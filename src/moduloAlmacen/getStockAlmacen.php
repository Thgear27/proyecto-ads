<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/moduloAlmacen/controlStockAlmacen.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/moduloAlmacen/panelStockAlmacen.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/moduloAlmacen/formEditarProductoAlmacen.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/shared/viewMessageSistema.php');

session_start();

$nombreCampoErroneo = '';
$mensajeError = '';

if (!isset($_SESSION['autenticado'])) {
  header('Location: /');
  exit();
}

$rol = $_SESSION['rol'];

if ($rol != "almacen" && $rol != "administrador") {
  header('Location: /moduloSeguridad/indexPanelPrincipal.php');
  exit();
}

function validarBoton($boton)
{
  return isset($boton);
}

function validarNombreProducto($txtNombreProducto)
{
  global $mensajeError, $nombreCampoErroneo;

  if (strlen($txtNombreProducto) < 4) {
    $nombreCampoErroneo = 'Nombre Producto';
    $mensajeError = 'El campo nombre del producto debe tener al menos 4 caracteres';
    return false;
  }

  return true;
}

function validarCamposEditar($txtNombreProducto, $txtDescripcion, $txtCantidad, $txtPrecio)
{
  global $nombreCampoErroneo, $mensajeError;
  if (strlen($txtNombreProducto) < 4 || strlen($txtNombreProducto) > 60) {
    $nombreCampoErroneo = 'Nombre Producto';
    $mensajeError = 'El campo ' . $nombreCampoErroneo . ' tener al menos 4 caracteres y máximo 60 caracteres';
    return false;
  } else if (strlen($txtDescripcion) < 4 || strlen($txtDescripcion) > 90) {
    $nombreCampoErroneo = 'Descripción';
    $mensajeError = 'El campo ' . $nombreCampoErroneo . ' tener al menos 4 caracteres y máximo 90 caracteres';
    return false;
  } else if (empty($txtCantidad) || $txtCantidad < 0) {
    $nombreCampoErroneo = 'Cantidad';
    $mensajeError = 'El campo ' . $nombreCampoErroneo . ' no debe estar vacio';
    return false;
  } else if (empty($txtPrecio) || $txtPrecio < 0) {
    $nombreCampoErroneo = 'Precio Unitario';
    $mensajeError = 'El campo ' . $nombreCampoErroneo . ' no debe estar vacio';
    return false;
  }
  return true;
}

function validarAccion($accion)
{
  return isset($accion);
}

function validarId($id)
{
  return isset($id);
}

function accionEsEliminar($accion)
{
  return $accion === "eliminar";
}

if (validarAccion($_GET['accion'])) {
  if (!validarId($_GET['id'])) {
    $panelStockAlmacenObject = new panelStockAlmacen();
    $panelStockAlmacenObject->panelStockAlmacenShow();

    $viewMessageSistemaObject = new viewMessageSistema();
    $viewMessageSistemaObject->viewMessageSistemaShow('error', 'Error', 'No se ha enviado el id del producto a eliminar', '/moduloAlmacen/indexStockAlmacen.php');
  } else {
    $id = htmlspecialchars($_GET['id']);

    $accion = htmlspecialchars($_GET['accion']);

    if (accionEsEliminar($accion)) {
      $controlStockAlmacenObject = new controlStockAlmacen();
      $controlStockAlmacenObject->eliminarProductoAlmacen($id);
    } else {
      $panelStockAlmacenObject = new panelStockAlmacen();
      $panelStockAlmacenObject->panelStockAlmacenShow();

      $viewMessageSistemaObject = new viewMessageSistema();
      $viewMessageSistemaObject->viewMessageSistemaShow('error', 'Error', 'La accion no se reconoce', '/moduloAlmacen/indexStockAlmacen.php');
    }
    exit();
  }
}

$btnBuscar = $_POST['btnBuscar'];
$btnEditarProducto = $_POST['btnEditarProducto'];
$btnGenerarReporte = $_POST['btnGenerarReporte'];

function redirigirIndexStockAlmacen($txtNombreProducto)
{
  header('Location: /moduloAlmacen/indexStockAlmacen.php?nombre=' . $txtNombreProducto);
}

if (validarBoton($btnBuscar)) {
  $txtNombreProducto = htmlspecialchars($_POST['txtNombreProducto'], ENT_QUOTES, 'UTF-8');

  if (validarNombreProducto($txtNombreProducto)) {
    redirigirIndexStockAlmacen($txtNombreProducto);
  } else {
    $panelStockAlmacenObject = new panelStockAlmacen();
    $panelStockAlmacenObject->panelStockAlmacenShow();

    $viewMessageSistemaObject = new viewMessageSistema();
    $viewMessageSistemaObject->viewMessageSistemaShow('error', 'Error', $mensajeError);
  }
} elseif (validarBoton($btnEditarProducto)) {
  $txtId = trim($_POST['idProducto']);
  $txtProducto = trim($_POST['nombreProducto']);
  $txtDescripcion = trim($_POST['descripcion']);
  $txtCantidad = trim($_POST['cantidad']);
  $txtPrecio = trim($_POST['precio']);

  if (validarCamposEditar($txtProducto, $txtDescripcion, $txtCantidad, $txtPrecio)) {
    $controlStockAlmacenObject = new controlStockAlmacen();
    $controlStockAlmacenObject->actualizarProducto($txtProducto, $txtDescripcion, $txtCantidad, $txtPrecio, $txtId);
  } else {
    $formEditarProductoAlmacenObject = new formEditarProductoAlmacen();
    $formEditarProductoAlmacenObject->formEditarProductoAlmacenShow($txtId, $txtProducto);

    $viewMessageSistemaObject = new viewMessageSistema();
    $viewMessageSistemaObject->viewMessageSistemaShow('error', 'Error', $mensajeError);
  }
} elseif (validarBoton($btnGenerarReporte)) {
  $controlStockAlmacenObject = new controlStockAlmacen();
  $controlStockAlmacenObject->generarReporte();
} else {
  $panelStockAlmacenObject = new panelStockAlmacen();
  $panelStockAlmacenObject->panelStockAlmacenShow();

  $viewMessageSistemaObject = new viewMessageSistema();
  $viewMessageSistemaObject->viewMessageSistemaShow('error', 'Error', 'No se ha enviado el formulario');
}
