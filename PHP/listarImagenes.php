<?php

$DB_SERVER="localhost"; #la dirección del servidor
$DB_USER="Xzmartinez015"; #el usuario para esa base de datos
$DB_PASS="i5QU8iYFP"; #la clave para ese usuario
$DB_DATABASE="Xzmartinez015_galeria"; #la base de datos a la que hay que conectarse

# Se establece la conexión:
$con = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_DATABASE);

#Comprobamos conexión
if (mysqli_connect_errno($con)) {
echo 'Error de conexion: ' . mysqli_connect_error();
exit();
}

$usuario = $_POST["usuario"];

# Ejecutar la sentencia SQL
mysqli_set_charset($con, 'utf8');
$resultado = mysqli_query($con, "SELECT * FROM galeria WHERE nombreU = '$usuario'");
# Comprobar si se ha ejecutado correctamente
if (!$resultado) {
echo 'Ha ocurrido algún error: ' . mysqli_error($con);
}else{

$arrayresultados = array();

#Acceder al resultado
while ($fila = $resultado->fetch_array()) {
# Generar el array con los resultados con la forma Atributo - Valor
	$arrayresultados[] = array(
	'fecha' => $fila[0],
	'titulo' => $fila[2],
	'descripcion' => $fila[3],
	'img' => $fila[4]
	); 

}

#Devolver el resultado en formato JSON
echo json_encode($arrayresultados);
}

?>