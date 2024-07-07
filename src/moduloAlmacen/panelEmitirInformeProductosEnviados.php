<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/shared/vista.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/moduloAlmacen/controlEmitirInformeProductosEnviados.php');

class panelEmitirInformeProductosEnviados extends vista
{
  function panelEmitirInformeProductosEnviadosShow()
  {
    $controlEmitirInformeProductosEnviadosObject = new controlEmitirInformeProductosEnviados();
    $solicitudes = $controlEmitirInformeProductosEnviadosObject->obtenerSolicitudes();

    $this->cabeceraShow("Panel de informe productos");
?>
    <a class="regresar-boton" href="/moduloSeguridad/indexPanelPrincipal.php">Regresar al panel principal</a>
    <div class="container">
      <h1 style="margin-bottom: 20px;">Solicitudes de envío</h1>
      <form class="form-buscar" action="/moduloAlmacen/getStockAlmacen.php" method="POST">
        <input type="text" class="input-buscar" id="inputBuscar" name="txtNombreProducto" placeholder="Buscar productos por nombre...">
        <input type="submit" class="submit-buscar" value="Buscar" name="btnBuscar" id="btnBuscar">
      </form>
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
                  <td><?php echo $solicitud['id_solicitud']; ?></td>
                  <td><?php echo $solicitud['fecha_solicitud']; ?></td>
                  <td><?php echo $solicitud['cantidad_total']; ?></td>
                  <td><?php echo $solicitud['estado']; ?></td>
                  <td>
                    <a href="/moduloAlmacen/indexPanelDetalleSolicitud.php?id=<?php echo $solicitud['id_solicitud']; ?>">Ver detalles</a>
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