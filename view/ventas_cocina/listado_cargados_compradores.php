<?php
session_start();
    ?>
    <option selected value="A">Compradores...</option>
    <?php
    if (isset($_SESSION['buscar_lista_de_compradores'])) :
        foreach (@$_SESSION['buscar_lista_de_compradores'] as $key) {
            $dat = explode("||", $key);
    ?>
            <option value="<?php echo $dat[0]; ?>"><?php echo $dat[1]; ?> </option>

    <?php }
    endif; ?>