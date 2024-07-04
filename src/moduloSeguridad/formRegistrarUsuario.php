<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/shared/vista.php');

class formRegistrarUsuario extends vista
{
  public function formRegistrarUsuarioShow()
  {
    $this->cabeceraShow('Registrar Empleado');
?>
    <a class="regresar-boton" href="/moduloSeguridad/indexPanelPrincipal.php">Regresar al panel principal</a>
    <h1 style="margin-bottom: 20px;">Registrar Empleado</h1>
    <form action="/moduloSeguridad/getRegistrarUsuario.php" method="POST">
      <div>
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" minlength="4" required>
      </div>
      <div>
        <label for="ape_paterno">Apellido Paterno:</label>
        <input type="text" id="ape_paterno" name="ape_paterno" minlength="4" required>
      </div>
      <div>
        <label for="ape_materno">Apellido Materno:</label>
        <input type="text" id="ape_materno" name="ape_materno" minlength="4" required>
      </div>
      <div>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
      </div>
      <div>
        <label for="contrasena">Contraseña:</label>
        <input type="password" id="contrasena" name="contrasena" minlength="4" required>
      </div>
      <div>
        <label for="telefono">Teléfono:</label>
        <input type="text" id="telefono" name="telefono">
      </div>
      <div>
        <label for="id_rol">Rol:</label>
        <select id="id_rol" name="id_rol" required>
          <option disabled selected>Seleccione el rol</option>
          <option value="1">Almacen</option>
          <option value="2">Tienda</option>
          <option value="3">Administrador</option>
        </select>
      </div>
      <div>
        <input type="submit" value="Registrar" name="btnRegistrarse">
      </div>
    </form>
<?php
    $this->piePaginaShow();
  }
}
?>