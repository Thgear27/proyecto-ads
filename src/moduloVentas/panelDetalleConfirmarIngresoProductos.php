<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/shared/vista.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/moduloVentas/controlConfirmarIngresoProductos.php');

class panelDetalleConfirmarIngresoProductos extends vista
{
  function panelDetalleConfirmarIngresoProductosShow($idSolicitud)
  {
    $controlConfirmarIngresoProductosObject = new controlConfirmarIngresoProductos();
    $productos = $controlConfirmarIngresoProductosObject->obtenerProductosSolicitud($idSolicitud);
    $solicitud = $controlConfirmarIngresoProductosObject->obtenerSolicitud($idSolicitud);

    $this->cabeceraShow("Detalle de solicitud");
?>
    <a class="regresar-boton" href="/moduloVentas/indexConfirmarIngresoProductos.php">Regresar al panel de solicitudes</a>

    <div class="container">
      <h1 style="margin-bottom: 20px;">Productos de la solicitud</h1>
      <form action="/moduloVentas/getConfirmarIngresoProductos.php" class="form-solicitud" method="POST">
        <input type="number" name="id_solicitud" id="id_solicitud" value="<?= $idSolicitud ?>" hidden>
        <div class="scrollable detalle-solicitud">
          <table id="productsTable">
            <thead>
              <tr>
                <th>Id</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Cantidad Solcitada</th>
                <th>Precio unitario</th>
              </tr>
            </thead>
            <tbody>
              <?php if ($productos !== null) : ?>

                <?php foreach ($productos as $producto) : ?>
                  <tr>
                    <td><?= $producto['id_producto_almacen']; ?></td>
                    <td><?= $producto['nombre_producto']; ?></td>
                    <td><?= $producto['descripcion']; ?></td>
                    <td><?= $producto['cantidad_solicitada']; ?></td>
                    <td><?= $producto['precio_unitario']; ?> S/.</td>
                  </tr>
                <?php endforeach; ?>

              <?php else : ?>
                <tr>
                  <td colspan="4">No se encontraron productos.</td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
        <?php if ($solicitud['estado'] == "enviado") : ?>
          <input type="submit" style="margin-top: 20px;" name="btnConfirmarIngreso" id="btnConfirmarIngreso" value="Confirmar ingreso">
        <?php endif; ?>
      </form>

      <?php if ($solicitud['estado'] == "recibido") : ?>
        <form target="_blank" action="/moduloVentas/getConfirmarIngresoProductos.php" class="form-buscar" method="POST">
          <input type="number" name="id_solicitud" id="id_solicitud" value="<?= $idSolicitud ?>" hidden>
          <input type="submit" style="margin-top: 20px;" value="Descargar PDF" name="btnDescargarPdf">
        </form>
      <?php endif; ?>
    </div>
<?php
    $this->piePaginaShow();
  }
}
?>