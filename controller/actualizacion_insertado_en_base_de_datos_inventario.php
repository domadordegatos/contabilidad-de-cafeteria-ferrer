<?php
session_start();
require_once "../model/conexion.php";
require_once "../model/contable.php";
$conexion=conexion();

$obj= new contable();

  $result=$obj->actualizacion_insertado_en_base_de_datos_inventario();
  echo $result;

 ?>