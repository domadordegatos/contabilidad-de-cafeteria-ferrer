<?php require_once "../home/navbar.php"; 
date_default_timezone_set('America/Bogota');
$fecha_actual = date("Y-m-d");?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compradores</title>
    <?php require_once "../../model/libraries/lib.php"; ?>
</head>
<body onload="buscar_lista_de_compradores()">
    <div class="contendor d-flex">
        <div class="separador1 w-50 mx-4">
            <div class="row">
                <div class="col-12">
                    <h4 class="text-center mt-4">Agregado de Compradores</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                      <label for="">Nombre del comprador</label>
                      <input type="text" name="nombre_comprador" id="nombre_comprador" class="form-control" placeholder="" aria-describedby="helpId">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <button type="button" name="" id="" class="btn btn-primary btn-lg btn-block" onclick="agregar_comprador()">Agregar Comprador</button>
                </div>
            </div>
        </div>
        <div class="separador2 w-50 mx-5" id="tabla_cargue">

        </div>
    </div>
    
</body>
</html>

<script>
    function agregar_comprador() {
        if ($('#nombre_comprador').val() == '') {
            alertify.error("Debes llenar todos los campos");
        } else {
            cadena = "form1=" + $('#nombre_comprador').val();
            $.ajax({
                type: "POST",
                url: "../../controller/cocina/agregar_comprador.php", //validacion de datos de registro
                data: cadena,
                success: function(r) {
                    if (r == 1) {
                        buscar_lista_de_compradores();
                        alertify.success("Comprador agregado");
                            $('#nombre_comprador').val("");
                    } else if (r == 2) {
                        alertify.error("Error al agregar");
                    }
                }
            });
        }
    }

    function buscar_lista_de_compradores() {
        $.ajax({
            type: "POST",
            url: "../../controller/cocina/buscar_lista_de_compradores.php", //validacion de datos de registro
            success: function(r) {
                if (r == 1) {
                    $('#tabla_cargue').load("tabla_cargue.php");
                    return false;
                }
            }
        });
    }
</script>