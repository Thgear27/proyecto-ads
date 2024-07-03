<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/modelos/Eusuario.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/shared/viewMessageSistema.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/moduloSeguridad/formCodigoSeguridad.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class controlReestablecerContrasena
{
  function enviarCodigoSeguridad($txtEmail, $codigoAleatorio)
  {
    $mail = new PHPMailer(true);

    try {
      //Server settings
      $mail->isSMTP();
      $mail->Host = getenv('SMTP_HOST');
      $mail->SMTPAuth = true;
      $mail->Username = getenv('SMTP_USER');
      $mail->Password = getenv('SMTP_PASSWORD');
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
      $mail->Port = 587;

      //Recipients
      $mail->setFrom('vegasfernando2003@gmail.com', 'Marjorie Boutique');
      $mail->addAddress($txtEmail, 'Usuario');

      $mail->CharSet = 'UTF-8';

      // Content
      $mail->isHTML(true);
      $mail->Subject = "Código de seguridad para reestablecer contraseña - Marjorie Boutique";
      $mail->Body    = "<h1>Código de seguridad para reestablecer contraseña</h1>
                        <p>El código de seguridad para reestablecer la contraseña es: <h1>$codigoAleatorio</h1></p>";
      $mail->AltBody = "El código de seguridad para reestablecer la contraseña es: $codigoAleatorio";

      $mail->send();
    } catch (Exception $e) {
      echo "El mensaje no pudo ser enviado. Mailer Error: {$mail->ErrorInfo}";
    }
  }

  function  reestablecerContrasena($txtEmail, $txtContrasenaNueva)
  {
    $objUsuario = new Eusuario();
    $objUsuario->actualizarContrasenaUsuario($txtEmail, $txtContrasenaNueva);
    header('Location: /index.php');
  }

  function mostrarFormularioReestablecer()
  {
    $formReestablecerContrasena = new formReestablecerContrasena();
    $formReestablecerContrasena->formReestablecerContrasenaShow();
  }

  function buscarUsuario($txtEmail)
  {
    $objUsuario = new Eusuario();
    $resultado = $objUsuario->buscarUsuarioPorEmail($txtEmail);

    if ($resultado == null) {
      $formBuscarUsuario = new formBuscarUsuario();
      $formBuscarUsuario->formBuscarUsuarioShow();

      $viewMessageSistemaObject = new viewMessageSistema();
      $viewMessageSistemaObject->viewMessageSistemaShow('error', 'Error', 'El email ingresado no se encuentra registrado');
    } else {
      $_SESSION['email'] = $txtEmail;
      $codigo_aleatorio = mt_rand(1000000, 9999999);
      $_SESSION['codigo_aleatorio'] = $codigo_aleatorio;

      $this->enviarCodigoSeguridad($txtEmail, $codigo_aleatorio);

      $formCodigoSeguridadOject = new formCodigoSeguridad();
      $formCodigoSeguridadOject->formCodigoSeguridadShow();
    }
  }
}
