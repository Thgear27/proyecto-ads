<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/moduloSeguridad/panelPrincipalSistema.php');

session_start();

if (!isset($_SESSION['autenticado'])) {
  header('Location: /');
  exit();
}

$panelPrincipalObject = new panelPrincipalSistema();
$panelPrincipalObject->panelPrincipalSistemaShow();
