<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/modelos/conexion.php');

class Eusuario extends conexion
{
  public function validarUsuario($txtEmail)
  {
    $this->conectar();
    $sql = "SELECT * FROM Usuario WHERE email = '$txtEmail'";
    $respuesta = $this->conn->query($sql);

    // Verificar si se encontró alguna fila
    if ($respuesta->num_rows == 0) {
      $this->desconectar();
      return null;
    }

    $this->desconectar();
    return true;
  }

  public function validarContrasenaUsuario($txtEmail, $txtContrasena)
  {
    $this->conectar();

    $sql = "SELECT password FROM Usuario WHERE email = '$txtEmail'";
    $respuesta = $this->conn->query($sql);

    // Verificar si se encontró alguna fila
    if ($respuesta->num_rows == 0) {
      $this->desconectar();
      return null;
    }

    // Obtener la contraseña hasheada desde la base de datos
    $fila = $respuesta->fetch_assoc();
    $hashContrasenaDB = $fila['password'];

    // Verificar la contraseña
    $isPasswordCorrect = password_verify($txtContrasena, $hashContrasenaDB);

    $this->desconectar();

    // Retornar true si la contraseña es correcta, null si no
    return $isPasswordCorrect ? true : null;
  }


  public function validarEstado($txtEmail)
  {
    $this->conectar();
    $sql = "SELECT * FROM Usuario WHERE email = '$txtEmail' AND state = 'active'";
    $respuesta = $this->conn->query($sql);

    // Verificar si se encontró alguna fila
    if ($respuesta->num_rows == 0) {
      $this->desconectar();
      return null;
    }

    $this->desconectar();
    return true;
  }

  // public function validarUsuario($txtEmail, $txtContrasena)
  // {
  //   $this->conectar();

  //   $sql = "SELECT password, state FROM Users WHERE email = '$txtEmail'";
  //   $result = $this->conn->query($sql);

  //   if ($result && $result->num_rows > 0) {
  //     $row = $result->fetch_assoc();
  //     $hashedPassword = $row['password'];
  //     $userState = $row['state'];

  //     // Check user state
  //     if ($userState === 'inactive') {
  //       return "inactive user";
  //     }

  //     if (password_verify($txtContrasena, $hashedPassword)) {
  //       return "success";
  //     } else {
  //       return "invalid password";
  //     }
  //   } else {
  //     return "user not found";
  //   }
  // }
}
