<?php require_once "navbar.php"; ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Cargue</title>
    <?php require_once "../../model/libraries/lib.php"; ?>
</head>

<body onload="cargue()" style="overflow-x: hidden;">
    <div class="contenedor w-100 d-flex">
        <div class="separacion1 w-75 px-5 mt-2" id="cargue_tabla" class="scrroll" style="height: 600px; overflow: auto; overflow-x: auto;">

        </div>
        <div class="separacion2 w-25 px-2">
            <div class="row">
                <div class="col-12 text-center">
                    <h3>Ajustes del Día</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="">Base Moneda</label>
                        <input type="number" class="form-control form-control-sm" id="base_moneda" placeholder="$...">
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="">Base Billete</label>
                        <input type="number" class="form-control form-control-sm" id="base_billete" placeholder="$...">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6"><label for="">Compras Fiadas</label>
                    <input type="number" id="conteo_fiado" class="form-control form-control-sm" placeholder="$...."></div>
                <div class="col-6">
                <label for="">Conteo Final</label>
                    <input type="number" id="conteo_final" class="form-control form-control-sm" placeholder="$...."></div>
            </div>
            <div class="row mt-3">
                <div class="col-6"><button onclick="ver_dia_temp()" type="button" name="" id="" class="btn btn-primary btn-primary-sm btn-block">Ver día <i class="pl-2 bi bi-search"></i></button></div>
                <div class="col-6"><button type="button" name="" id="" class="btn btn-success btn-success-sm btn-block" onclick="cerrar_dia()">Cerrar día <i class="pl-2 bi bi-calendar-check-fill"></i></button></div>
            </div>

            <div class="row mt-5">
                <div class="col-12">
                    <h3 class="text-center">Productos Cargados hoy</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-12" id="productos_cargados_hoy">

                </div>
            </div>

        </div>
    </div>

</body>

</html>

<script>

    function cerrar_dia(){
        if($('#base_moneda').val()=='' || $('#base_billete').val()=='' || $('#conteo_final').val()=='' || $('#conteo_fiado').val()==''){
                alertify.error("Debes ingresar los ajustes del día");
            }else{
        cadena = "form1=" + $('#base_moneda').val()+
                "&form2=" + $('#base_billete').val()+
                "&form3=" + $('#conteo_final').val()+
                "&form4=" + $('#conteo_fiado').val();
        console.log(cadena);
        $.ajax({
            type: "POST",
            url: "../../controller/cerrar_dia.php",
            data:cadena,
            success: function (r) {
                if (r == 5 || r == 7) {
                    alertify.success("Insertado exitoso");
                    listado_cargados_temp();
                }else if(r == 2 || r == 4 || r == 6 || r == 8){
                    alertify.error("Insertado fallido");
                }
            }
        });
    }
    }

    function ver_dia_temp(){
        window.open('ver_dia_temp.php', "Ver Dia", "width=1080, height=600")
    }

    function cargue() {
        listado_cargados_temp();
        $.ajax({
            type: "POST",
            url: "../../controller/cargue_general.php",
            success: function (r) {
                if (r == 1) {
                    $('#cargue_tabla').load("tabla_cargue_temp.php");
                    return false;
                }
            }
        });
    }

    function listado_cargados_temp(){
        $.ajax({
            type: "POST",
            url: "../../controller/listado_cargados_temp.php",
            success: function (r) {
                if (r == 1) {
                    $('#productos_cargados_hoy').load("listado_cargados_temp.php");
                    return false;
                }
            }
        });
    }

    function subir(id) {
        if($('#ingreso'+id).val()==''){
                alertify.error("Debes digitar cuantos ingresaron");
            }else{
        cadena = "form1=" + $('#ingreso'+id).val()+
        "&form2=" + $('#perdida'+id).val()+
        "&form3=" + id+ 
        "&form4=" + $('#restantes'+id).val();
        $.ajax({
            type: "POST",
            url: "../../controller/actualizacion_insertado_en_base_de_datos_inventario.php",
            data:cadena,
            success: function (r) {
                if (r == 1) {
                    alertify.success("Insertado exitoso");
                    listado_cargados_temp();
                }else if(r == 2){
                    alertify.error("Insertado fallido");
                }else if(r == 3){
                    alertify.success("Actualización exitosa");
                    listado_cargados_temp()
                }else if(r == 4){
                    alertify.error("Actualización fallida");
                }else if(r == 5){
                    alertify.error("No es posible ingresar facturas por cierre de inventario");
                }
            }
        });
    }
    }
</script>