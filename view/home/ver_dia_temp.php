<?php
session_start();
require_once "../../model/libraries/lib.php";

unset($_SESSION['ver_dia_temp']);
        require_once "../../model/conexion.php";
        $conexion = conexion();
            $sql = "SELECT carga_de_inventario.pedidos, carga_de_inventario.perdidas, productos.nombre, productos.cantidadxpaquete, productos.valorxunidad, productos.precio_compra,
            productos.tipo FROM carga_de_inventario
            JOIN productos ON productos.id_producto =  carga_de_inventario.id_producto WHERE fecha = CURDATE()";
            $result = mysqli_query($conexion, $sql);
            while ($ver1 = mysqli_fetch_row($result)) {
                $tabla = $ver1[0] . "||" . //0pedidos
                         $ver1[1] . "||" . //1perdidas
                         $ver1[2] . "||" . //2nombre
                         $ver1[3] . "||" . //3cantidad x paquete
                         $ver1[4] . "||" . //4valor x unidad
                         $ver1[5] . "||". //5precio de compra
                         $ver1[6] . "||" ; //6tipo
                $_SESSION['ver_dia_temp'][] = $tabla;
            }
            $sql2 = "SELECT * FROM base_cartera WHERE fecha = CURDATE()";
            $result2 = mysqli_query($conexion, $sql2);
            $ver2 = mysqli_fetch_row($result2);

            $sql3 = "SELECT * FROM registro_diario WHERE fecha = CURDATE()";
            $result3 = mysqli_query($conexion, $sql3);
            $ver3 = mysqli_fetch_row($result3);
 ?>
<table class="table">
    <thead>
        <tr class="text-center">
            <th scope="col">Producto</th>
            <th scope="col">Precio U.</th>
            <th scope="col">Ingreso</th>
            <th scope="col">Perdida</th>
            <th scope="col">Ganancias Caja</th>
            <th>Perdidas</th>
            <th>Gancia Real</th>
        </tr>

    </thead>
    <?php
    if (isset($_SESSION['ver_dia_temp'])) :
        $ganancia_caja=0; $perdidas=0; $ganancia_real=0; $ganancia_caja_sin_contables = 0; $ganancia_real_sin_contables=0;
        foreach (@$_SESSION['ver_dia_temp'] as $key) {
            $dat = explode("||", $key);
    ?>
            <tr>
                <td><?php echo $dat[2]."x".$dat[3]; ?></td>
                <td class="text-center"><?php echo "$".number_format($dat[4]); ?></td>
                <td class="text-center"><?php echo $dat[0]; ?></td>
                <td class="text-center"><?php echo $dat[1]; ?></td>
                <td class="text-center"><?php echo "$".number_format(($dat[0]-$dat[1])*($dat[4]) * $dat[3]); ?></td>
                <td class="text-center"><?php echo "$".number_format($dat[1]*$dat[5]); ?></td>
                <td class="text-center"><?php echo "$".number_format((($dat[0]-$dat[1])*($dat[5]))*$dat[3]); ?></td>
            </tr>
    <?php $ganancia_caja=$ganancia_caja + (($dat[0]-$dat[1])*($dat[4]) * $dat[3]);
        if($dat[6] == 1){ $ganancia_caja_sin_contables=$ganancia_caja_sin_contables + (($dat[0]-$dat[1])*($dat[4]) * $dat[3]); }
          $perdidas = $perdidas + ($dat[1]*$dat[5]);
        if($dat[6] == 1){ $ganancia_real_sin_contables = $ganancia_real_sin_contables + ((($dat[0]-$dat[1])*($dat[5]))*$dat[3]); }
          $ganancia_real = $ganancia_real + ((($dat[0]-$dat[1])*($dat[5]))*$dat[3]); 

        }
    endif; if(isset($ganancia_caja)) { ?>
    
    <tr class="table-primary">
        <td colspan="3"></td>
        <td class="text-right"><b>TOTALES</b></td>
        <td class="text-center"><b><?php echo "$".number_format($ganancia_caja);  ?></b></td>
        <td class="text-center"><b><?php echo "$".number_format($perdidas);  ?></b></td>
        <td class="text-center"><b><?php echo "$".number_format($ganancia_real);  ?></b></td>
    </tr>
    <?php } ?>
    <tr>
        <td colspan="7" class="text-center">-</td>
    </tr>
    <?php if (isset($ver2)) { ?>
    <tr class="table-info">
        <td colspan="3"></td>
        <td class="text-right"><b>BASE MONEDA</b></td>
        <td class="">$<?php echo number_format($ver2[3]); ?></td>
        <td class="text-right"><b>BASE BILLETE</b></td>
        <td class="">$<?php echo number_format($ver2[4]); ?></td>
    </tr>
    <tr class="table-info">
        <td colspan="5"></td>
        <td class="text-right"><b>TOTAL BASE</b></td>
        <td>$<?php echo number_format($ver2[3]+$ver2[4]); ?></td>
    </tr>
    <?php }?>
    <tr>
        <td colspan="7" class="text-center">-</td>
    </tr>
    <?php if (isset($ver3)) { ?>
    <tr class="table-info">
        <td colspan="5"></td>
        <td class="text-right"><b>DINERO EN CAJA</b></td>
        <td>$<?php echo $ver3[6]; ?></td>
    </tr>
    <?php } ?>
    <tr>
        <td colspan="7" class="text-center">-</td>
    </tr>
    <?php if (isset($ver2)) { ?>
    <tr class="table-info">
        <td colspan="3"></td>
        <td colspan="3" class="text-right"><b>GANANCIA CAJA SIN PRODUCTOS CONTABLES</b></td>
        <td>$<?php echo number_format($ganancia_caja_sin_contables); ?></td>
    </tr>
    <tr class="table-info">
        <td colspan="3"></td>
        <td colspan="3" class="text-right"><b>GANANCIA REAL SIN PRODUCTOS CONTABLES</b></td>
        <td>$<?php echo number_format($ganancia_real_sin_contables); ?></td>
    </tr>
    <tr class="table-info">
        <td colspan="3"></td>
        <td colspan="3" class="text-right"><b>DIFERENCIA DE GANANCIAS CAJA Y CONTEO DE CAJA</b></td>
        <td>$<?php echo number_format($ver3[6] - $ganancia_caja); ?></td>
    </tr>
    <tr class="table-info">
        <td colspan="3"></td>
        <td colspan="3" class="text-right"><b>DIFERENCIA DE GANANCIAS REALES SIN CONTABLES Y CAJA</b></td>
        <td>$<?php echo number_format($ver3[6] - $ganancia_real_sin_contables); ?></td>
    </tr>
    <?php } ?>
</table>

<style>
    td{
        padding-top: 0.2rem !important;
        padding-bottom: 0.2rem !important;
    }
</style>