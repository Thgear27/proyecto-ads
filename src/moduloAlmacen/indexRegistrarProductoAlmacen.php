<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/moduloAlmacen/formRegistrarProductoAlmacen.php');

session_start();

if (!isset($_SESSION['autenticado'])) {
  header('Location: /');
  exit();
}

$formRegistrarProductoAlmacenObject = new formRegistrarProductoAlmacen();
$formRegistrarProductoAlmacenObject->formRegistrarProductoAlmacenShow();
