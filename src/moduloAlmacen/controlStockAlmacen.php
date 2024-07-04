<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/modelos/EproductoAlmacen.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/shared/viewMessageSistema.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/moduloAlmacen/panelStockAlmacen.php');

class controlStockAlmacen
{

  function actualizarProducto($txtProducto, $txtDescripcion, $txtCantidad, $txtPrecio, $txtId)
  {
    session_start();
    $EproductoAlmacenObject = new EproductoAlmacen();
    $resultado = $EproductoAlmacenObject->verificarProductoPorNombre($txtProducto, $txtId);

    if ($resultado != null) {
      $formEditarProductoAlmacenObject = new formEditarProductoAlmacen();
      $formEditarProductoAlmacenObject->formEditarProductoAlmacenShow($txtId, $_SESSION['productoEditando']); // txtProducto should be the original of the id

      $viewMessageSistemaObject = new viewMessageSistema();
      $viewMessageSistemaObject->viewMessageSistemaShow('error', 'Error', 'El producto ya se encuentra registrado');
    } else {
      $resultado = $EproductoAlmacenObject->actualizarProducto($txtProducto, $txtDescripcion, $txtCantidad, $txtPrecio, $txtId);

      if ($resultado) {
        $formEditarProductoAlmacenObject = new formEditarProductoAlmacen();
        $formEditarProductoAlmacenObject->formEditarProductoAlmacenShow($txtId, $_SESSION['productoEditando']);

        $viewMessageSistemaObject = new viewMessageSistema();
        $viewMessageSistemaObject->viewMessageSistemaShow('success', 'Éxito', 'Se ha editado el producto correctamente', '/moduloAlmacen/indexStockAlmacen.php');
      } else {
        $formEditarProductoAlmacenObject = new formEditarProductoAlmacen();
        $formEditarProductoAlmacenObject->formEditarProductoAlmacenShow($txtId, $_SESSION['productoEditando']);

        $viewMessageSistemaObject = new viewMessageSistema();
        $viewMessageSistemaObject->viewMessageSistemaShow('error', 'Error', 'No se ha podido editar el producto', '/moduloAlmacen/indexStockAlmacen.php');
      }
    }
  }

  function eliminarProductoAlmacen($idProductoAlmacen)
  {
    $EproductoAlmacenObject = new EproductoAlmacen();
    $EproductoAlmacenObject->eliminarProductoAlmacen($idProductoAlmacen);

    $panelStockAlmacenObject = new panelStockAlmacen();
    $panelStockAlmacenObject->panelStockAlmacenShow();

    $viewMessageSistemaObject = new viewMessageSistema();
    $viewMessageSistemaObject->viewMessageSistemaShow('success', 'Eliminación exitosa', 'Se ha eliminado el producto con correctamente', '/moduloAlmacen/indexStockAlmacen.php');
  }

  function obtenerProductosAlmacen($nombre = null)
  {
    if ($nombre != null) {
      $EproductoAlmacenObject = new EproductoAlmacen();
      $productos = $EproductoAlmacenObject->obtenerProductosAlmacenPorNombre($nombre);
      return $productos;
    } else {
      $EproductoAlmacenObject = new EproductoAlmacen();
      $productos = $EproductoAlmacenObject->obtenerProductosAlmacen();
      return $productos;
    }
  }
}
