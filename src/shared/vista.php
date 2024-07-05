<?php
class vista
{
  protected function cabeceraShow($texto)
  {
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.0/dist/sweetalert2.all.min.js"></script>
      <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.0/dist/sweetalert2.min.css" rel="stylesheet">
      <link rel="stylesheet" href="/assets/styles.css">
      <title><?= $texto ?></title>
    </head>

    <body id="body">
    <?php
  }
  protected function piePaginaShow()
  {
    ?>
      <footer>&copy; Marjorie Boutique</footer>
    </body>
    </html>
<?php
  }
}
?>