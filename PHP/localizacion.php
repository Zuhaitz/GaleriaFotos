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

$operacion = $_POST["operacion"];
$usuario = $_POST["usuario"];
$fecha = $_POST["fecha"];
$lat = $_POST["latitud"];
$long = $_POST["longitud"];

# Ejecutar la sentencia SQL
mysqli_set_charset($con, 'utf8');
if(strcmp($operacion, "GetLocal") == 0){
	$resultado = mysqli_query($con, "SELECT latitud, longitud FROM galeria WHERE nombreU='$usuario' AND fecha='$fecha'");
}else if(strcmp($operacion, "ModifLocal") == 0){
	$resultado = mysqli_query($con, "UPDATE galeria SET latitud=$lat, longitud=$long WHERE nombreU='$usuario' AND fecha='$fecha'");
}
# Comprobar si se ha ejecutado correctamente
if (!$resultado) {
	echo 'Ha ocurrido algún error: ' . mysqli_error($con);
}
if(strcmp($operacion, "GetLocal") == 0){
	#Comprobar el numero de filas
	$row_cnt = $resultado->num_rows;
	$fila = mysqli_fetch_row($resultado);
	if ($row_cnt == 1){
		# Generar el array con los resultados con la forma Atributo - Valor
		$arrayresultados = array(
		'latitud' => $fila[0],
		'longitud' => $fila[1]
		);
		
		echo json_encode($arrayresultados);
		
	}else{
		echo "False";
	}
}else if(strcmp($operacion, "ModifLocal") == 0){
	if ($resultado == 1){
		echo "True";
	}else {
		echo "False";
	}
}

mysqli_close($connection); 

?>