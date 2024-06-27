<?php
// include('../shared/vista.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/shared/vista.php');

class formAutenticarUsuario extends vista
{
  public function formAutenticarUsuarioShow()
  {
    $this->cabeceraShow('Login');
?>
    <h1>Autenticar Usuario</h1>
    <form action="/moduloSeguridad/getUsuario.php" method="POST">
      <label for="txtEmail">Email:</label>
      <input type="text" name="txtEmail" id="txtEmail" required>
      <br>
      <label for="txtContrasena">Contraseña:</label>
      <input type="password" name="txtContrasena" id="txtContrasena" required>
      <br>
      <input type="submit" value="Autenticar" name="btnSubmit">
    </form>
<?php
    $this->piePaginaShow();
  }
}
