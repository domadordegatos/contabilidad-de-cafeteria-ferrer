<?php
session_start();
?>
<table class="table">
    <thead>
        <tr class="text-center">
            <th scope="col">Fecha</th>
            <th scope="col">Producto</th>
            <th scope="col">Tipo</th>
            <th scope="col">Valor</th>
            <th scope="col">Cantidad</th>
            <th scope="col">Asunto</th>
        </tr>

    </thead>
    <?php
    if (isset($_SESSION['consultar_reporte_de_ingresos_y_egresos'])) :
        $ingresos= 0; $egresos  = 0;
        foreach (@$_SESSION['consultar_reporte_de_ingresos_y_egresos'] as $key) {
            $dat = explode("||", $key);
    ?>
            <tr>
                <td><?php echo $dat[0]." ".$dat[1]; ?></td>
                <td class="text-center"><?php echo $dat[2] ?></td>
                <td class="text-center bg-<?php if($dat[7] == 6){ echo "success"; } else{ echo "info"; } ?>"><?php if($dat[7] == 6){ echo "INGRESO"; }else{ echo "EGRESO"; } ?></td>
                <td class="text-center">$<?php echo number_format($dat[5]); ?></td>
                <td class="text-center"><?php if($dat[7] == 6){ echo $dat[4]; }  ?></td>
                <td class="text-center"><?php echo $dat[6]; ?></td>
            </tr>

    <?php 
                if($dat[7] == 6){ $ingresos = $ingresos + $dat[5]; }else{ $egresos = $egresos + $dat[5]; }     }
    endif; ?>
    <tr class="table-info">
                <td colspan="2"></td>
                <td class="text-center bg-primary" colspan=""><b>INGRESOS</b></td>
                <td class="text-center"><b>$<?php echo number_format($ingresos); ?></b></td>
                <td colspan="2" ></td>
            </tr>
            <tr class="table-info">
                <td colspan="2"></td>
                <td class="text-center bg-warning" colspan=""><b>EGRESOS</b></td>
                <td class="text-center"><b>$<?php echo number_format($egresos); ?></b></td>
                <td colspan="2" ></td>
            </tr>
            <tr class="table-info">
                <td colspan="2"></td>
                <td class="text-center bg-info" colspan=""><b>DIFERENCIA</b></td>
                <td class="text-center"><b>$<?php echo number_format($ingresos - $egresos); ?></b></td>
                <td colspan="2" ></td>
            </tr>
</table>

<style>
    td {
        padding-top: 0.2rem !important;
        padding-bottom: 0.2rem !important;
    }
</style>