<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/shared/vista.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/moduloVentas/controlConfirmarIngresoProductos.php');


class panelConfirmarIngresoProductos extends vista
{
  function panelConfirmarIngresoProductosShow($solicitudes = null)
  {
    $this->cabeceraShow("Panel de confirmar ingreso de productos");
?>
    <a class="regresar-boton" href="/moduloSeguridad/indexPanelPrincipal.php">Regresar al panel principal</a>
    <div class="container">
      <h1 style="margin-bottom: 20px;">Solicitudes de envío</h1>
      <div class="scrollable">
        <table id="productsTable">
          <thead>
            <tr>
              <th>Id</th>
              <th>Fecha</th>
              <th>Cantidad Total</th>
              <th>Estado</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php if ($solicitudes !== null) : ?>

              <?php foreach ($solicitudes as $solicitud) : ?>
                <tr>
                  <td><?= $solicitud['id_solicitud']; ?></td>
                  <td><?= $solicitud['fecha_solicitud']; ?></td>
                  <td><?= $solicitud['cantidad_total']; ?></td>
                  <td class="estado <?= $solicitud['estado']; ?>"><?= $solicitud['estado']; ?></td>
                  <td>
                    <?php if ($solicitud['estado'] == "enviado") : ?>
                      <a class="label-button" href="/moduloVentas/indexDetalleConfimarIngresoProductos.php?id=<?= $solicitud['id_solicitud']; ?>">
                        Confirmar ingreso
                      </a>
                    <?php else : ?>
                      <a class="label-button" href="/moduloVentas/indexDetalleConfimarIngresoProductos.php?id=<?= $solicitud['id_solicitud']; ?>">
                        Ver detalles
                      </a>
                    <?php endif; ?>
                  </td>
                </tr>
              <?php endforeach; ?>

            <?php else : ?>
              <tr>
                <td colspan="6">No se encontraron solicitudes.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
<?php
    $this->piePaginaShow();
  }
}
?>