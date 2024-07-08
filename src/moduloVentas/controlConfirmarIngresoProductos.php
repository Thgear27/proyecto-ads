<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/shared/viewMessageSistema.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/modelos/EsolicitudEnvio.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/modelos/EproductoAlmacen.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/moduloVentas/panelConfirmarIngresoProductos.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');

class controlConfirmarIngresoProductos
{
  function generarPdf($productos)
  {
    session_start();
    $nombre = $_SESSION['email'];

    // Crear una nueva instancia de TCPDF
    $pdf = new TCPDF();

    // Establecer propiedades del documento
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Tu Nombre');
    $pdf->SetTitle('Título del Documento');
    $pdf->SetSubject('Asunto del Documento');
    $pdf->SetKeywords('TCPDF, PDF, ejemplo, prueba');

    // Establecer márgenes
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

    // Establecer auto página break
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

    // Establecer factor de escala de imagen
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

    // Añadir una página
    $pdf->AddPage();

    // Establecer fuente
    $pdf->SetFont('helvetica', '', 12);

    // Agregar contenido al PDF
    $html = '
      <!DOCTYPE html>
      <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        header {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        header img {
            width: 50px;
            height: 50px;
            margin-right: 20px;
        }
        header h1 {
            margin: 0;
            padding: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
      </style>
      <header>
          <img src="/assets/img/logo.png" alt="Logo">
          <h1>Marjorie Boutique</h1>
          <h2>Reporte de Ingreso de productos</h2>
      </header>
      <table>
          <thead>
              <tr>
                  <th><strong>Id</strong></th>
                  <th><strong>Nombre</strong></th>
                  <th><strong>Descripción</strong></th>
                  <th><strong>Cantidad Solicitada</strong></th>
                  <th><strong>Precio Unitario</strong></th>
              </tr>
          </thead>
          <tbody>
              ';

    foreach ($productos as $producto) {
      $html .= '
        <tr>
            <td>' . $producto['id_producto_almacen'] . '</td>
            <td>' . $producto['nombre_producto'] . '</td>
            <td>' . $producto['descripcion'] . '</td>
            <td>' . $producto['cantidad_solicitada'] . '</td>
            <td>' . $producto['precio_unitario'] . ' S/.</td>
        </tr>
      ';
    }

    $html .= '
          </tbody>
      </table>

      <div class="info">
          <p>Fecha de generación: ' . date('Y-m-d H:i:s') . '</p>
          <p>Generado por: ' . $nombre . '</p>
      </div>';

    $pdf->writeHTML($html, true, false, true, false, '');

    $pdf->Output('Reporte_de_ingreso_de_productos_' . date('Y-m-d_H:i:s') . '.pdf', 'I');
  }

  function generarSolicitudPdf($idSolicitud)
  {
    $solicitudEnvioObject = new EsolicitudEnvio();
    $productos = $solicitudEnvioObject->obtenerProductosSolicitud($idSolicitud);

    $this->generarPdf($productos);
  }

  function obtenerSolicitudes()
  {
    $solicitudEnvioObject = new EsolicitudEnvio();
    $solicitudes = $solicitudEnvioObject->obtenerSolicitudes();
    return $solicitudes;
  }

  function obtenerProductosSolicitud($idSolicitud)
  {
    $solicitudEnvioObject = new EsolicitudEnvio();
    $productos = $solicitudEnvioObject->obtenerProductosSolicitud($idSolicitud);
    return $productos;
  }

  function obtenerSolicitud($idSolicitud)
  {
    $solicitudEnvioObject = new EsolicitudEnvio();
    $solicitud = $solicitudEnvioObject->obtenerSolicitud($idSolicitud);
    return $solicitud;
  }

  function confirmarIngresoProductos($idSolicitud)
  {
    $solicitudEnvioObject = new EsolicitudEnvio();
    $respuesta = $solicitudEnvioObject->confirmarIngresoProductos($idSolicitud);

    if ($respuesta) {
      $productoAlmacenObject = new EproductoAlmacen();
      $productoAlmacenObject->reducirStock($idSolicitud);

      $panelConfirmarIngresoProductosObject = new panelConfirmarIngresoProductos();
      $panelConfirmarIngresoProductosObject->panelConfirmarIngresoProductosShow();

      $viewMessageSistemaObject = new viewMessageSistema();
      $viewMessageSistemaObject->viewMessageSistemaShow('success', 'Éxito', 'Se ha confirmado el ingreso de los productos', '/moduloVentas/indexConfirmarIngresoProductos.php');
    } else {
      $panelConfirmarIngresoProductosObject = new panelConfirmarIngresoProductos();
      $panelConfirmarIngresoProductosObject->panelConfirmarIngresoProductosShow();

      $viewMessageSistemaObject = new viewMessageSistema();
      $viewMessageSistemaObject->viewMessageSistemaShow('error', 'Error', 'No se ha podido confirmar el ingreso de los productos', '/moduloVentas/indexConfirmarIngresoProductos.php');
    }
  }
}
