<?php require_once "../home/navbar.php";
date_default_timezone_set('America/Bogota');
$fecha_actual = date("Y-m-d"); ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gastos Cocina</title>
    <?php require_once "../../model/libraries/lib.php"; ?>
</head>

<body onload="buscar_lista_de_gastos_cocina()">
    <div class="contenedor w-100 d-flex">
        <div class="w-25 separador1 mx-3">
            <div class="row">
                <div class="col-12 mt-4">
                    <h4 class="text-center">Ingreso de Gasto</h4>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label for="">Descripcion</label>
                        <input type="text" id="descripcion" class="form-control">
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label for="">Valor</label>
                        <input type="number" id="valor" class="form-control" placeholder="$...">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <button type="button" name="" id="" class="btn btn-primary btn-lg btn-block" onclick="agregar_nuevo_gasto()">Agregar Nuevo Gasto</button>
                </div>
            </div>


            <div class="row mx-2 mt-5">
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
                    <button type="button" name="" id="" class="btn btn-primary btn-lg btn-block" onclick="buscar_lista_de_gastos_cocina()">Buscar</button>
                </div>
            </div>
        </div>
        <div class="w-75 separador2 mx-5" id="cargue_tabla">

        </div>
    </div>

</body>

</html>

<script>
    function agregar_nuevo_gasto() {
        if($('#descripcion').val()=='' || $('#valor').val()==''){
                alertify.error("Error los campos");
            }else{
        cadena = "form1=" + $('#descripcion').val() +
            "&form2=" + $('#valor').val();
        $.ajax({
            type: "POST",
            url: "../../controller/cocina/agregar_nuevo_gasto.php", //validacion de datos de registro
            data: cadena,
            success: function(r) {
                if (r == 1) {
                    buscar_lista_de_gastos_cocina();
                    alertify.success("Gasto agregado");
                        $('#descripcion').val("");
                        $('#valor').val("");
                } else if (r == 2) {
                    alertify.error("Error al agregar");
                }
            }
        });
    }
    }

    function buscar_lista_de_gastos_cocina() {
        cadena = "form1=" + $('#fechainicio').val() +
            "&form2=" + $('#fechafin').val();
        $.ajax({
            type: "POST",
            url: "../../controller/cocina/buscar_lista_de_gastos_cocina.php", //validacion de datos de registro
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