<?php
require 'modelos/conexion.php';

$conn = new Conexion();
$conn->conectar();

// Hardcoded values for the user
$username = 'john_doe';
$email = 'john_doe@example.com';
$password = '12345';
$phone_number = '9876543210';
$role_id = 1; // Assuming the role with ID 1 exists in your Role table
$state = 'active';

// Hash the password
$hashedPassword = password_hash($password, PASSWORD_BCRYPT);

// SQL query to insert the new user
$sql = "INSERT INTO Usuario (username, email, password, phone_number, role_id, state) 
        VALUES ('$username', '$email', '$hashedPassword', '$phone_number', $role_id, '$state')";

// Execute the query
$result = $conn->conn->query($sql);

// Check if the query execution was successful
if ($result) {
  echo "User added successfully.";
} else {
  echo "Failed to add user: " . $conn->conn->error;
}

$conn->desConectar();
