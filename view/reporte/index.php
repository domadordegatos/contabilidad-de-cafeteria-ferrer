<?php require_once "../home/navbar.php"; 
$fecha_actual = date("Y-m-d");?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte</title>
    <?php require_once "../../model/libraries/lib.php"; ?>
</head>

<body style="overflow-x: hidden;">
    <div class="row mx-2 mt-2">
        <div class="col-2">
            <div class="form-group">
                <label for="">Fecha Inicio</label>
                <input type="date" class="form-control" id="fechainicio" value="">
            </div>
        </div>
        <div class="col-2">
            <div class="form-group">
                <label for="">Fecha Fin</label>
                <input type="date" class="form-control" id="fechafin" max="<?php echo $fecha_actual; ?>" value="<?php echo $fecha_actual; ?>">
            </div>
        </div>
        <div class="col-2">
            <label for="">.</label>
            <button type="button" onclick="buscar_registros_por_fechas()" class="btn btn-primary btn-sm btn-block">Buscar</button>
        </div>
    </div>
    <div class="contendor">
        <div class="separador1">

        </div>
        <div class="separador2">

        </div>
    </div>

</body>

</html>