<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productos = json_decode($_POST['productos'], true);

    if ($productos) {
        // Simulación de procesamiento de productos
        foreach ($productos as $producto) {
            $id = $producto['id'];
            $nombre = $producto['nombre'];
            $precio = $producto['precio'];
            $cantidad = $producto['cantidad'];
            $descripcion = $producto['descripcion'];

            // Aquí puedes insertar los datos en la base de datos o realizar cualquier otra operación
        }

        // Respuesta de éxito
        echo json_encode([
            'status' => 'success',
            'message' => 'Productos recibidos y procesados correctamente.'
        ]);
    } else {
        // Respuesta de error en la decodificación de JSON
        echo json_encode([
            'status' => 'error',
            'message' => 'Error al decodificar los productos.'
        ]);
    }
} else {
    // Respuesta de método no permitido
    echo json_encode([
        'status' => 'error',
        'message' => 'Método no permitido.'
    ]);
}
?>
