<?php
// uncomment the following line to add the role
exit();

require 'modelos/Conexion.php';

$conn = new Conexion();
$conn->conectar();

// Hardcoded values for the role
$role = 'admin';
$state = 'active';

// SQL query to insert the new role
$sql = "INSERT INTO Role (id_role, role, state) VALUES (2, '$role', '$state')";

// Execute the query
$result = $conn->query($sql);

// Check if the query execution was successful
if ($result) {
    echo "Role added successfully.";
} else {
    echo "Failed to add role: " . $conn->conn->error;
}

$conn->desConectar();
?>
