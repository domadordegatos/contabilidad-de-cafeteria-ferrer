<?php
session_start();
require_once "../../model/conexion.php";
$conexion = conexion();
?>
<div class="separador1 w-100 mx-2">
<div class="row">
        <div class="col-12">
            <h4 class="text-center">INGRESOS</h4>
        </div>
    </div>
    <table class="table table-sm">
        <thead>
            <tr class="text-center">
                <th scope="col">Fecha</th>
                <th scope="col">Hora cierre</th>
                <th scope="col">Ventas</th>
                <th scope="col">Total Caja</th>
                <th scope="col">Ganancia Real</th>
                <th scope="col">Dif. Ventas - Caja</th>
                <th scope="col">Fiado</th>
                <th scope="col">Caja + Fiado</th>
                <th scope="col">Vista</th>
            </tr>

        </thead>
        <?php
        if (isset($_SESSION['cargue_ingresos_egresos_reporte'])) :
            $ventas = 0;
            $t_caja = 0;
            $g_real = 0;
            $dif_ventas = 0;
            $fiado = 0;
            $caja_fiado = 0;
            foreach (@$_SESSION['cargue_ingresos_egresos_reporte'] as $key) {
                $dat = explode("||", $key);

                $sql = "SELECT carga_de_inventario.pedidos, carga_de_inventario.perdidas, productos.nombre, productos.cantidadxpaquete, productos.valorxunidad, productos.precio_compra,
productos.tipo, carga_de_inventario.acumulante, carga_de_inventario.bodega FROM carga_de_inventario 
JOIN productos ON productos.id_producto = carga_de_inventario.id_producto 
WHERE fecha = '$dat[1]' ORDER BY carga_de_inventario.id_producto, carga_de_inventario.id_carga";
                $result = mysqli_query($conexion, $sql);
                $ganancia_caja = 0;
        $ganancia_real = 0;
        $suma_bodega_menos_restantes = 0;
        $tipo = 0;
        while ($ver1 = mysqli_fetch_row($result)) {
            if ($ver1[7] != null && $ver1[6] == 2) {
                $tipo = 2;/* se hacen operaciones */
            } else if ($ver1[7] == null && $ver1[6] == 2) {
                $tipo = 3;/* no se muesta nada */
            } else {
                $tipo = 1;/* operaciones normales */
            }
            $suma_bodega_menos_restantes = ($ver1[8] - $ver1[7]);

            if ($tipo == 2) { //ganancias para productos incontables
                $ganancia_caja = $ganancia_caja + (($suma_bodega_menos_restantes - $ver1[1]) * ($ver1[4]));
            } else if ($ver1[6] == 1) { //ganancias caja para productos contables
                $ganancia_caja = $ganancia_caja + (($ver1[0] - $ver1[1]) * ($ver1[4]));
            }

            if ($tipo == 2) {
                $ganancia_real = $ganancia_real + ((($suma_bodega_menos_restantes - $ver1[1]) * ($ver1[5])));
            } else if ($tipo == 1) {
                $ganancia_real = $ganancia_real + ((($ver1[0] - $ver1[1]) * ($ver1[5])));
            }
        }
        ?>
                <tr>
                    <td><?php echo $dat[1] ?></td>
                    <td class="text-center"><?php echo $dat[2] ?></td>
                    <td class="text-center">$<?php echo number_format($ganancia_caja) ?></td>
                    <td class="text-center">$<?php echo number_format($dat[6]) ?></td>
                    <td class="text-center">$<?php echo number_format($ganancia_real) ?></td>
                    <td class="text-center">$<?php echo number_format($dat[6] - $ganancia_caja) ?></td><!-- ventas - dinero en caja -->
                    <td class="text-center">$<?php echo number_format($dat[8]) ?></td><!-- fiado-->
                    <td class="text-center">$<?php echo number_format($ganancia_caja + $dat[8]) ?></td><!-- caja + fiado-->
                    <td class="text-center"><button class="btn btn-sm btn-primary" onclick="vista_reporte_por_fecha('<?php echo $dat[1]; ?>')"><i class="bi bi-search"></i></button></td>
                </tr>

        <?php $ventas = $ventas + $ganancia_caja;
                $t_caja = $t_caja + $dat[6];
                $g_real = $g_real + $ganancia_real;
                $dif_ventas = $dif_ventas + ($dat[6] - $ganancia_caja);
                $fiado = $fiado + $dat[8];
                $caja_fiado = $caja_fiado + ($ganancia_caja + $dat[8]);
            }
        endif; ?>
        <tr class="table-success">
            <td colspan="2"><b>TOTAL</b></td>
            <td class="text-center">$<?php echo number_format($ventas) ?></td>
            <td class="text-center">$<?php echo number_format($t_caja) ?></td>
            <td class="text-center">$<?php echo number_format($g_real) ?></td>
            <td class="text-center">$<?php echo number_format($dif_ventas) ?></td><!-- ventas - dinero en caja -->
            <td class="text-center">$<?php echo number_format($fiado) ?></td><!-- suma fiado -->
            <td class="text-center">$<?php echo number_format($caja_fiado) ?></td><!-- suma fiado + caja -->
            <td></td>
        </tr>
    </table>
</div>

<style>
    td {
        padding-top: 0.2rem !important;
        padding-bottom: 0.2rem !important;
    }
</style>