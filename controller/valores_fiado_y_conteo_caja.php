<?php
session_start();
require_once "../model/conexion.php";
require_once "../model/contable.php";
$conexion=conexion();

$obj= new contable();

echo json_encode($obj->valores_fiado_y_conteo_caja())

 ?>