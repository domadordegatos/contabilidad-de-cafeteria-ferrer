<?php require_once "../home/navbar.php";
date_default_timezone_set('America/Bogota');
$fecha_actual = date("Y-m-d"); ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Ventas</title>
    <?php require_once "../../model/libraries/lib.php"; ?>
</head>

<body onload="buscar_lista_de_ingresos_cocina()">
    <div class="contenedor w-100 d-flex">
        <div class="w-25 separador1 mx-3">
            <div class="row">
                <div class="col-12 mt-4">
                    <h4 class="text-center">Registro diario de ventas</h4>
                </div>
            </div>

            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="">Producto</label>
                        <select name="" id="productos" class="form-control">

                        </select>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="">Comprador</label>
                        <select name="" id="compradores" class="form-control">

                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="">Cantidad</label>
                        <input type="text" name="" id="cantidad" class="form-control" placeholder="" aria-describedby="helpId">
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="">Valor</label>
                        <input type="text" name="" id="valor" class="form-control" placeholder="$.." aria-describedby="helpId">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <button type="button" name="" id="" class="btn btn-primary btn-lg btn-block" onclick="agregar_nueva_venta()">Agregar Nueva Venta</button>
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
                    <button type="button" name="" id="" class="btn btn-primary btn-lg btn-block" onclick="buscar_lista_de_ingresos_cocina()">Buscar</button>
                </div>
            </div>
        </div>
        <div class="w-75 separador2 mx-5" id="cargue_tabla">

        </div>
    </div>

</body>

</html>

<script>
    function agregar_nueva_venta() {
        if($('#cantidad').val()=='' || $('#valor').val()=='' || $('#productos').val()=='A' || $('#compradores').val()=='A'){
                alertify.error("Error los campos");
            }else{
        cadena = "form1=" + $('#cantidad').val() +
            "&form2=" + $('#valor').val() +
            "&form3=" + $('#productos').val() +
            "&form4=" + $('#compradores').val();
        $.ajax({
            type: "POST",
            url: "../../controller/cocina/agregar_venta_cocina.php", //validacion de datos de registro
            data: cadena,
            success: function(r) {
                if (r == 1) {
                    buscar_lista_de_ingresos_cocina();
                    alertify.success("Producto agregado");
                        $('#cantidad').val("");
                        $('#valor').val("");
                } else if (r == 2) {
                    alertify.error("Error al agregar");
                }
            }
        });
    }
    }

    function buscar_lista_de_ingresos_cocina() {
        buscar_lista_de_compradores();
        buscar_lista_de_productos_cocina();
        cadena = "form1=" + $('#fechainicio').val() +
            "&form2=" + $('#fechafin').val();
        $.ajax({
            type: "POST",
            url: "../../controller/cocina/buscar_lista_de_ingresos_cocina.php", //validacion de datos de registro
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

    function buscar_lista_de_compradores() {
        $.ajax({
            type: "POST",
            url: "../../controller/cocina/buscar_lista_de_compradores.php", //validacion de datos de registro
            success: function(r) {
                if (r == 1) {
                    $('#compradores').load("listado_cargados_compradores.php");
                    return false;
                }
            }
        });
    }

    function buscar_lista_de_productos_cocina() {
        $.ajax({
            type: "POST",
            url: "../../controller/cocina/buscar_lista_de_productos_cocina.php", //validacion de datos de registro
            success: function(r) {
                if (r == 1) {
                    $('#productos').load("listado_cargados_productos.php");
                    return false;
                }
            }
        });
    }
</script>