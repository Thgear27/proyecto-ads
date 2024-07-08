<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/shared/viewMessageSistema.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/moduloAlmacen/panelDetalleSolicitud.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/modelos/EsolicitudEnvio.php');

class controlEmitirInformeProductosEnviados
{
  function obtenerSolicitudes()
  {
    $solicitudEnvioObject = new EsolicitudEnvio();
    $solicitudes = $solicitudEnvioObject->obtenerSolicitudes();
    return $solicitudes;
  }

  function obtenerSolicitud($idSolicitud) {
    $solicitudEnvioObject = new EsolicitudEnvio();
    $solicitud = $solicitudEnvioObject->obtenerSolicitud($idSolicitud);
    return $solicitud;
  }

  function obtenerProductosSolicitud($idSolicitud)
  {
    $solicitudEnvioObject = new EsolicitudEnvio();
    $productos = $solicitudEnvioObject->obtenerProductosSolicitud($idSolicitud);
    return $productos;
  }

  function cambiarEstadoSolicitud($idSolicitud, $estado)
  {
    $solicitudEnvioObject = new EsolicitudEnvio();
    $respuesta = $solicitudEnvioObject->cambiarEstadoSolicitud($idSolicitud, $estado);

    if ($respuesta) {
      $panelDetalleSolicitudObject = new panelDetalleSolicitud();
      $panelDetalleSolicitudObject->panelDetalleSolicitudShow($idSolicitud);

      $viewMessageSistemaObject = new viewMessageSistema();
      $viewMessageSistemaObject->viewMessageSistemaShow("success", "Éxito", "Se ha cambiado el estado de la solicitud correctamente.", "/moduloAlmacen/indexEmitirInformeProductoEnviados.php");
    } else {
      $panelDetalleSolicitudObject = new panelDetalleSolicitud();
      $panelDetalleSolicitudObject->panelDetalleSolicitudShow($idSolicitud);

      $viewMessageSistemaObject = new viewMessageSistema();
      $viewMessageSistemaObject->viewMessageSistemaShow("error", "Error", "Ha ocurrido un error al cambiar el estado de la solicitud.", "/moduloAlmacen/indexEmitirInformeProductoEnviados.php");
    }
  }
}
