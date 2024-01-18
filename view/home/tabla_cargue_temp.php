<?php
session_start();
 ?>
<table class="table">
    <thead>
        <tr class="text-center">
            <th scope="col">Producto</th>
            <th scope="col">Precio U.</th>
            <th scope="col">Ingreso</th>
            <th scope="col">Perdida</th>
            <th scope="col">Restantes</th>
            <th scope="col">Carga</th>
        </tr>

    </thead>
    <?php
    if (isset($_SESSION['tabla_cargue'])) :
        foreach (@$_SESSION['tabla_cargue'] as $key) {
            $dat = explode("||", $key);
    ?>
            <tr>
                <td><?php echo $dat[1] ?></td>
                <td><?php echo "$".number_format($dat[2]); ?></td>
                <td><input type="number" class="form-control form-control-sm" id="ingreso<?php echo $dat[0]; ?>"></td>
                <td><input type="number" class="form-control form-control-sm" id="perdida<?php echo $dat[0]; ?>"></td>
                <td><input <?php if($dat[3] == 1){ echo 'disabled';} ?> type="number" class="form-control form-control-sm" id="restantes<?php echo $dat[0]; ?>"></td>
                <td><button type="button" class="btn btn-primary" onclick="subir(<?php echo $dat[0] ?>)"><i class="bi bi-arrow-up-circle-fill"></i></button></td>
            </tr>

    <?php }
    endif; ?>
</table>

<style>
    td{
        padding-top: 0.2rem !important;
        padding-bottom: 0.2rem !important;
    }
</style>