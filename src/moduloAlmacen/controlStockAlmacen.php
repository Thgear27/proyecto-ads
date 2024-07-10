<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/modelos/EproductoAlmacen.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/shared/viewMessageSistema.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/moduloAlmacen/panelStockAlmacen.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');

class controlStockAlmacen
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
            font-weight: bold;
            font-size: 14px;
        }
      </style>
      <header>
          <img src="/assets/img/logo.png" alt="Logo">
          <h1>Marjorie Boutique</h1>
          <h2>Reporte de productos</h2>
      </header>
      <table>
          <thead>
              <tr>
                  <th><strong>Id</strong></th>
                  <th><strong>Nombre</strong></th>
                  <th><strong>Descripción</strong></th>
                  <th><strong>Cantidad</strong></th>
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
            <td>' . $producto['cantidad'] . '</td>
            <td>S/. ' . $producto['precio_unitario'] . '</td>
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

    $pdf->Output('Reporte_de_Productos_' . date('Y-m-d_H:i:s') . '.pdf', 'I');
  }

  function generarReporte()
  {
    $EproductoAlmacenObject = new EproductoAlmacen();
    $productos = $EproductoAlmacenObject->obtenerProductosAlmacen();

    if ($productos == null) {
      $panelStockAlmacenObject = new panelStockAlmacen();
      $panelStockAlmacenObject->panelStockAlmacenShow();

      $viewMessageSistemaObject = new viewMessageSistema();
      $viewMessageSistemaObject->viewMessageSistemaShow('error', 'Error', 'No se han encontrado productos para generar el reporte', '/moduloAlmacen/indexStockAlmacen.php');
    } else {
      $this->generarPdf($productos);
    }
  }

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
