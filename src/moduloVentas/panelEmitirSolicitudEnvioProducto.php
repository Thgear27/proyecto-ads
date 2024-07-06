<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/shared/vista.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/moduloAlmacen/controlStockAlmacen.php');

class panelEmitirSolicitudEnvioProducto extends vista
{
  function panelEmitirSolicitudEnvioProductoShow($nombre = null)
  {
    $controlStockAlmacenObject = new controlStockAlmacen();
    $productos = $controlStockAlmacenObject->obtenerProductosAlmacen($nombre);

    $this->cabeceraShow("Panel del stock almacen", ["/assets/emitirSolicitudEnvioProducto.js"]);
?>
    <a class="regresar-boton" href="/moduloSeguridad/indexPanelPrincipal.php">Regresar al panel principal</a>
    <div class="container">
      <h1 style="margin-bottom: 20px;">Productos de Almacén</h1>
      <form class="form-buscar" action="/moduloVentas/getEmitirSolicitudEnvioProducto.php" method="POST">
        <input type="text" class="input-buscar" id="inputBuscar" name="txtNombreProducto" placeholder="Buscar productos por nombre...">
        <input type="submit" class="submit-buscar" value="Buscar" name="btnBuscar" id="btnBuscar">
      </form>

      <div class="emitir-solicitud-tables-container">
        <div class="scrollable-tiny border-table">
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
                    <td data-producto-nombre="<?= $producto['id_producto_almacen'] ?>"><?= htmlspecialchars($producto['nombre_producto']) ?></td>
                    <td data-producto-descripcion="<?= $producto['id_producto_almacen'] ?>"><?= htmlspecialchars($producto['descripcion']) ?></td>
                    <td data-producto-cantidad="<?= $producto['id_producto_almacen'] ?>"><?= htmlspecialchars($producto['cantidad']) ?></td>
                    <td data-producto-precio-unitario="<?= $producto['id_producto_almacen'] ?>"><?= htmlspecialchars($producto['precio_unitario']) ?></td>
                    <td>
                      <button data-button-anadir="<?= $producto['id_producto_almacen'] ?>" class="create">Añadir</button>
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

        <h2 style="text-align: center;">Productos a solicitar</h2>

        <div class="scrollable-tiny border-table">
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
            <tbody data-tbody-solicitar>
              <tr>
                <td colspan="6">No se encontraron productos.</td>
              </tr>
            </tbody>
          </table>
        </div>

      </div>

      <button style="margin-top: 20px;" data-button-emitir-solicitud name="btnGenerarSolicitudEnvio" id="btnGenerarSolicitudEnvio">Generar Solicitud de envío</button>
    </div>
<?php
    $this->piePaginaShow();
  }
}
?>