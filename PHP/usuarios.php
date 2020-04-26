<?php

$DB_SERVER="localhost"; #la dirección del servidor
$DB_USER="Xzmartinez015"; #el usuario para esa base de datos
$DB_PASS="?????"; #la clave para ese usuario
$DB_DATABASE="Xzmartinez015_galeria"; #la base de datos a la que hay que conectarse

# Se establece la conexión:
$con = mysqli_connect($DB_SERVER, $DB_USER, $DB_PASS, $DB_DATABASE);

#Comprobamos conexión
if (mysqli_connect_errno($con)) {
echo 'Error de conexion: ' . mysqli_connect_error();
exit();
}

$operacion = $_POST["operacion"];
$nombre = $_POST["nombre"];
$contra = $_POST["contra"];
$token = $_POST["token"];

# Ejecutar la sentencia SQL
mysqli_set_charset($con, 'utf8');
if(strcmp($operacion, "InicioSesion") == 0){
	$resultado = mysqli_query($con, "SELECT * FROM usuarios WHERE nombre = '$nombre' AND contra = '$contra'");
}else if(strcmp($operacion, "Registro") == 0){
	$resultado = mysqli_query($con, "INSERT INTO usuarios(nombre, contra, token) VALUES ('$nombre', '$contra', '$token')");
}
# Comprobar si se ha ejecutado correctamente
if (!$resultado) {
	echo 'Ha ocurrido algún error: ' . mysqli_error($con);
}
if(strcmp($operacion, "InicioSesion") == 0){
	#Comprobar el numero de filas
	$row_cnt = $resultado->num_rows;
	$fila = mysqli_fetch_row($resultado);
	if ($row_cnt == 1){
		$t = $fila[2];
		
		if(strcmp($t, $token) == 0){
			echo "True";
		}else{
			$resultado = mysqli_query($con, "UPDATE usuarios SET token='$token' WHERE nombre='$nombre'");
			if($resultado == 1) {
				echo "True";
			}else {
				echo "False";
			}
		}
		
	}else{
		echo "False";
	}
}else if(strcmp($operacion, "Registro") == 0){
	if ($resultado == 1){
		echo "True";
	}
}

mysqli_close($connection); 

?>