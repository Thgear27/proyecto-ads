<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/modelos/conexion.php');

class Eusuario extends Conexion
{
  public function validarUsuario($email, $password)
  {
    $this->conectar();

    $sql = "SELECT password, state FROM Users WHERE email = '$email'";
    $result = $this->query($sql);

    if ($result && $result->num_rows > 0) {
      $row = $result->fetch_assoc();
      $hashedPassword = $row['password'];
      $userState = $row['state'];

      // Check user state
      if ($userState === 'inactive') {
        return "inactive user";
      }

      if (password_verify($password, $hashedPassword)) {
        return "success";
      } else {
        return "invalid password";
      }
    } else {
      return "user not found";
    }
  }
}
