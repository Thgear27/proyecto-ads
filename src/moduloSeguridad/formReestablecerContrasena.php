<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/shared/vista.php');

class formReestablecerContrasena extends vista
{
  public function formReestablecerContrasenaShow()
  {
    $this->cabeceraShow('Reestablecer contraseña');
?>
    <h1>Reestablecer contraseña</h1>
    <form action="/moduloSeguridad/getReestablacerContrasena.php" method="POST">
      <div>
        <label for="contrasenaNueva">Contraseña nueva:</label>
        <input type="password" id="contrasenaNueva" name="contrasenaNueva" minlength="4" required>
      </div>

      <div>
        <label for="contrasenaNuevaConfirmacion">Repetir contraseña nueva:</label>
        <input type="password" id="contrasenaNuevaConfirmacion" name="contrasenaNuevaConfirmacion" minlength="4" required>
      </div>

      <div>
        <input type="submit" value="Reestablecer contraseña" name="btnReestablecerContrasena">
      </div>
    </form>
<?php
    $this->piePaginaShow();
  }
}
?>