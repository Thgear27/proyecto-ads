<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/shared/vista.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/moduloAlmacen/controlEmitirInformeProductosEnviados.php');

class panelDetalleSolicitud extends vista
{
  function panelDetalleSolicitudShow($IdSolicitud)
  {
    $controlEmitirInformeProductosEnviadosObject = new controlEmitirInformeProductosEnviados();
    $productos = $controlEmitirInformeProductosEnviadosObject->obtenerProductosSolicitud($IdSolicitud);

    $this->cabeceraShow("Detalle de solicitud");

?>

    <a class="regresar-boton" href="/moduloAlmacen/indexEmitirInformeProductoEnviados.php">Regresar al panel de solicitudes</a>

    <div class="container">
      <h1 style="margin-bottom: 20px;">Productos de la solicitud</h1>
      <form action="/moduloAlmacen/getEmitirInformeProductosEnviados.php" class="form-solicitud" method="POST">

        <div class="scrollable detalle-solicitud">
          <table id="productsTable">
            <thead>
              <tr>
                <th>Id</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Cantidad Solcitada</th>
                <th>Cantidad a Enviar</th>
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
                    <td><input type="number" value="<?= $producto['cantidad_solicitada']; ?>"></td>
                    <td><?= $producto['precio_unitario']; ?></td>
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

        <button type="submit" style="margin-top: 20px;" name="btnEnviarProductos" id="btnEnviarProductos">Enviar</button>
      </form>

    </div>

<?php
    $this->piePaginaShow();
  }
}
?>