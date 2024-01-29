<?php
// archivo de pruebas
require_once "core/conexionDB.php";

$conexion = new ConexionDB();
$data = $conexion->getData("SELECT * FROM user");
echo $data[0]['name'];
?>