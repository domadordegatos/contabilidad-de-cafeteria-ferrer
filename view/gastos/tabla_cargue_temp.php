<?php
session_start();
?>
<table class="table">
    <thead>
        <tr class="text-center">
            <th scope="col">Descripcion</th>
            <th scope="col">Valor</th>
            <th scope="col">Estado</th>
            <th scope="col">Tipo</th>
            <th scope="col">Fecha</th>
            <th scope="col">Hora</th>
            <th scope="col">Opcion</th>
        </tr>

    </thead>
    <?php
    if (isset($_SESSION['cargar_tabla_temp_de_egresos_por_fecha'])) :
        $total=0;
        foreach (@$_SESSION['cargar_tabla_temp_de_egresos_por_fecha'] as $key) {
            $dat = explode("||", $key);
    ?>
            <tr>
                <td><?php echo $dat[3] ?></td>
                <td class="text-right">$<?php echo number_format($dat[4]) ?></td>
                <td class="text-center"><?php echo $dat[5] ?></td>
                <td class="text-center"><?php echo $dat[6] ?></td>
                <td class="text-center"><?php echo $dat[1] ?></td>
                <td class="text-center"><?php echo $dat[2] ?></td>
                <td class="text-center"><button class="btn btn-sm btn-primary" onclick="obtener_datos_del_egreso(<?php echo $dat[0]; ?>)"><i class="bi bi-pencil-square"></i></button></td>
            </tr>

    <?php $total = $total + $dat[4]; }
    endif; ?>
    <tr class="table-info">
                <td></td>
                <td class="text-right">$<?php echo number_format($total) ?></td>
                <td colspan="5" class="text-center"></td>
            </tr>
</table>

<style>
    td {
        padding-top: 0.2rem !important;
        padding-bottom: 0.2rem !important;
    }
</style>