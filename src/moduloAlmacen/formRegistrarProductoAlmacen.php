<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/shared/vista.php');

class formRegistrarProductoAlmacen extends vista
{
  public function formRegistrarProductoAlmacenShow()
  {
    $this->cabeceraShow('Registrar producto');
?>
    <a class="regresar-boton" href="/moduloSeguridad/indexPanelPrincipal.php">Regresar al panel principal</a>
    <h1>Registrar Producto</h1>
    <form action="/moduloAlmacen/getRegistrarProductoAlmacen.php" method="POST">
      <div>
        <label for="nombreProducto">Nombre del producto:</label>
        <input type="text" id="nombreProducto" name="nombreProducto" minlength="4" maxlength="60" required>
      </div>
      <div>
        <label for="descripcion">Descripción:</label>
        <input type="text" id="descripcion" name="descripcion" minlength="4" maxlength="90" required>
      </div>
      <div>
        <label for="cantidad">Cantidad:</label>
        <input type="number" id="cantidad" name="cantidad" required>
      </div>
      <div>
        <label for="precio">Precio unitario:</label>
        <input type="number" id="precio" name="precio" step=".01" required>
      </div>
      <input type="submit" value="Registrar producto" name="btnRegistrarProducto">
    </form>
<?php
    $this->piePaginaShow();
  }
}
?>