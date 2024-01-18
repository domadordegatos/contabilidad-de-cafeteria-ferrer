<?php
session_start();
    ?>
    <option selected value="A">Productos...</option>
    <?php
    if (isset($_SESSION['buscar_productos'])) :
        foreach (@$_SESSION['buscar_productos'] as $key) {
            $dat = explode("||", $key);
    ?>
            <option value="<?php echo $dat[0]; ?>"><?php echo $dat[0]." - ".$dat[1]."x".$dat[2]." - $".$dat[3]. " - ".$dat[5]. " - "; if($dat[4] == 1){ echo "ACTIVO";}else{ echo "INACTIVO";}; ?> </option>

    <?php }
    endif; ?>