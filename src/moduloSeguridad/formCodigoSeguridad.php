<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/shared/vista.php');

class formCodigoSeguridad extends vista
{
  public function formCodigoSeguridadShow()
  {
    $this->cabeceraShow('Código de Seguridad');
?>
    <a href="/index.php">Regresar al login</a>
    <h1>Ingrese su código de seguridad</h1>
    <form action="/moduloSeguridad/getReestablacerContrasena.php" method="POST">
      <label for="txtCodigoSeguridad">Código:</label>
      <input type="text" name="txtCodigoSeguridad" id="txtCodigoSeguridad" required>
      <br>
      <input type="submit" value="Verificar" name="btnCodigoSeguridad">
    </form>
<?php
    $this->piePaginaShow();
  }
}