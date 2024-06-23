<?php
session_start();
include_once($_SERVER['DOCUMENT_ROOT'] . '/moduloSeguridad/formAutenticarUsuario.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/shared/viewMessageSistema.php');


function validarBoton($boton)
{
  return isset($boton);
}
function validarCamposTexto($user, $password)
{
  return (strlen($user) > 3 and strlen($password) > 3);
}

$btnSubmit = $_POST['btnSubmit'];

if (validarBoton($btnSubmit)) {
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // TODO: sanitize input
    $user = $_POST['usuario'];
    $password = $_POST['clave'];

    if (validarCamposTexto($user, $password)) {
      echo "Campos validados";
    } else {
      $formAutenticarUsuario = new formAutenticarUsuario();
      $formAutenticarUsuario->formAutenticarUsuarioShow("");

      $viewShowMessage = new viewMessageSistema();
      $viewShowMessage->showErrorMessageShow('error', 'Campos inválidos', 'Los campos deben tener al menos 4 caracteres');
    }
  }
} else {

  $formAutenticarUsuario = new formAutenticarUsuario();
  $formAutenticarUsuario->formAutenticarUsuarioShow("");

  $viewShowMessage = new viewMessageSistema();
  $viewShowMessage->showErrorMessageShow('error', 'Acceso denegado', 'No se ha enviado el formulario');
}
