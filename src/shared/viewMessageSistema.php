<?php

class viewMessageSistema
{
  public function viewMessageSistemaShow($icono, $titulo, $texto)
  {
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
  }
}
?>