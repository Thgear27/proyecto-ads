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

    $sql = "SELECT contrasena FROM Usuario WHERE email = '$txtEmail'";
    $respuesta = $this->conn->query($sql);

    // Verificar si se encontró alguna fila
    if ($respuesta->num_rows == 0) {
      $this->desconectar();
      return null;
    }

    // Obtener la contraseña hasheada desde la base de datos
    $fila = $respuesta->fetch_assoc();
    $hashContrasenaDB = $fila['contrasena'];

    // Verificar la contraseña
    $isPasswordCorrect = password_verify($txtContrasena, $hashContrasenaDB);

    $this->desconectar();

    // Retornar true si la contraseña es correcta, null si no
    return $isPasswordCorrect ? true : null;
  }


  public function validarEstado($txtEmail)
  {
    $this->conectar();
    $sql = "SELECT * FROM Usuario WHERE email = '$txtEmail' AND estado = 'active'";
    $respuesta = $this->conn->query($sql);

    // Verificar si se encontró alguna fila
    if ($respuesta->num_rows == 0) {
      $this->desconectar();
      return null;
    }

    $this->desconectar();
    return true;
  }

  public function verificarRol($txtEmail)
  {
    $this->conectar();
    $sql = "SELECT id_rol FROM Usuario WHERE email = '$txtEmail'";
    $respuesta = $this->conn->query($sql);

    // Verificar si se encontró alguna fila
    if ($respuesta->num_rows == 0) {
      $this->desconectar();
      return null;
    }

    $fila = $respuesta->fetch_assoc();
    $rol = $fila['id_rol'];

    switch ($rol) {
      case 1:
        $rol = "almacen";
        break;
      case 2:
        $rol = "tienda";
        break;
      case 3:
        $rol = "administrador";
        break;
      default:
        $rol = "desconcido";
    }

    $this->desconectar();
    return $rol;
  }
}
