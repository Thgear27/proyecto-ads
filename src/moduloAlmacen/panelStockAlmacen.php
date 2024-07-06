<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/shared/vista.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/moduloAlmacen/controlStockAlmacen.php');

class panelStockAlmacen extends vista
{
  public function panelStockAlmacenShow($nombre = null)
  {
    $controlStockAlmacenObject = new controlStockAlmacen();
    $productos = $controlStockAlmacenObject->obtenerProductosAlmacen($nombre);

    $this->cabeceraShow("Panel del stock almacen");
?>
    <a class="regresar-boton" href="/moduloSeguridad/indexPanelPrincipal.php">Regresar al panel principal</a>
    <div class="container">
      <h1 style="margin-bottom: 20px;">Productos de Almacén</h1>
      <form class="form-buscar" action="/moduloAlmacen/getStockAlmacen.php" method="POST">
        <input type="text" class="input-buscar" id="inputBuscar" name="txtNombreProducto" placeholder="Buscar productos por nombre...">
        <input type="submit" class="submit-buscar" value="Buscar" name="btnBuscar" id="btnBuscar">
      </form>
      <div class="scrollable">
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
            <?php if ($productos !== null) : ?>
              <?php foreach ($productos as $producto) : ?>
                <tr>
                  <td><?= htmlspecialchars($producto['id_producto_almacen']) ?></td>
                  <td><?= htmlspecialchars($producto['nombre_producto']) ?></td>
                  <td><?= htmlspecialchars($producto['descripcion']) ?></td>
                  <td><?= htmlspecialchars($producto['cantidad']) ?></td>
                  <td><?= htmlspecialchars($producto['precio_unitario']) ?></td>
                  <td>
                    <a href="/moduloAlmacen/indexEditarProductoAlmacen.php?id=<?= htmlspecialchars($producto['id_producto_almacen']) ?>&nombre=<?= htmlspecialchars($producto['nombre_producto']) ?>">Editar</a>
                    <a href="/moduloAlmacen/getStockAlmacen.php?accion=eliminar&id=<?= htmlspecialchars($producto['id_producto_almacen']) ?>">Eliminar</a>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else : ?>
              <tr>
                <td colspan="6">No se encontraron productos.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
      <form style="margin-top: 20px;" class="form-buscar" target="_blank" action="/moduloAlmacen/getStockAlmacen.php" method="POST">
        <input type="submit" value="Generar reporte" name="btnGenerarReporte" id="btnGenerarReporte">
      </form>
    </div>
<?php
    $this->piePaginaShow();
  }
}
?>