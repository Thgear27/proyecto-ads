<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/modelos/EproductoAlmacen.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/shared/viewMessageSistema.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/moduloSeguridad/panelPrincipalSistema.php');

class controlRegistrarProductoAlmacen
{
  function buscarProducto($txtProducto, $txtDescripcion, $txtCantidad, $txtPrecio)
  {
    $productoAlmacenObject = new EproductoAlmacen();
    $resultado = $productoAlmacenObject->verificarProductoPorNombre($txtProducto);
    if ($resultado != null) {
      $formRegistrarProductoAlmacenObject = new formRegistrarProductoAlmacen();
      $formRegistrarProductoAlmacenObject->formRegistrarProductoAlmacenShow();

      $viewMessageSistemaObject = new viewMessageSistema();
      $viewMessageSistemaObject->viewMessageSistemaShow('error', 'Error', 'El producto ya se encuentra registrado');
    } else {
      $productoAlmacenObject->registrarProducto($txtProducto, $txtDescripcion, $txtCantidad, $txtPrecio);

      $formRegistrarProductoAlmacenObject = new formRegistrarProductoAlmacen();
      $formRegistrarProductoAlmacenObject->formRegistrarProductoAlmacenShow();

      $viewMessageSistemaObject = new viewMessageSistema();
      $viewMessageSistemaObject->viewMessageSistemaShow('success', 'Registro exitoso', 'Producto registrado correctamente', '/moduloSeguridad/indexPanelPrincipal.php');
    }
  }
}
