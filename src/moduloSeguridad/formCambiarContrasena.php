<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/shared/vista.php');

class formCambiarContrasena extends vista
{
  public function formCambiarContrasenaShow()
  {
    $this->cabeceraShow('Cambiar contraseña');
?>
    <a class="regresar-boton" href="/moduloSeguridad/indexPanelPrincipal.php">Regresar al panel principal</a>
    <h1>Cambiar contraseña</h1>
    <form action="/moduloSeguridad/getCambiarContrasena.php" method="POST">
      <div>
        <label for="contrasenaActual">Contraseña actual:</label>
        <input type="password" id="contrasenaActual" name="contrasenaActual" minlength="4" required>
      </div>

      <div>
        <label for="contrasenaNueva">Contraseña nueva:</label>
        <input type="password" id="contrasenaNueva" name="contrasenaNueva" minlength="4" required>
      </div>

      <div>
        <label for="contrasenaNuevaConfirmacion">Repetir contraseña nueva:</label>
        <input type="password" id="contrasenaNuevaConfirmacion" name="contrasenaNuevaConfirmacion" minlength="4" required>
      </div>

      <div>
        <input type="submit" value="Cambiar contraseña" name="btnCambiarContrasena">
      </div>
    </form>
<?php
    $this->piePaginaShow();
  }
}
?>