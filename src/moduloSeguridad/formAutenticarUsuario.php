<?php
// include('../shared/vista.php');
include($_SERVER['DOCUMENT_ROOT'] . '/shared/vista.php');

class formAutenticarUsuario extends vista
{
  public function formAutenticarUsuarioShow($mensaje, $slot = null)
  {
    $this->getCabecera('Login');
?>
    <p><?= $mensaje ?></p>
    <h1>Autenticar Usuario</h1>
    <form action="/moduloSeguridad/getUsuario.php" method="POST">
      <label for="usuario">Usuario:</label>
      <input type="text" name="usuario" id="usuario" required>
      <br>
      <label for="clave">Clave:</label>
      <input type="password" name="clave" id="clave" required>
      <br>
      <input type="submit" value="Autenticar" name="btnSubmit">
    </form>
    <?php echo $slot; ?>
<?php
    $this->getPiePagina();
  }
}
