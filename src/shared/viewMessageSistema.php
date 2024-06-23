<?php

class viewMessageSistema
{
  public function showErrorMessageShow($icon, $title, $text)
  {
?>
    <script>
      Swal.fire({
        icon: "<?= $icon ?>",
        title: "<?= $title ?>",
        text: "<?= $text ?>",
      })
    </script>

<?php
  }
}
?>