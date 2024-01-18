<?php
session_start();

    if (isset($_SESSION['listado_cargados_temp'])) :
        foreach (@$_SESSION['listado_cargados_temp'] as $key) {
            $dat = explode("||", $key);
    ?>
            <span><?php echo "(".$dat[0]."x".$dat[1].")"; ?> - </span>

    <?php }
    endif; ?>