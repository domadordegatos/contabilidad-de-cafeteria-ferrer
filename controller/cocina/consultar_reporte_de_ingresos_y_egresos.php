<?php
session_start();
require_once "../../model/conexion.php";
require_once "../../model/contable.php";
$conexion=conexion();

$obj= new contable();

  $result=$obj->consultar_reporte_de_ingresos_y_egresos();
  echo $result;

 ?>