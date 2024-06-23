<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/modelos/usuario.php');

class controlAutenticarUsuario
{
  public function validarUsuario($email, $password)
  {
    session_start();
    $objUsuario = new Eusuario();
    $respuesta = $objUsuario->validarUsuario($email, $password);

    if ($respuesta === "success") {
      // Here you can start a session and store user information, redirect to a dashboard, etc.
      echo "Usuario autenticado";
    } elseif ($respuesta === "inactive user") {
      echo "Usuario inactivo";
    } elseif ($respuesta === "invalid password") {
      echo "Contraseña inválida";
    } elseif ($respuesta === "user not found") {
      echo "No se encontró ningún user";
    }
  }
}
