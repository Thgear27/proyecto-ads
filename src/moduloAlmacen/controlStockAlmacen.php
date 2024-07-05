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
            font-size: 24px;
            color: #333;
        }
        .info {
            margin-bottom: 20px;
            color: #555;
        }
        .info p {
            margin: 5px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }
        table, th, td {
            border: 1px solid #e0e0e0;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #1976d2;
            color: white;
            font-weight: normal;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #e0f7fa;
        }
        td {
            color: #333;
        }
        .text-right {
            text-align: right;
        }
        .text-right {
            text-align: right;
        }
        </style>
        <body>

        <header>
            <h1>Marjorie Boutique</h1>
            <h2>Reporte de Stock de Productos</h2>
        </header>

        <div class="info">
            <p>Fecha de generación: ' . date('Y-m-d H:i:s') . '</p>
            <p>Generado por: ' . $nombre . '</p>
        </div>

        <table>
            <thead>
                <tr>
                    <th>ID Producto</th>
                    <th>Nombre del Producto</th>
                    <th>Descripción</th>
                    <th class="text-right">Cantidad</th>
                    <th class="text-right">Precio Unitario</th>
                </tr>
            </thead>
            <tbody>';

    foreach ($productos as $producto) {
      $html .= '
            <tr>
              <td>' . $producto['id_producto_almacen'] . '</td>
              <td>' . $producto['nombre_producto'] . '</td>
              <td>' . $producto['descripcion'] . '</td>
              <td class="text-right">' . $producto['cantidad'] . '</td>
              <td class="text-right">$' . $producto['precio_unitario'] . '</td>
            </tr>';
    }

    $html .= '
          </tbody>
        </table>
      </body>
      </html>';

    $pdf->writeHTML($html, true, false, true, false, '');

    // Cerrar y enviar el documento
    $pdf->Output('ejemplo.pdf', 'I');
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
