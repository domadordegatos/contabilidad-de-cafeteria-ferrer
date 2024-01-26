<?php require_once "../home/navbar.php"; ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
    <?php require_once "../../model/libraries/lib.php"; ?>
</head>

<body onload="buscar_productos()" style="overflow-x:hidden;">

<div class="contenedor mx-3 d-flex w-100">
    <div class="separador1 w-50">
            <div class="contenedor mt-4 mx-5">
                <div class="row">
                    <div class="col">
                        <h3 class="text-center">Gestíon de Productos</h3>
                    </div>
                </div>
                <div class="row my-3">
                    <div class="col-12">
                        <select class="form-control" name="selecciondeproducto" id="selecciondeproducto">
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <label for="">Nombre del Producto</label>
                        <input type="text" class="form-control" id="nombre" placeholder="">
                    </div>
                    <div class="col-6">
                        <label for="">Cantidad por Paquete</label>
                        <input type="number" class="form-control" id="cantidadxpaquete" placeholder="">
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <label for="">Precio Unidad x Venta</label>
                        <input type="number" class="form-control" id="preciounidadxventa" placeholder="">
                    </div>
                    <div class="col-6">
                        <label for="">Precio de compra x unidad</label>
                        <input type="number" class="form-control" id="preciounidadporventa" placeholder="">
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <label for="">Estado</label>
                        <select class="form-control" id="estado">
                            <option value="1">Activo</option>
                            <option value="2">Inactivo</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <label for="">Tipo de conteo</label>
                        <select class="form-control" id="tipodeconteo">
                            <option value="1">Se contabiliza</option>
                            <option value="2">No se contabiliza</option>
                        </select>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-6">
                        <button type="button" class="btn btn-primary btn-lg btn-block" onclick="agregar(1)">Agregar</button>
                    </div>
                    <div class="col-6">
                        <button type="button" class="btn btn-success btn-lg btn-block" onclick="agregar(2)">Actualizar</button>
                    </div>
                </div>
            </div>
    </div>

    <div class="separador2 w-50">
        <div class="row">
            <div class="col-12 text-center mt-4"><h4>Inventario Incontables</h4></div>
        </div>
        <div class="row">
            <div class="col-12" id="cargue_tabla" class="scrroll"  style="height: 500px; overflow: auto; overflow-x: auto;">

            </div>
        </div>
    </div>
</div>

</body>

</html>

<script>

function cargue() {
        $.ajax({
            type: "POST",
            url: "../../controller/cargue_inventario_incontables.php",
            success: function (r) {
                if (r == 1) {
                    $('#cargue_tabla').load("tabla_cargue_temp_productos.php");
                    return false;
                }
            }
        });
    }

    $(document).ready(function() {
        $("select[name=selecciondeproducto]").change(function() {
            cadena = "form1=" + $('#selecciondeproducto').val();
            $.ajax({
                type: "POST",
                url: "../../controller/buscar_un_solo_productos.php", //validacion de datos de registro
                data: cadena,
                success: function(r) {
                    dato = jQuery.parseJSON(r);
                    $('#nombre').val(dato['1']);
                    $('#cantidadxpaquete').val(dato['2']);
                    $('#preciounidadxventa').val(dato['3']);
                    $('#preciounidadporventa').val(dato['5']);
                    $('#estado').val(dato['4']);
                    $('#tipodeconteo').val(dato['6']);
                }
            });
        });
    });

    function buscar_productos() {
        $.ajax({
            type: "POST",
            url: "../../controller/buscar_productos.php",
            success: function(r) {
                if (r == 1) {
                    $('#selecciondeproducto').load("listado_cargados_temp.php");
                    cargue();
                }
            }
        });
    }

    function agregar(id) {
        if($('#nombre').val()=='' || $('#cantidadxpaquete').val()=='' || $('#preciounidadxventa').val()=='' || $('#preciounidadporventa').val()==''){
                alertify.error("Debes llenar todos los campos");
            }else{
        cadena = "form1=" + $('#nombre').val() +
            "&form2=" + $('#cantidadxpaquete').val() +
            "&form3=" + $('#preciounidadxventa').val() +
            "&form4=" + $('#preciounidadporventa').val() +
            "&form5=" + $('#estado').val() +
            "&form6=" + $('#tipodeconteo').val() +
            "&form7=" + id +
            "&form8=" + $('#selecciondeproducto').val();
        $.ajax({
            type: "POST",
            url: "../../controller/argregar_producto.php", //validacion de datos de registro
            data: cadena,
            success: function(r) {
                if (r == 1) {
                    buscar_productos();
                    alertify.success("Producto agregado");
                    if (id == 1) {
                        $('#nombre').val("");
                        $('#cantidadxpaquete').val("");
                        $('#preciounidadxventa').val("");
                        $('#preciounidadporventa').val("");
                        $('#estado').val("");
                        $('#tipodeconteo').val("");
                        $('#selecciondeproducto').val("");
                    }
                } else if (r == 2) {
                    alertify.error("Error al agregar");
                } else if (r == 3) {
                    buscar_productos();
                    alertify.success("Producto Actualizado");
                } else if (r == 4) {
                    alertify.error("Error al Actualizar");
                }
            }
        });
    }
    }
</script>