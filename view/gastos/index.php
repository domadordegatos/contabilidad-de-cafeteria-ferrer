<?php require_once "../home/navbar.php"; 
date_default_timezone_set('America/Bogota');
$fecha_actual = date("Y-m-d");?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gastos</title>
    <?php require_once "../../model/libraries/lib.php"; ?>
</head>

<body onload="buscar_registros_por_fechas()">
    <div class="containe mx-4">
        <div class="contenedor w-100 mt-3 d-flex">
            <div class="separador1 w-25">
                <div class="row">
                    <div class="col-12">
                        <h3>Carga de Gastos</h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <label for="">Descripción</label>
                        <input type="text" class="form-control" id="descripcion">
                        <input type="text" id="id" hidden>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <label for="">Valor</label>
                        <input type="number" class="form-control" id="valor">
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <label for="">Tipo</label>
                        <select class="form-control" name="tipo" id="tipo">
                            <option value="3">Servicios</option>
                            <option value="4">Pagos Productos</option>
                            <option value="5">Otros</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <label for="">Estado</label>
                        <select class="form-control" name="estado" id="estado">
                            <option value="1">Activa</option>
                            <option value="2">Inactiva</option>
                        </select>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12">
                        <button type="button" name="" id="" class="btn btn-primary btn-sm btn-block" onclick="procesoagregadoactualizado(1)">Agregar</button>
                        <button type="button" name="" id="" class="btn btn-success btn-sm btn-block" onclick="procesoagregadoactualizado(2)">Actualizar</button>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-12">
                        <h4 class="text-center">Busqueda por Fechas</h4>
                    </div>
                </div>

                <div class="row mx-2 mt-2">
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
                        <label for="">.</label>
                        <button type="button" onclick="buscar_registros_por_fechas()" class="btn btn-primary btn-sm btn-block">Buscar</button>
                    </div>
                </div>

            </div>
            <div class="separador2 w-75 mx-5" id="cargue_tabla" style="height: 520px; overflow: auto; overflow-x: auto;">

            </div>
        </div>
    </div>

</body>

</html>

<script>
    function buscar_registros_por_fechas() {
        cadena = "form1=" + $('#fechainicio').val() +
                 "&form2=" + $('#fechafin').val();
        $.ajax({
            type: "POST",
            url: "../../controller/cargar_tabla_temp_de_egresos_por_fecha.php",
            data:cadena,
            success: function (r) {
                if (r == 1) {
                    $('#cargue_tabla').load("tabla_cargue_temp.php");
                    alertify.success("Registros encontrados");
                    return false;
                }else if( r==2 ){
                    alertify.error("No hay registros de estas fechas");
                }
            }
        });
    }

    function obtener_datos_del_egreso(id) {
        cadena = "form1=" + id;
        $.ajax({
            type: "POST",
            url: "../../controller/obtener_datos_del_egreso.php", //validacion de datos de registro
            data: cadena,
            success: function(r) {
                dato = jQuery.parseJSON(r);
                $('#descripcion').val(dato['2']);
                $('#id').val(dato['1']);
                $('#valor').val(dato['3']);
                $('#tipo').val(dato['5']);
                $('#estado').val(dato['4']);
            }
        });
    }

    function buscarlistadeegresos() {
        $.ajax({
            type: "POST",
            url: "../../controller/cargar_tabla_temp_de_egresos.php", //validacion de datos de registro
            success: function(r) {
                if (r == 1) {
                    $('#cargue_de_tabla').load("tabla_cargue_temp.php");
                    return false;
                }
            }
        });
    }

    function procesoagregadoactualizado(id) {
        if ($('#descripcion').val() == '' || $('#valor').val() == '') {
            alertify.error("Debes llenar todos los campos");
        } else {
            cadena = "form1=" + $('#descripcion').val() +
                "&form2=" + $('#valor').val() +
                "&form3=" + $('#tipo').val() +
                "&form4=" + $('#estado').val() +
                "&form5=" + $('#id').val() +
                "&form6=" + id;
            $.ajax({
                type: "POST",
                url: "../../controller/procesoagregadoactualizado.php", //validacion de datos de registro
                data: cadena,
                success: function(r) {
                    if (r == 1) {
                        buscarlistadeegresos();
                        alertify.success("Egreso agregado");
                        if (id == 1) {
                            $('#descripcion').val("");
                            $('#valor').val("");
                            $('#id').val("");
                        }
                    } else if (r == 2) {
                        alertify.error("Error al agregar");
                    } else if (r == 3) {
                        buscarlistadeegresos();
                        alertify.success("Egreso Actualizado, recuerda, volver a buscar");
                    } else if (r == 4) {
                        alertify.error("Error al Actualizar");
                    }
                }
            });
        }
    }
</script>