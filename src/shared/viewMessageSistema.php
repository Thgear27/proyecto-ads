<?php

class viewMessageSistema
{
  public function viewMessageSistemaShow($icon, $title, $text)
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