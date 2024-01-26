<?php
session_start();
require_once "../model/conexion.php";
require_once "../model/contable.php";
$conexion=conexion();

$obj= new contable();

  $result=$obj->cargue_inventario_incontables();
  echo $result;

 ?>