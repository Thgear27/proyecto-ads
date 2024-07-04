<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/shared/vista.php');

class formBuscarUsuario extends vista
{
  public function formBuscarUsuarioShow()
  {
    $this->cabeceraShow('Búsqueda de Usuario');
?>
    <a href="/index.php">Regresar al login</a>
    <h1 style="margin-bottom: 20px;">Buscar usuario</h1>
    <form action="/moduloSeguridad/getReestablacerContrasena.php" method="POST">
      <label for="txtEmail">Email:</label>
      <br>
      <input type="email" name="txtEmail" id="txtEmail" required>
      <input type="submit" value="Buscar Usuario" name="btnBuscarUsuario">
    </form>
<?php
    $this->piePaginaShow();
  }
}
