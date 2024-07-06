<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/modelos/EsolicitudEnvio.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/shared/viewMessageSistema.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/moduloVentas/panelEmitirSolicitudEnvioProducto.php');

class controlEmitirSolicitudEnvioProducto
{
  function generarSolicitudEnvioProductos($productos)
  {
    session_start();
    $email = $_SESSION['email'];

    $EsolicitudEnvioObject = new EsolicitudEnvio();
    $respuesta = $EsolicitudEnvioObject->generarSolicitudEnvioProductos($productos, $email);

    if ($respuesta) {
      $panelEmitirSolicitudEnvioProductoObject = new panelEmitirSolicitudEnvioProducto();
      $panelEmitirSolicitudEnvioProductoObject->panelEmitirSolicitudEnvioProductoShow();

      $viewMessageSistemaObject = new viewMessageSistema();
      $viewMessageSistemaObject->viewMessageSistemaShow('success', 'Solicitud de envío', 'La solicitud de envío se ha generado correctamente', '/moduloSeguridad/indexPanelPrincipal.php');
    } else {
      $panelEmitirSolicitudEnvioProductoObject = new panelEmitirSolicitudEnvioProducto();
      $panelEmitirSolicitudEnvioProductoObject->panelEmitirSolicitudEnvioProductoShow();

      $viewMessageSistemaObject = new viewMessageSistema();
      $viewMessageSistemaObject->viewMessageSistemaShow('error', 'Error', 'No se ha podido generar la solicitud de envío', '/moduloSeguridad/indexPanelPrincipal.php');
    }
  }
}
