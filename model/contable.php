<?php
class contable
{

    public function consultar_reporte_de_ingresos_y_egresos()
    {
        unset($_SESSION['consultar_reporte_de_ingresos_y_egresos']);
        require_once "conexion.php";
        $conexion = conexion();
        $fechainicio = $_POST['form1'];
        $fechafin = $_POST['form2'];
        $sql = "SELECT cocina_cargas.fecha, cocina_cargas.hora, cocina_productos.nombre, cocina_compradores.descripcion, cocina_cargas.cantidad, cocina_cargas.valor, cocina_cargas.descripcion, cocina_cargas.id_tipo FROM cocina_cargas
        JOIN cocina_productos ON cocina_productos.id_producto = cocina_cargas.id_producto
        JOIN cocina_compradores ON cocina_compradores.id_comprador = cocina_cargas.id_comprador where cocina_cargas.fecha >= '$fechainicio' AND cocina_cargas.fecha <= '$fechafin' order by cocina_cargas.id_cargas desc";
        $result = mysqli_query($conexion, $sql);
        while ($ver1 = mysqli_fetch_row($result)) {
            $tabla = $ver1[0] . "||" . //
                $ver1[1] . "||" . //
                $ver1[2] . "||" . //
                $ver1[3] . "||" . //
                $ver1[4] . "||" . //
                $ver1[5] . "||" . //
                $ver1[6] . "||" . //
                $ver1[7] . "||"; //
            $_SESSION['consultar_reporte_de_ingresos_y_egresos'][] = $tabla;
        }
        if (isset($_SESSION['consultar_reporte_de_ingresos_y_egresos'])) {
            echo 1;
        } else {
            echo 2;
        }
    }

    public function buscar_lista_de_gastos_cocina()
    {
        unset($_SESSION['buscar_lista_de_gastos_cocina']);
        require_once "conexion.php";
        $conexion = conexion();
        $fechainicio = $_POST['form1'];
        $fechafin = $_POST['form2'];
        $sql = "SELECT cocina_cargas.fecha, cocina_cargas.hora, cocina_productos.nombre, cocina_compradores.descripcion, cocina_cargas.cantidad, cocina_cargas.valor, cocina_cargas.descripcion FROM cocina_cargas
        JOIN cocina_productos ON cocina_productos.id_producto = cocina_cargas.id_producto
        JOIN cocina_compradores ON cocina_compradores.id_comprador = cocina_cargas.id_comprador where cocina_cargas.id_tipo = 7 and cocina_cargas.fecha >= '$fechainicio' AND cocina_cargas.fecha <= '$fechafin' order by cocina_cargas.id_cargas desc";
        $result = mysqli_query($conexion, $sql);
        while ($ver1 = mysqli_fetch_row($result)) {
            $tabla = $ver1[0] . "||" . //
                $ver1[1] . "||" . //
                $ver1[2] . "||" . //
                $ver1[3] . "||" . //
                $ver1[4] . "||" . //
                $ver1[5] . "||" . //
                $ver1[6] . "||"; //
            $_SESSION['buscar_lista_de_gastos_cocina'][] = $tabla;
        }
        if (isset($_SESSION['buscar_lista_de_gastos_cocina'])) {
            echo 1;
        } else {
            echo 2;
        }
    }


    public function agregar_nuevo_gasto()
    {
        require_once "conexion.php";
        $conexion = conexion();
        $descripcion = $_POST['form1'];
        $valor = $_POST['form2'];
        $sql = "INSERT INTO cocina_cargas VALUES ('',curdate(),curtime(),7,1,1,'$descripcion','$valor',NULL)";
        $result = mysqli_query($conexion, $sql);
        if ($result) {
            echo 1;
        } else {
            echo 2;
        }
    }
    public function agregar_venta_cocina()
    {
        require_once "conexion.php";
        $conexion = conexion();
        $cantidad = $_POST['form1'];
        $valor = $_POST['form2'];
        $productos = $_POST['form3'];
        $compradores = $_POST['form4'];
        $sql = "INSERT INTO cocina_cargas VALUES ('',curdate(),curtime(),6,'$productos','$compradores',NULL,'$valor','$cantidad')";
        $result = mysqli_query($conexion, $sql);
        if ($result) {
            echo 1;
        } else {
            echo 2;
        }
    }

    public function buscar_lista_de_ingresos_cocina()
    {
        unset($_SESSION['buscar_lista_de_ingresos_cocina']);
        require_once "conexion.php";
        $conexion = conexion();
        $fechainicio = $_POST['form1'];
        $fechafin = $_POST['form2'];
        $sql = "SELECT cocina_cargas.fecha, cocina_cargas.hora, cocina_productos.nombre, cocina_compradores.descripcion, cocina_cargas.cantidad, cocina_cargas.valor FROM cocina_cargas
        JOIN cocina_productos ON cocina_productos.id_producto = cocina_cargas.id_producto
        JOIN cocina_compradores ON cocina_compradores.id_comprador = cocina_cargas.id_comprador where cocina_cargas.id_tipo = 6 and cocina_cargas.fecha >= '$fechainicio' AND cocina_cargas.fecha <= '$fechafin' order by cocina_cargas.id_cargas desc";
        $result = mysqli_query($conexion, $sql);
        while ($ver1 = mysqli_fetch_row($result)) {
            $tabla = $ver1[0] . "||" . //
                $ver1[1] . "||" . //
                $ver1[2] . "||" . //
                $ver1[3] . "||" . //
                $ver1[4] . "||" . //
                $ver1[5] . "||"; //
            $_SESSION['buscar_lista_de_ingresos_cocina'][] = $tabla;
        }
        if (isset($_SESSION['buscar_lista_de_ingresos_cocina'])) {
            echo 1;
        } else {
            echo 2;
        }
    }

    public function agregar_comprador()
    {
        require_once "conexion.php";
        $conexion = conexion();
        $descripcion = $_POST['form1'];
        $sql = "INSERT INTO cocina_compradores VALUES ('','$descripcion')";
        $result = mysqli_query($conexion, $sql);
        if ($result) {
            echo 1;
        } else {
            echo 2;
        }
    }

    public function buscar_lista_de_productos_cocina()
    {
        unset($_SESSION['buscar_lista_de_productos_cocina']);
        require_once "conexion.php";
        $conexion = conexion();
        $sql = "SELECT * FROM cocina_productos where estado = 1";
        $result = mysqli_query($conexion, $sql);
        while ($ver1 = mysqli_fetch_row($result)) {
            $tabla = $ver1[0] . "||" . //id
                $ver1[1] . "||"; //descripcion
            $_SESSION['buscar_lista_de_productos_cocina'][] = $tabla;
        }
        if (isset($_SESSION['buscar_lista_de_productos_cocina'])) {
            echo 1;
        } else {
            echo 2;
        }
    }

    public function buscar_lista_de_compradores()
    {
        unset($_SESSION['buscar_lista_de_compradores']);
        require_once "conexion.php";
        $conexion = conexion();
        $sql = "SELECT * FROM cocina_compradores where estado = 1";
        $result = mysqli_query($conexion, $sql);
        while ($ver1 = mysqli_fetch_row($result)) {
            $tabla = $ver1[0] . "||" . //id
                $ver1[1] . "||"; //descripcion
            $_SESSION['buscar_lista_de_compradores'][] = $tabla;
        }
        if (isset($_SESSION['buscar_lista_de_compradores'])) {
            echo 1;
        } else {
            echo 2;
        }
    }

    public function carga_masiva_de_valores_inventario()
    {
        require_once "conexion.php";
        $conexion = conexion();
        $id_producto = $_POST['form1'];
        $sql1 = "SELECT * FROM carga_de_inventario WHERE fecha = CURDATE() AND id_producto = '$id_producto' order by id_carga desc";
        $result = mysqli_query($conexion, $sql1);
        $ver = mysqli_fetch_row($result);
        $datos = array(
            "1" => $ver[4], //ingreso
            "2" => $ver[5], //perdida
            "3" => $ver[7], //restantes
        );
        return $datos;
    }

    public function valores_fiado_y_conteo_caja()
    {
        require_once "conexion.php";
        $conexion = conexion();

        $sql1 = "SELECT * FROM registro_diario WHERE fecha = CURDATE()";
        $result = mysqli_query($conexion, $sql1);
        $ver = mysqli_fetch_row($result);
        $datos = array(
            "1" => $ver[6], //caja
            "2" => $ver[8] //fiado
        );
        return $datos;
    }


    public function cargar_valores_moneda()
    {
        require_once "conexion.php";
        $conexion = conexion();

        $sql1 = "SELECT * FROM base_cartera WHERE fecha = CURDATE()";
        $result = mysqli_query($conexion, $sql1);
        $ver = mysqli_fetch_row($result);
        $datos = array(
            "1" => $ver[3], //moneda
            "2" => $ver[4] //billete
        );
        return $datos;
    }

    public function cargue_ingresos_egresos_reporte()
    {
        unset($_SESSION['cargue_ingresos_egresos_reporte']);
        require_once "conexion.php";
        $conexion = conexion();
        $inicio = $_POST['form1'];
        $fin = $_POST['form2'];
        $sql = "SELECT * FROM registro_diario WHERE fecha >= '$inicio' AND fecha <= '$fin'";
        $result = mysqli_query($conexion, $sql);
        while ($ver1 = mysqli_fetch_row($result)) {
            $tabla = $ver1[0] . "||" . //
                $ver1[1] . "||" . //
                $ver1[2] . "||" . //
                $ver1[3] . "||" . //
                $ver1[4] . "||" . //
                $ver1[5] . "||" . //
                $ver1[6] . "||" . //
                $ver1[7] . "||" . //
                $ver1[8] . "||"; //
            $_SESSION['cargue_ingresos_egresos_reporte'][] = $tabla;
        }
        if (isset($_SESSION['cargue_ingresos_egresos_reporte'])) {
            echo 1;
        } else {
            echo 2;
        }
    }

    public function cargar_tabla_temp_de_egresos_por_fecha()
    {
        $inicio = $_POST['form1'];
        $fin = $_POST['form2'];
        unset($_SESSION['cargar_tabla_temp_de_egresos_por_fecha']);
        require_once "conexion.php";
        $conexion = conexion();
        $sql = "SELECT * FROM egresos 
        JOIN estados ON estados.id_estado = egresos.estado
        JOIN tipos_productos ON tipos_productos.id_tipo = egresos.tipo
        WHERE fecha >= '$inicio' AND fecha <= '$fin'
        ORDER BY fecha, hora DESC";
        $result = mysqli_query($conexion, $sql);
        while ($ver1 = mysqli_fetch_row($result)) {
            $tabla = $ver1[0] . "||" . //
                $ver1[1] . "||" . //
                $ver1[2] . "||" . //
                $ver1[3] . "||" . //
                $ver1[4] . "||" . //
                $ver1[8] . "||" . //
                $ver1[10] . "||"; //
            $_SESSION['cargar_tabla_temp_de_egresos_por_fecha'][] = $tabla;
        }
        if (isset($_SESSION['cargar_tabla_temp_de_egresos_por_fecha'])) {
            echo 1;
        } else {
            echo 2;
        }
    }

    public function cargue_inventario_incontables()
    {
        unset($_SESSION['cargue_inventario_incontables']);
        require_once "conexion.php";
        $conexion = conexion();
        $sql = "SELECT carga_de_inventario.fecha, carga_de_inventario.hora, productos.nombre, productos.cantidadxpaquete, 
        carga_de_inventario.restante FROM carga_de_inventario
        JOIN productos ON productos.id_producto = carga_de_inventario.id_producto 
        WHERE pedidos = 0 AND acumulante IS NULL AND productos.estado =  1";
        $result = mysqli_query($conexion, $sql);
        while ($ver1 = mysqli_fetch_row($result)) {
            $tabla = $ver1[0] . "||" . // fecha
                $ver1[1] . "||" . //hora
                $ver1[2] . "||" . //nombre
                $ver1[3] . "||" . //cantidad x paquete
                $ver1[4] . "||"; // restante
            $_SESSION['cargue_inventario_incontables'][] = $tabla;
        }
        if (isset($_SESSION['cargue_inventario_incontables'])) {
            echo 1;
        } else {
            echo 2;
        }
    }


    public function obtener_datos_del_egreso()
    {
        require_once "conexion.php";
        $conexion = conexion();
        $id_engreso = $_POST['form1'];

        $sql1 = "SELECT * FROM egresos WHERE id_egreso = '$id_engreso'";
        $result = mysqli_query($conexion, $sql1);
        $ver = mysqli_fetch_row($result);
        $datos = array(
            "1" => $ver[0],
            "2" => $ver[3],
            "3" => $ver[4],
            "4" => $ver[5],
            "5" => $ver[6]
        );
        return $datos;
    }


    public function cargar_tabla_temp_de_egresos()
    {
        unset($_SESSION['cargar_tabla_temp_de_egresos']);
        require_once "conexion.php";
        $conexion = conexion();
        $sql = "SELECT * FROM egresos 
        JOIN estados ON estados.id_estado = egresos.estado
        JOIN tipos_productos ON tipos_productos.id_tipo = egresos.tipo
        order by fecha, hora desc LIMIT 100";
        $result = mysqli_query($conexion, $sql);
        while ($ver1 = mysqli_fetch_row($result)) {
            $tabla = $ver1[0] . "||" . //
                $ver1[1] . "||" . //
                $ver1[2] . "||" . //
                $ver1[3] . "||" . //
                $ver1[4] . "||" . //
                $ver1[8] . "||" . //
                $ver1[10] . "||"; //
            $_SESSION['cargar_tabla_temp_de_egresos'][] = $tabla;
        }
        echo 1;
    }

    public function procesoagregadoactualizado()
    {
        require_once "conexion.php";
        $conexion = conexion();
        $descripcion = $_POST['form1'];
        $valor = $_POST['form2'];
        $tipo = $_POST['form3'];
        $estado = $_POST['form4'];
        $id = $_POST['form5'];
        $opcion = $_POST['form6'];
        if ($opcion == 1) {
            $sql = "INSERT INTO egresos VALUES ('',curdate(),curtime(),'$descripcion','$valor','$estado','$tipo')";
            $result = mysqli_query($conexion, $sql);
            if ($result) {
                echo 1;
            } else {
                echo 2;
            }
        } else {
            $sql = "UPDATE egresos SET descripcion = '$descripcion', valor = '$valor', estado = '$estado', tipo = '$tipo' WHERE '$id' = id_egreso";
            $result = mysqli_query($conexion, $sql);
            if ($result) {
                echo 3;
            } else {
                echo 4;
            }
        }
    }

    public function agregar_producto()
    {
        require_once "conexion.php";
        $conexion = conexion();
        $nombre = $_POST['form1'];
        $cantidadxpaquete = $_POST['form2'];
        $preciounidadxventa = $_POST['form3'];
        $preciounidadporventa = $_POST['form4'];
        $estado = $_POST['form5'];
        $tipodeconteo = $_POST['form6'];
        $id = $_POST['form7'];
        $id_de_producto = $_POST['form8'];
        if ($id == 1) {
            $sql = "INSERT INTO productos VALUES ('','$nombre','$cantidadxpaquete','$preciounidadxventa','$estado','$preciounidadporventa','$tipodeconteo')";
            $result = mysqli_query($conexion, $sql);
            if ($result) {
                echo 1;
            } else {
                echo 2;
            }
        } else {
            $sql = "UPDATE productos SET nombre = '$nombre', cantidadxpaquete = '$cantidadxpaquete', valorxunidad = '$preciounidadxventa', estado = '$estado', precio_compra = '$preciounidadporventa', tipo = '$tipodeconteo' WHERE '$id_de_producto' = id_producto";
            $result = mysqli_query($conexion, $sql);
            if ($result) {
                echo 3;
            } else {
                echo 4;
            }
        }
    }


    public function buscar_un_solo_producto()
    {
        require_once "conexion.php";
        $conexion = conexion();
        $id_producto = $_POST['form1'];

        $sql1 = "SELECT * FROM productos WHERE id_producto = '$id_producto'";
        $result = mysqli_query($conexion, $sql1);
        $ver = mysqli_fetch_row($result);
        $datos = array(
            "1" => $ver[1],
            "2" => $ver[2],
            "3" => $ver[3],
            "4" => $ver[4],
            "5" => $ver[5],
            "6" => $ver[6]
        );
        return $datos;
    }

    public function buscar_productos()
    {
        unset($_SESSION['buscar_productos']);
        require_once "conexion.php";
        $conexion = conexion();
        $sql = "SELECT * FROM productos
        JOIN tipos_productos ON tipos_productos.id_tipo = productos.tipo order by id_producto desc";
        $result = mysqli_query($conexion, $sql);
        while ($ver1 = mysqli_fetch_row($result)) {
            $tabla = $ver1[0] . "||" . //id
                $ver1[1] . "||" . //nombre
                $ver1[2] . "||" . //canttidad x paquete
                $ver1[3] . "||" . //valor x unidad
                $ver1[4] . "||" . //estado
                $ver1[8] . "||"; //contable
            $_SESSION['buscar_productos'][] = $tabla;
        }
        echo 1;
    }

    public function proceso_matematico_de_registro_del_dia()
    {
        require_once "conexion.php";
        $conexion = conexion();
        $sql = "SELECT carga_de_inventario.pedidos, carga_de_inventario.perdidas, productos.nombre, productos.cantidadxpaquete, productos.valorxunidad, productos.precio_compra,
        productos.tipo, carga_de_inventario.acumulante, carga_de_inventario.bodega FROM carga_de_inventario 
        JOIN productos ON productos.id_producto = carga_de_inventario.id_producto 
        WHERE fecha = CURDATE() ORDER BY carga_de_inventario.id_producto, carga_de_inventario.id_carga";
        $result = mysqli_query($conexion, $sql);
        $ganancia_caja = 0;
        $perdidas = 0;
        $ganancia_real = 0;
        $suma_bodega_menos_restantes = 0;
        $tipo = 0;
        while ($ver1 = mysqli_fetch_row($result)) {
            if ($ver1[7] != null && $ver1[6] == 2) {
                $tipo = 2;/* se hacen operaciones */
            } else if ($ver1[7] == null && $ver1[6] == 2) {
                $tipo = 3;/* no se muesta nada */
            } else {
                $tipo = 1;/* operaciones normales */
            }
            $suma_bodega_menos_restantes = ($ver1[8] - $ver1[7]);

            if ($tipo == 2) { //ganancias para productos incontables
                $ganancia_caja = $ganancia_caja + (($suma_bodega_menos_restantes - $ver1[1]) * ($ver1[4]));
            } else if ($ver1[6] == 1) { //ganancias caja para productos contables
                $ganancia_caja = $ganancia_caja + (($ver1[0] - $ver1[1]) * ($ver1[4]));
            }

            if ($tipo == 2 || $tipo == 1) {
                $perdidas = $perdidas + ($ver1[1] * $ver1[4]);
            }

            if ($tipo == 2) {
                $ganancia_real = $ganancia_real + ((($suma_bodega_menos_restantes - $ver1[1]) * ($ver1[5])));
            } else if ($tipo == 1) {
                $ganancia_real = $ganancia_real + ((($ver1[0] - $ver1[1]) * ($ver1[5])));
            }
        }
        $resultado = array(
            "1" => $ganancia_caja,
            "2" => $perdidas,
            "3" => $ganancia_real
        );

        return $resultado;
    }


    public function cerrar_dia()
    {
        require_once "conexion.php";
        $conexion = conexion();
        $moneda = $_POST['form1'];
        $billete = $_POST['form2'];
        $total_caja = $_POST['form3'];
        $total_fiado = $_POST['form4'];
        //consultamos si ya se cargo la base del dia
        $result = self::consultar_datos_base_cartera(1);
        if (mysqli_num_rows($result) <= 0) { //no encontro la base del dia, la insertamos
            $sql = "INSERT INTO base_cartera VALUES ('',CURDATE(),CURTIME(),'$moneda','$billete')";
            $result = mysqli_query($conexion, $sql);
            if ($result) {
                $result = self::consultar_datos_base_cartera(2);
                $resultado = self::crear_registro_dia($result[0], $total_caja, $total_fiado);
            } else {
                echo 2;
            }
        } else { //la encontro, la actualizamos
            $ver = mysqli_fetch_row($result);
            $sql = "UPDATE base_cartera SET valor_moneda = '$moneda', valor_billete = '$billete' WHERE id_base = '$ver[0]' and fecha = CURDATE()";
            $result = mysqli_query($conexion, $sql);
            if ($result) {
                $resultado = self::crear_registro_dia($ver[0], $total_caja, $total_fiado);
            } else {
                echo 4;
            }
        }
    }

    public function crear_registro_dia($id_base_cartera, $total_caja, $total_fiado)
    {
        require_once "conexion.php";
        $conexion = conexion();
        //consultamos si hay registro de hoy
        $result = self::consultar_datos_registro_diario(1);
        if (mysqli_num_rows($result) <= 0) { //no encontro registro del dia, la insertamos
            $r1 = self::proceso_matematico_de_registro_del_dia();
            $sql = "INSERT INTO registro_diario VALUES ('',CURDATE(),CURTIME(),'$id_base_cartera','$r1[1]','$r1[2]','$total_caja','$r1[3]','$total_fiado')";
            $result = mysqli_query($conexion, $sql);
            if ($result) {
                echo 5;
            } else {
                echo 6;
            }
        } else { //encontramos el registro
            $result = self::consultar_datos_registro_diario(2);
            $r1 = self::proceso_matematico_de_registro_del_dia();
            $sql = "UPDATE registro_diario SET total_cartera = '$total_caja' , ganancias = '$r1[1]', perdidas = '$r1[2]', ganancia_real = '$r1[3]', total_fiado = '$total_fiado' WHERE $result[0] = id_registro and  fecha = CURDATE()";
            $result = mysqli_query($conexion, $sql);
            if ($result) {
                echo 7;
            } else {
                echo 8;
            }
        }
    }

    public function consultar_datos_registro_diario($opcion)
    {
        $conexion = conexion();
        $sql = "SELECT * FROM registro_diario WHERE fecha = CURDATE()";
        $result = mysqli_query($conexion, $sql);
        if ($opcion == 1) {
            return $result;
        } else if ($opcion == 2) {
            return $ver = mysqli_fetch_row($result);
        }
    }

    public function consultar_datos_base_cartera($opcion)
    {
        $conexion = conexion();
        $sql = "SELECT * FROM base_cartera WHERE fecha = CURDATE()";
        $result = mysqli_query($conexion, $sql);
        if ($opcion == 1) {
            return $result;
        } else if ($opcion == 2) {
            return $ver = mysqli_fetch_row($result);
        }
    }


    public function ver_dia_temp()
    {
        unset($_SESSION['ver_dia_temp']);
        require_once "conexion.php";
        $conexion = conexion();
        $sql = "SELECT carga_de_inventario.pedidos, carga_de_inventario.perdidas, productos.nombre, productos.cantidadxpaquete, productos.valorxunidad FROM carga_de_inventario
        JOIN productos ON productos.id_producto =  carga_de_inventario.id_producto WHERE fecha = CURDATE()";
        $result = mysqli_query($conexion, $sql);
        while ($ver1 = mysqli_fetch_row($result)) {
            $tabla = $ver1[0] . "||" . //pedidos
                $ver1[1] . "||" . //perdidas
                $ver1[2] . "||" . //nombre
                $ver1[3] . "||" . //cantidad x paquete
                $ver1[4] . "||"; //valor x unidad
            $_SESSION['ver_dia_temp'][] = $tabla;
        }
    }

    public function cargue_de_inventario_diario()
    {
        unset($_SESSION['tabla_cargue']);
        require_once "conexion.php";
        $conexion = conexion();
        $sql = "SELECT * FROM productos WHERE estado = 1";
        $result = mysqli_query($conexion, $sql);
        while ($ver1 = mysqli_fetch_row($result)) {
            $tabla = $ver1[0] . "||" . //id
                $ver1[1] . "||" . //nombre
                $ver1[3] . "||" . //valorxunidad
                $ver1[6] . "||"; //tipo
            $_SESSION['tabla_cargue'][] = $tabla;
        }
        echo 1;
    }

    public function listado_cargados_temp()
    {
        unset($_SESSION['listado_cargados_temp']);
        require_once "conexion.php";
        $conexion = conexion();
        $sql = "SELECT productos.nombre, productos.cantidadxpaquete FROM carga_de_inventario
        JOIN productos ON productos.id_producto =  carga_de_inventario.id_producto WHERE fecha = CURDATE()";
        $result = mysqli_query($conexion, $sql);
        while ($ver1 = mysqli_fetch_row($result)) {
            $tabla = $ver1[0] . "||" . //nombre
                $ver1[1] . "||"; //cantidad por paquete
            $_SESSION['listado_cargados_temp'][] = $tabla;
        }
        echo 1;
    }

    public function consultar_datos_de_producto($id_producto)
    {
        require_once "conexion.php";
        $conexion = conexion();
        $sql = "SELECT* FROM productos WHERE id_producto = '$id_producto'";
        $result = mysqli_query($conexion, $sql);
        return $ver1 = mysqli_fetch_row($result);
    }

    public function obtener_penultimo_registro($id_producto, $opcion)
    {
        require_once "conexion.php";
        $conexion = conexion();
        if ($opcion == 1) {
            $sql = "SELECT * FROM carga_de_inventario WHERE id_producto = '$id_producto' ORDER BY id_carga DESC LIMIT 1";
            $result = mysqli_query($conexion, $sql);
        } else if ($opcion == 2) {
            $sql = "SELECT * FROM carga_de_inventario WHERE id_producto = '$id_producto' ORDER BY id_carga DESC LIMIT 1 OFFSET 1";
            $result = mysqli_query($conexion, $sql);
        }
        return $ver1 = mysqli_fetch_row($result);
    }


    public function actualizacion_insertado_en_base_de_datos_inventario()
    {
        $ingreso = $_POST['form1'];
        $perdida = $_POST['form2'];
        $id_producto = $_POST['form3'];
        $restantes = $_POST['form4'];
        if ($restantes == '') {
            $restantes = 0;
        }
        if ($perdida == '') {
            $perdida = 0;
        }
        require_once "conexion.php";
        $conexion = conexion();
        //buscamos si el productos es contable o no
        $datos_producto = self::consultar_datos_de_producto($id_producto);
        //verificamos si ya hay registro hoy
        $sql = "SELECT * FROM carga_de_inventario WHERE id_producto = '$id_producto' and fecha = CURDATE()";
        $result = mysqli_query($conexion, $sql);
        if (mysqli_num_rows($result) <= 0) { //no encontro, realizar insertado
            if ($datos_producto[6] == 2) { //proceso para no cotables
                $penultimo_registro = self::obtener_penultimo_registro($id_producto, 1);
                if ($penultimo_registro != '') { //existe el penultimo registro
                    $sql = "UPDATE carga_de_inventario SET acumulante = '$restantes', hora = CURTIME() WHERE id_carga = '$penultimo_registro[0]'";
                    $result = mysqli_query($conexion, $sql);
                }
            }
            if ($datos_producto[6] == 2) { // es incontable
                $suma_ingreso_restantes = $ingreso + $restantes;
                $sql = "INSERT INTO carga_de_inventario VALUES ('',CURDATE(),CURTIME(),'$id_producto','$ingreso','$perdida','$restantes','$suma_ingreso_restantes',null)";
                $result = mysqli_query($conexion, $sql);
                if ($result) {
                    echo 1;
                } else {
                    echo 2;
                }
            } else { //es contable
                $suma_ingreso_restantes = $ingreso + $restantes;
                $sql = "INSERT INTO carga_de_inventario VALUES ('',CURDATE(),CURTIME(),'$id_producto','$ingreso','$perdida',null,null,null)";
                $result = mysqli_query($conexion, $sql);
                if ($result) {
                    echo 1;
                } else {
                    echo 2;
                }
            }
        } else { //eencontro actualizar por el id
            if ($datos_producto[6] == 2 && $ingreso == 0) { // se va a cerrar inventario
                $penultimo_registro = self::obtener_penultimo_registro($id_producto, 1);
                if ($penultimo_registro[4] == 0) { //si el ultimo registro tiene un cero en los pedidos, solo hacemos actualizacion
                    $penultimo_registro = self::obtener_penultimo_registro($id_producto, 2); //actualizamos valores del ultimo
                    $sql = "UPDATE carga_de_inventario SET acumulante = '$restantes' WHERE id_carga = '$penultimo_registro[0]'"; //actualizamos el acumulado del penultimo
                    $result = mysqli_query($conexion, $sql);

                    $suma_ingreso_restantes = $ingreso + $restantes;
                    $penultimo_registro = self::obtener_penultimo_registro($id_producto, 1); //actualizamos valores del ultimo
                    $sql = "UPDATE carga_de_inventario SET restante = '$restantes', hora = CURTIME(), bodega = '$suma_ingreso_restantes' WHERE id_carga = '$penultimo_registro[0]'";
                    $result = mysqli_query($conexion, $sql);
                    if ($result) {
                        echo 3;
                    } else {
                        echo 4;
                    }
                } else { // es un insertado normal
                    $penultimo_registro = self::obtener_penultimo_registro($id_producto, 1);
                    $sql = "UPDATE carga_de_inventario SET acumulante = '$restantes' WHERE id_carga = '$penultimo_registro[0]'"; //actualizamos el acumulado del penultimo
                    $result = mysqli_query($conexion, $sql);

                    $suma_ingreso_restantes = $ingreso + $restantes;
                    $sql = "INSERT INTO carga_de_inventario VALUES ('',CURDATE(),CURTIME(),'$id_producto',0,0,'$restantes','$suma_ingreso_restantes',null)";
                    $result = mysqli_query($conexion, $sql);
                    if ($result) {
                        echo 3;
                    } else {
                        echo 4;
                    }
                }
            } else { //ingreso normal, diferente de cierre de inventario
                $penultimo_registro = self::obtener_penultimo_registro($id_producto, 1);
                if ($datos_producto[6] == 2 && $penultimo_registro[4] == 0) {
                    return 5;
                }
                if ($datos_producto[6] == 2) { //es incontable
                    $suma_ingreso_restantes = $ingreso + $restantes;
                    $sql = "UPDATE carga_de_inventario SET pedidos = '$ingreso', perdidas = '$perdida', hora = CURTIME(), restante = '$restantes', bodega = '$suma_ingreso_restantes' WHERE id_producto = '$id_producto' and fecha = CURDATE()";
                    $result = mysqli_query($conexion, $sql);
                } else { //es contable
                    $sql = "UPDATE carga_de_inventario SET pedidos = '$ingreso', perdidas = '$perdida', hora = CURTIME() WHERE id_producto = '$id_producto' and fecha = CURDATE()";
                    $result = mysqli_query($conexion, $sql);
                }

                if ($result) {
                    if ($datos_producto[6] == 2) { //proceso para no cotables
                        $penultimo_registro = self::obtener_penultimo_registro($id_producto, 2);
                        //ya hay registros hoy
                        $sql = "UPDATE carga_de_inventario SET acumulante = '$restantes' WHERE id_carga = '$penultimo_registro[0]'";
                        $result = mysqli_query($conexion, $sql);
                    }
                    echo 3;
                } else {
                    echo 4;
                }
            }
        }
    }
}
