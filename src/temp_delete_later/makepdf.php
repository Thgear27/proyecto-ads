<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');

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
    <p>Fecha de generación: <span id="fecha"></span></p>
    <p>Generado por: <span id="generadoPor"></span></p>
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
    <tbody>
        <!-- Ejemplo de filas de productos, debes reemplazar esto con los datos de tu base de datos -->
        <tr>
            <td>1</td>
            <td>Producto A</td>
            <td>Descripción del Producto A</td>
            <td class="text-right">50</td>
            <td class="text-right">$10.00</td>
        </tr>
        <tr>
            <td>2</td>
            <td>Producto B</td>
            <td>Descripción del Producto B</td>
            <td class="text-right">30</td>
            <td class="text-right">$15.00</td>
        </tr>
        <!-- Fin de ejemplo de filas -->
    </tbody>
</table>

</body>
</html>

';
$pdf->writeHTML($html, true, false, true, false, '');

// Cerrar y enviar el documento
$pdf->Output('ejemplo.pdf', 'I');
