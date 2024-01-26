<?php
session_start();
?>
<table class="table">
    <thead>
        <tr class="text-center">
            <th scope="col">Fecha</th>
            <th scope="col">Descripcion</th>
            <th scope="col">Valor</th>
        </tr>

    </thead>
    <?php
    if (isset($_SESSION['buscar_lista_de_gastos_cocina'])) :
        $total= 0;
        foreach (@$_SESSION['buscar_lista_de_gastos_cocina'] as $key) {
            $dat = explode("||", $key);
    ?>
            <tr>
                <td class="text-center"><?php echo $dat[0]." ".$dat[1]; ?></td>
                <td class="text-center"><?php echo $dat[6] ?></td>
                <td class="text-center">$<?php echo number_format($dat[5]); ?></td>
            </tr>

    <?php $total = $total + $dat[5]; }
    endif; ?>
    <tr class="table-info">
                <td colspan="2"></td>
                <td class="text-center"><b>$<?php echo number_format($total); ?></b></td>
            </tr>
</table>

<style>
    td {
        padding-top: 0.2rem !important;
        padding-bottom: 0.2rem !important;
    }
</style>