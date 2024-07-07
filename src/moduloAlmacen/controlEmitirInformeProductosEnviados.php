<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/shared/viewMessageSistema.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/modelos/EsolicitudEnvio.php');

class controlEmitirInformeProductosEnviados {
  function obtenerSolicitudes() {
    $solicitudEnvioObject = new EsolicitudEnvio();
    $solicitudes = $solicitudEnvioObject->obtenerSolicitudes();
    return $solicitudes;
  } 

  function obtenerProductosSolicitud($idSolicitud) {
    $solicitudEnvioObject = new EsolicitudEnvio();
    $detalleSolicitud = $solicitudEnvioObject->obtenerProductosSolicitud($idSolicitud);
    return $detalleSolicitud;
  }
}