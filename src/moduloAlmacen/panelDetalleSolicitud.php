<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/shared/vista.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/moduloAlmacen/controlEmitirInformeProductosEnviados.php');

class panelDetalleSolicitud extends vista
{
  function panelDetalleSolicitudShow($productos = null, $solicitud = null, $idSolicitud = null)
  {
    $this->cabeceraShow("Detalle de solicitud");
?>

    <a class="regresar-boton" href="/moduloAlmacen/indexEmitirInformeProductoEnviados.php">Regresar al panel de solicitudes</a>

    <div class="container">
      <h1 style="margin-bottom: 20px;">Productos de la solicitud</h1>
      <form action="/moduloAlmacen/getEmitirInformeProductosEnviados.php" class="form-solicitud" method="POST">
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
                    <td>S/. <?= $producto['precio_unitario']; ?></td>
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

        <?php if ($solicitud['estado'] == 'pendiente') : ?>
          <input type="submit" style="margin-top: 20px;" name="btnEnviarProductos" id="btnEnviarProductos" value="Enviar">
        <?php endif; ?>

      </form>

    </div>

<?php
    $this->piePaginaShow();
  }
}
?>