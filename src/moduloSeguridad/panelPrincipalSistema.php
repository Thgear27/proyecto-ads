<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/shared/vista.php');

class panelPrincipalSistema extends vista
{
  public function panelPrincipalSistemaShow($rol)
  {
    $this->cabeceraShow("Panel principal del sistema");

    if ($rol == "almacen") {
?>
      <h1>Bienvenido almacenero</h1>
      <p>Panel principal del sistema</p>
    <?php
    } elseif ($rol == "tienda") {
    ?>
      <h1>Bienvenido asistente de tienda</h1>
      <p>Panel principal del sistema</p>
    <?php
    } elseif ($rol == "administrador") {
    ?>
      <h1>Bienvenido administrador</h1>
      <p>Panel principal del sistema</p>
    <?php
    } elseif ($rol == "desconcido") {
    ?>
      <h1>Rol desconocido</h1>
      <p>Rol desconocido</p>
<?php
    }

    $this->piePaginaShow("Panel principal del sistema");
  }
}
