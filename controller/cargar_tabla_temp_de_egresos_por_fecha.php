<?php
session_start();
require_once "../model/conexion.php";
require_once "../model/contable.php";
$conexion=conexion();

$obj= new contable();

  $result=$obj->cargar_tabla_temp_de_egresos_por_fecha();
  echo $result;

 ?>