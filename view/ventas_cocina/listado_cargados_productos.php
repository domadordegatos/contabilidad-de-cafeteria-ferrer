<?php
session_start();
    ?>
    <option selected value="A">Productos...</option>
    <?php
    if (isset($_SESSION['buscar_lista_de_productos_cocina'])) :
        foreach (@$_SESSION['buscar_lista_de_productos_cocina'] as $key) {
            $dat = explode("||", $key);
    ?>
            <option value="<?php echo $dat[0]; ?>"><?php echo $dat[1]; ?> </option>

    <?php }
    endif; ?>