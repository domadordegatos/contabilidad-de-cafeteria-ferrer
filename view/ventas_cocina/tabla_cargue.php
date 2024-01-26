<?php
session_start();
?>
<table class="table">
    <thead>
        <tr class="text-center">
            <th scope="col">Fecha</th>
            <th scope="col">Producto</th>
            <th scope="col">Cliente</th>
            <th scope="col">Cantidad</th>
            <th scope="col">Valor</th>
        </tr>

    </thead>
    <?php
    if (isset($_SESSION['buscar_lista_de_ingresos_cocina'])) :
        $total= 0;
        foreach (@$_SESSION['buscar_lista_de_ingresos_cocina'] as $key) {
            $dat = explode("||", $key);
    ?>
            <tr>
                <td><?php echo $dat[0]." ".$dat[1]; ?></td>
                <td class="text-center"><?php echo $dat[2] ?></td>
                <td class="text-center"><?php echo $dat[3] ?></td>
                <td class="text-center"><?php echo $dat[4] ?></td>
                <td class="text-center">$<?php echo number_format($dat[5]); ?></td>
            </tr>

    <?php $total = $total + $dat[5]; }
    endif; ?>
    <tr class="table-info">
                <td colspan="4"></td>
                <td class="text-center"><b>$<?php echo number_format($total); ?></b></td>
            </tr>
</table>

<style>
    td {
        padding-top: 0.2rem !important;
        padding-bottom: 0.2rem !important;
    }
</style>