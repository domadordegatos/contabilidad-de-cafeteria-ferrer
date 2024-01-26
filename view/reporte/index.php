<?php require_once "../home/navbar.php"; 
date_default_timezone_set('America/Bogota');
$fecha_actual = date("Y-m-d");?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte</title>
    <?php require_once "../../model/libraries/lib.php"; ?>
</head>

<body onload="buscar_registros_por_fechas()" style="overflow-x: hidden;">
    <div class="row mx-2 mt-2">
        <div class="col-2">
            <div class="form-group">
                <label for="">Fecha Inicio</label>
                <input type="date" class="form-control" id="fechainicio" value="<?php echo $fecha_actual; ?>">
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
        <div class="separador1 mx-2 d-flex" id="cargue_tabla">

        </div>
    </div>

</body>

</html>

<script>
    function vista_reporte_por_fecha(fecha){
        console.log(fecha);
        window.open('ver_dia_temp.php?fecha='+ encodeURIComponent(fecha), "Ver Dia", "width=1080, height=600");
    }

    function buscar_registros_por_fechas() {
        cadena = "form1=" + $('#fechainicio').val() +
                 "&form2=" + $('#fechafin').val();
        $.ajax({
            type: "POST",
            url: "../../controller/cargue_ingresos_egresos_reporte.php",
            data:cadena,
            success: function (r) {
                if (r == 1) {
                    alertify.success("Registros encontrados");
                    $('#cargue_tabla').load("cargue_ingresos_egresos_reporte.php");
                    return false;
                }else if( r==2 ){
                    alertify.error("No hay registros de estas fechas");
                }
            }
        });
    }
</script>