<?php
session_start();
?>
<table class="table">
    <thead>
        <tr class="text-center">
            <th scope="col">Id</th>
            <th scope="col">Nombre Comprador</th>
        </tr>

    </thead>
    <?php
    if (isset($_SESSION['buscar_lista_de_compradores'])) :
        foreach (@$_SESSION['buscar_lista_de_compradores'] as $key) {
            $dat = explode("||", $key);
    ?>
            <tr>
                <td><?php echo $dat[0]; ?></td>
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