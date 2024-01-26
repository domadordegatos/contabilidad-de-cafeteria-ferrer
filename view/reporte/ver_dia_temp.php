<?php
session_start();
require_once "../../model/libraries/lib.php";

unset($_SESSION['ver_dia_temp_para_reporte']);
$variableRecibida = $_GET['fecha'];
require_once "../../model/conexion.php";
$conexion = conexion();
$sql = "SELECT carga_de_inventario.pedidos, carga_de_inventario.perdidas, productos.nombre, productos.cantidadxpaquete, productos.valorxunidad, productos.precio_compra,
productos.tipo, carga_de_inventario.acumulante, carga_de_inventario.bodega FROM carga_de_inventario 
JOIN productos ON productos.id_producto = carga_de_inventario.id_producto 
WHERE fecha = '$variableRecibida' ORDER BY carga_de_inventario.id_producto, carga_de_inventario.id_carga";

$result = mysqli_query($conexion, $sql);
while ($ver1 = mysqli_fetch_row($result)) {
    $tabla = $ver1[0] . "||" . //0pedidos
        $ver1[1] . "||" . //1perdidas
        $ver1[2] . "||" . //2nombre
        $ver1[3] . "||" . //3cantidad x paquete
        $ver1[4] . "||" . //4valor x unidad
        $ver1[5] . "||" . //5precio de compra
        $ver1[6] . "||" . //6tipo
        $ver1[7] . "||" . //7acumulante
        $ver1[8] . "||";  //8bodega
    $_SESSION['ver_dia_temp_para_reporte'][] = $tabla;
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
            <th scope="col">Ventas Hoy</th>
            <th>Perdidas</th>
            <th>Gancia Real</th>
        </tr>

    </thead>
    <?php
    if (isset($_SESSION['ver_dia_temp_para_reporte'])) :
        $ganancia_caja = 0;
        $perdidas = 0;
        $ganancia_real = 0;
        $suma_bodega_menos_restantes = 0;
        $tipo = 0;
        foreach (@$_SESSION['ver_dia_temp_para_reporte'] as $key) {
            $dat = explode("||", $key);

            if ($dat[7] != null && $dat[6] == 2) {
                $tipo = 2;/* se hacen operaciones */
            } else if ($dat[7] == null && $dat[6] == 2) {
                $tipo = 3;/* no se muesta nada */
            } else {
                $tipo = 1;/* operaciones normales */
            }
    ?>
            <tr>
                <td><?php echo $dat[2] . "x" . $dat[3];
                    if ($dat[0] == 0 && $dat[6] == 2) {
                        echo "  (C)";
                    } ?></td> <!-- SI el ingreso es cero y es no contable se agrega la c de cierre -->
                <?php if ($tipo == 2) {
                    $suma_bodega_menos_restantes = ($dat[8] - $dat[7]);
                } ?>
                <td class="text-center"><?php echo "$" . number_format($dat[4]); ?></td><!-- precio -->
                <td class="text-center"><?php if ($tipo == 2) {/* cantidad unitaria vendida */
                                            echo $suma_bodega_menos_restantes . " A";
                                        } else {
                                            echo $dat[0];
                                        } ?></td>
                <td class="text-center"><?php echo $dat[1]; ?></td><!-- perdidas -->
                <td class="text-center"><?php if ($tipo == 2) { //ganancias para productos incontables
                                            echo "$" . number_format(($suma_bodega_menos_restantes - $dat[1]) * ($dat[4]));
                                        } else if ($dat[6] == 1) { //ganancias para productos contables
                                            echo "$" . number_format(($dat[0] - $dat[1]) * ($dat[4]));
                                        } ?></td><!-- se muesta si el ultimo campo es null o es de tipo contable -->
                <td class="text-center"><?php if ($tipo == 2 || $tipo == 1) {
                                            echo "$" . number_format($dat[1] * $dat[4]);
                                        } ?></td>
                <td class="text-center"><?php if ($tipo == 2) {
                                            echo "$" . number_format((($suma_bodega_menos_restantes - $dat[1]) * ($dat[5])));
                                        } else if ($tipo == 1) {
                                            echo "$" . number_format((($dat[0] - $dat[1]) * ($dat[5])));
                                        } ?></td>
            </tr>
        <?php
            if ($tipo == 2) { //ganancias para productos incontables
                $ganancia_caja = $ganancia_caja + (($suma_bodega_menos_restantes - $dat[1]) * ($dat[4]));
            } else if ($dat[6] == 1) { //ganancias caja para productos contables
                $ganancia_caja = $ganancia_caja + (($dat[0] - $dat[1]) * ($dat[4]));
            }

            if ($tipo == 2 || $tipo == 1) {
                $perdidas = $perdidas + ($dat[1] * $dat[4]);
            }

            if ($tipo == 2) {
                $ganancia_real = $ganancia_real + ((($suma_bodega_menos_restantes - $dat[1]) * ($dat[5])));
            } else if ($tipo == 1) {
                $ganancia_real = $ganancia_real + ((($dat[0] - $dat[1]) * ($dat[5])));
            }
        }
    endif;
    if (isset($ganancia_caja)) { ?>

        <tr class="table-primary">
            <td colspan="3"></td>
            <td class="text-right"><b>TOTALES</b></td>
            <td class="text-center"><b><?php echo "$" . number_format($ganancia_caja);  ?></b></td>
            <td class="text-center"><b><?php echo "$" . number_format($perdidas);  ?></b></td>
            <td class="text-center"><b><?php echo "$" . number_format($ganancia_real);  ?></b></td>
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
            <td>$<?php echo number_format($ver2[3] + $ver2[4]); ?></td>
        </tr>
    <?php } ?>
    <tr>
        <td colspan="7" class="text-center">-</td>
    </tr>
    <?php if (isset($ver3)) { ?>
        <tr class="table-info">
            <td colspan="5"></td>
            <td class="text-right"><b>DINERO EN CAJA</b></td>
            <td>$<?php echo number_format($ver3[6]); ?></td>
        </tr>
    <?php } ?>
    <tr>
        <td colspan="7" class="text-center">-</td>
    </tr>
    <?php if (isset($ver2)) { ?>
        <tr class="table-info">
            <td colspan="3"></td>
            <td colspan="3" class="text-right"><b>DINERO DE VENTAS</b></td>
            <td>$<?php echo isset($ganancia_caja) ? number_format($ganancia_caja) : 0;
                    ?></td>
        </tr>
        <tr class="table-info">
            <td colspan="3"></td>
            <td colspan="3" class="text-right"><b>DINERO FIADO</b></td>
            <td>$<?php echo number_format($ver3[8]); ?></td>
        </tr>
        <tr class="table-info">
            <td colspan="3"></td>
            <td colspan="3" class="text-right"><b>DINERO VENTAS - DINERO FIADO</b></td>
            <td>$<?php $resultado = isset($ganancia_caja) && isset($ver3[8]) ? number_format($ganancia_caja - $ver3[8]) : 0;
                    echo $resultado; ?></td>
        </tr>
        <tr class="table-info">
            <td colspan="3"></td>
            <td colspan="3" class="text-right"><b>DIFERENCIA VENTAS Y CAJA</b></td>
            <td>$<?php $resultado = isset($ganancia_caja) && isset($ver3[6]) ? number_format($ganancia_caja - $ver3[6]) : 0;
                    echo $resultado;
                    ?></td>
        </tr>
    <?php } ?>
</table>

<style>
    td {
        padding-top: 0.2rem !important;
        padding-bottom: 0.2rem !important;
    }
</style>