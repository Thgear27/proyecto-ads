<?php
exit();
include_once($_SERVER['DOCUMENT_ROOT'] . '/modelos/conexion.php');

$conn = new conexion();
$conn->conectar();

// Valores hardcoded para el rol
$rol = 'administrador';
$estado = 'active';

// Consulta SQL para insertar el nuevo rol
$sql = "INSERT INTO Rol (rol, estado) VALUES ('$rol', '$estado')";

// Ejecutar la consulta
$result = $conn->conn->query($sql);

// Verificar si la ejecución de la consulta fue exitosa
if ($result) {
    echo "Rol agregado exitosamente.";
} else {
    echo "Error al agregar el rol: " . $conn->conn->error;
}

$conn->desConectar();
?>
