<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/shared/vista.php');

class formAutenticarUsuario extends vista
{
  public function formAutenticarUsuarioShow()
  {
    $this->cabeceraShow('Login');
?>
    <form action="/moduloSeguridad/getUsuario.php" method="POST">
      <img src="/assets/imgs/logo.png" style="width: 100%; padding: 30px;" alt="">
      <label for="txtEmail"><i class="fa-solid fa-envelope"></i> Email:</label>
      <input type="email" name="txtEmail" id="txtEmail" required>
      <br>
      <label for="txtContrasena"><i class="fa-solid fa-lock"></i> Contraseña:</label>
      <input type="password" name="txtContrasena" id="txtContrasena" minlength="4" required>
      <br>
      <input type="submit" value="Autenticar" name="btnSubmit">
    </form>
    <a href="/moduloSeguridad/indexReestablecerContrasena.php">Reestablecer contraseña</a>
<?php
    $this->piePaginaShow();
  }
}
