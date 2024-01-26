<?php
session_start();
?>
<table class="table">
    <thead>
        <tr class="text-center">
            <th scope="col">Nombre</th>
            <th scope="col">Cantidad Bodega</th>
            <th scope="col">Fecha Registro</th>
            <th scope="col">Hora Registro</th>
        </tr>

    </thead>
    <?php
    if (isset($_SESSION['cargue_inventario_incontables'])) :
        foreach (@$_SESSION['cargue_inventario_incontables'] as $key) {
            $dat = explode("||", $key);
    ?>
            <tr>
                <td><?php echo $dat[2]." x ".$dat[3] ?></td>
                <td class="text-center"><?php echo $dat[4] ?></td>
                <td class="text-center"><?php echo $dat[0] ?></td>
                <td class="text-center"><?php echo $dat[1] ?></td>
            </tr>

    <?php }
    endif; ?>
</table>

<style>
    td {
        padding-top: 0.2rem !important;
        padding-bottom: 0.2rem !important;
    }
</style>