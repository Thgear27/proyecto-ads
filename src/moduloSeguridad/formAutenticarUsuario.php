<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/shared/vista.php');

class formAutenticarUsuario extends vista
{
  public function formAutenticarUsuarioShow()
  {
    $this->cabeceraShow('Login');
?>
    <h1 style="margin-bottom: 20px;">Autenticar Usuario</h1>
    <form action="/moduloSeguridad/getUsuario.php" method="POST">
      <label for="txtEmail">Email:</label>
      <input type="email" name="txtEmail" id="txtEmail" required>
      <br>
      <label for="txtContrasena">Contraseña:</label>
      <input type="password" name="txtContrasena" id="txtContrasena" minlength="4" required>
      <br>
      <input type="submit" value="Autenticar" name="btnSubmit">
    </form>
    <a href="/moduloSeguridad/indexReestablecerContrasena.php">Reestablecer contraseña</a>
<?php
    $this->piePaginaShow();
  }
}
