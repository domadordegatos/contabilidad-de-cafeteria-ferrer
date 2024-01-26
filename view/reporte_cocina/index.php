<?php require_once "../home/navbar.php"; 
date_default_timezone_set('America/Bogota');
$fecha_actual = date("Y-m-d");?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte Cocina</title>
    <?php require_once "../../model/libraries/lib.php"; ?>
</head>
<body onload="consultar_reporte_de_ingresos_y_egresos()">
    <div class="contenedor w-100 d-flex">
        <div class="w-25 separador1 mx-3">
            <div class="row">
                <div class="col-12 mt-4">
                    <h4 class="text-center">Consultar Reporte</h4>
                </div>
            </div>


            <div class="row mx-2">
                <div class="col-6">
                    <div class="form-group">
                        <label for="">Fecha Inicio</label>
                        <input type="date" class="form-control" id="fechainicio" value="<?php echo $fecha_actual; ?>">
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="">Fecha Fin</label>
                        <input type="date" class="form-control" id="fechafin" max="<?php echo $fecha_actual; ?>" value="<?php echo $fecha_actual; ?>">
                    </div>
                </div>
                <div class="col-12">
                    <button type="button" name="" id="" class="btn btn-primary btn-lg btn-block" onclick="consultar_reporte_de_ingresos_y_egresos()">Buscar</button>
                </div>
            </div>
        </div>
        <div class="w-75 separador2 mx-5" id="cargue_tabla">

        </div>
    </div>

</body>

</html>

<script>

    function consultar_reporte_de_ingresos_y_egresos() {
        cadena = "form1=" + $('#fechainicio').val() +
            "&form2=" + $('#fechafin').val();
        $.ajax({
            type: "POST",
            url: "../../controller/cocina/consultar_reporte_de_ingresos_y_egresos.php", //validacion de datos de registro
            data:cadena,
            success: function(r) {
                if (r == 1) {
                    $('#cargue_tabla').load("tabla_cargue.php");
                    return false;
                }else if(r == 2){
                    alertify.error("Aun no hay registros hoy");
                }
            }
        });
    }
</script>