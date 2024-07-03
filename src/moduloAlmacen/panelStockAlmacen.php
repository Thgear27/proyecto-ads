<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/shared/vista.php');

class panelStockAlmacen extends vista
{
  public function panelStockAlmacenShow()
  {
    $this->cabeceraShow("Panel del stock almacen");
?>
    <a class="regresar-boton" href="/moduloSeguridad/indexPanelPrincipal.php">Regresar al panel principal</a>
    <div class="container">
      <h1>Productos de Almacén</h1>
      <!-- TODO: add implementation -->
      <form class="form-buscar" action="todo">
        <input type="text" class="input-buscar" id="inputBuscar" placeholder="Buscar productos por nombre...">
        <input type="submit" class="submit-buscar" value="Bucar">
      </form>
      <table id="productsTable">
        <thead>
          <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Cantidad Total</th>
            <th>Precio</th>
            <th>Acción</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>1</td>
            <td>Producto 1</td>
            <td>Descripción del producto 1</td>
            <td>10</td>
            <td>100</td>
            <td>
              <a href="/moduloAlmacen/indexEditarProductoAlmacen.php?id=1">Acción</a>
            </td>
          </tr>
          <tr>
            <td>2</td>
            <td>Producto 2</td>
            <td>Descripción del producto 2</td>
            <td>20</td>
            <td>200</td>
            <td>
              <a href="/moduloAlmacen/indexEditarProductoAlmacen.php?id=2">Acción</a>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
<?php
    $this->piePaginaShow();
  }
}
?>