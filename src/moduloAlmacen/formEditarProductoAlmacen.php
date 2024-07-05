<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/shared/vista.php');

class formEditarProductoAlmacen extends vista
{
  public function formEditarProductoAlmacenShow($id, $nombre)
  {
    $this->cabeceraShow('Editar producto');
?>
    <a class="regresar-boton" href="/moduloSeguridad/indexPanelPrincipal.php">Regresar al panel principal</a>
    <h1 style="margin-bottom: 20px;">Editar Producto: <?= $nombre ?></h1>
    <form action="/moduloAlmacen/getStockAlmacen.php" method="POST">
      <input type="text" name="idProducto" minlength="4" maxlength="60" value="<?= $id ?>" hidden>
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
      <input type="submit" value="Editar producto" name="btnEditarProducto">
    </form>
<?php
    $this->piePaginaShow();
  }
}

?>