<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/shared/vista.php');

class viewMessageSistema
{
  public function viewMessageSistemaShow($icono, $titulo, $texto, $ruta = null)
  {
    if ($ruta == null) {
?>
      <script>
        Swal.fire({
          icon: "<?= $icono ?>",
          title: "<?= $titulo ?>",
          text: "<?= $texto ?>",
          confirmButtonText: "Ok"
        });
      </script>
    <?php
    } else {
    ?>
      <script>
        Swal.fire({
          icon: "<?= $icono ?>",
          title: "<?= $titulo ?>",
          text: "<?= $texto ?>",
          confirmButtonText: "Ok"
        }).then((result) => {
          if (result.isConfirmed) {
            window.location.href = "<?= $ruta ?>";
          }
        });
      </script>
<?php
    }
  }
}
?>