<?php
exit();
include_once($_SERVER['DOCUMENT_ROOT'] . '/modelos/conexion.php');

$conn = new conexion();
$conn->conectar();

// Valores hardcoded para el usuario
$nombre = 'Mohamed';
$ape_paterno = 'Luque';
$ape_materno = 'Garcia';
$email = 'admin@example.com';
$contrasena = '12345';
$telefono = '1234567890';
$rol_id = 3; // Suponiendo que el rol con ID 2 existe en tu tabla de roles
$estado = 'active';

// Hash la contraseña
$hashedPassword = password_hash($contrasena, PASSWORD_BCRYPT);

// Consulta SQL para insertar el nuevo usuario
$sql = "INSERT INTO Usuario (nombre, ape_paterno, ape_materno, email, contrasena, telefono, id_rol, estado) 
        VALUES ('$nombre', '$ape_paterno', '$ape_materno', '$email', '$hashedPassword', '$telefono', $rol_id, '$estado')";

// Ejecutar la consulta
$result = $conn->conn->query($sql);

// Verificar si la ejecución de la consulta fue exitosa
if ($result) {
  echo "Usuario agregado exitosamente.";
} else {
  echo "Error al agregar el usuario: " . $conn->conn->error;
}

$conn->desConectar();
