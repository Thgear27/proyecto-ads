<?php
class vista
{
  protected function getCabecera($titulo)
  {
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title><?= $titulo ?></title>
    </head>

    <body>
    <?php
  }
  protected function getPiePagina()
  {
    ?>
      <footer>&copy; Footer</footer>
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </body>

    </html>
<?php
  }
}
?>