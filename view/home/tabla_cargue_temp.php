<?php
session_start();
?>
<!-- Definir la función antes del bucle -->
<script>
    function carga_masiva_de_valores_inventario(id_producto) {
        console.log("me ejecute con el codigo", id_producto);
        cadena = "form1=" + id_producto;
        $.ajax({
            type: "POST",
            url: "../../controller/carga_masiva_de_valores_inventario.php",
            data: cadena,
            success: function(r) {
                dato = jQuery.parseJSON(r);
                $('#ingreso' + id_producto).val(dato['1']);
                $('#perdida' + id_producto).val(dato['2']);
                if (dato['3'] !== null) {
                    $('#restantes' + id_producto).val(dato['3']);
                }
            }
        });
    }
</script>

<table class="table">
    <thead>
        <tr class="text-center">
            <th scope="col">Producto</th>
            <th scope="col">Precio U.</th>
            <th scope="col">Carga</th>
            <th scope="col">Ingreso</th>
            <th scope="col">Perdida</th>
            <th scope="col">Restantes</th>
        </tr>
    </thead>
    <?php
    if (isset($_SESSION['tabla_cargue'])) :
        foreach ($_SESSION['tabla_cargue'] as $key) :
            $dat = explode("||", $key);
            $id_producto = $dat[0];
    ?>
            <tr>
                <td><?php echo $dat[1] ?></td>
                <td><?php echo "$" . number_format($dat[2]); ?></td>
                <td class="text-center"><button type="button" class="btn btn-primary" onclick="subir(<?php echo $id_producto; ?>)"><i class="bi bi-arrow-up-circle-fill"></i></button></td>
                <td><input type="number" class="form-control form-control-sm" id="ingreso<?php echo $id_producto; ?>"></td>
                <td><input type="number" class="form-control form-control-sm" id="perdida<?php echo $id_producto; ?>"></td>
                <td><input <?php if ($dat[3] == 1) echo 'disabled'; ?> type="number" class="form-control form-control-sm" id="restantes<?php echo $id_producto; ?>"></td>
            </tr>
            <!-- Llama a la función para cargar valores inmediatamente después de crear la fila -->
            <script>
                carga_masiva_de_valores_inventario(<?php echo $id_producto; ?>);
            </script>
    <?php endforeach; ?>
    <?php endif; ?>
</table>

<style>
    td {
        padding-top: 0.2rem !important;
        padding-bottom: 0.2rem !important;
    }
</style>
<style>
    table {
        border-collapse: collapse;
        width: 100%;
    }

    th, td {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
    }

    th {
        background-color: #f2f2f2;
        position: sticky;
        top: 0;
        z-index: 2;
    }

    td {
        background-color: #ffffff;
    }
</style>

