<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/shared/vista.php');

class panelPrincipalSistema extends vista
{
  public function panelPrincipalSistemaShow()
  {
    $this->cabeceraShow("Panel principal del sistema");
    $rol = $_SESSION['rol'];
    $email = $_SESSION['email'];
    $rol = $_SESSION['rol'];
    $email = $_SESSION['email'];

    if ($rol == "almacen") {
?>
      <main class="main-container">
        <div class="info">
          <h1>Bienvenido almacenero</h1>
          <p>Panel principal del sistema</p>
          <p>Usuario: <?= $email ?></p>
          <p>Rol: <?= $rol ?></p>
        </div>
        <nav>
          <a class="nav-link" href="/moduloAlmacen/indexEmitirInformeProductoEnviados.php">Solicitudes de envío</a>
          <a class="nav-link" href="/moduloAlmacen/indexStockAlmacen.php">Stock Almacen</a>
          <a class="nav-link" href="/moduloAlmacen/indexRegistrarProductoAlmacen.php">Registrar Producto</a>
          <a class="nav-link" href="/moduloSeguridad/indexCambiarContrasena.php">Cambiar Contraseña</a>
          <a class="nav-link" href="/moduloSeguridad/cerrarSesion.php">Cerrar Sesión</a>
        </nav>
      </main>
    <?php
    } elseif ($rol == "tienda") {
    ?>
      <main class="main-container">
        <div class="info">
          <h1>Bienvenido asistente de tienda</h1>
          <p>Panel principal del sistema</p>
          <p>Usuario: <?= $email ?></p>
          <p>Rol: <?= $rol ?></p>
        </div>
        <nav>
          <a class="nav-link" href="/moduloVentas/indexEmitirSolicitudEnvioProducto.php">Solicitar envío</a>
          <a class="nav-link" href="/moduloSeguridad/indexCambiarContrasena.php">Cambiar Contraseña</a>
          <a class="nav-link" href="/moduloSeguridad/cerrarSesion.php">Cerrar Sesión</a>
        </nav>
      </main>
    <?php
    } elseif ($rol == "administrador") {
    ?>
      <main class="main-container">
        <div class="info">
          <h1>Bienvenido administrador</h1>
          <p>Panel principal del sistema</p>
          <p>Usuario: <?= $email ?></p>
          <p>Rol: <?= $rol ?></p>
        </div>
        <nav>
          <a class="nav-link" href="/moduloAlmacen/indexEmitirInformeProductoEnviados.php">Solicitudes de envío</a>
          <a class="nav-link" href="/moduloSeguridad/indexRegistrarUsuario.php">Registrar Nuevo Usuario</a>
          <a class="nav-link" href="/moduloAlmacen/indexStockAlmacen.php">Stock Almacen</a>
          <a class="nav-link" href="/moduloAlmacen/indexRegistrarProductoAlmacen.php">Registrar Producto</a>
          <a class="nav-link" href="/moduloSeguridad/indexCambiarContrasena.php">Cambiar Contraseña</a>
          <a class="nav-link" href="/moduloSeguridad/cerrarSesion.php">Cerrar Sesión</a>
        </nav>
      </main>
    <?php
    } elseif ($rol == "desconcido") {
    ?>
      <h1>Rol desconocido</h1>
      <p>Rol desconocido</p>
<?php
    }
    $this->piePaginaShow();
  }
}
