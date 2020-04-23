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

#Indicamos que el texto es en UTF-8
mysqli_set_charset($con, 'utf8');

#Comprobamos la operacion a realizar
switch ($operacion){
	case "AnadirImagen":
		$fecha = $_POST["fecha"];
		$titulo = $_POST["titulo"];
		$descrip = $_POST["descrip"];
		$imagen = $_POST["imagen"];

		# Ejecutar la sentencia SQL

		$sql = "INSERT INTO galeria (fecha,nombreU,titulo,descripcion,imagen) VALUES (?,?,?,?,?)";
		$stmt = mysqli_prepare($con,$sql);
		mysqli_stmt_bind_param($stmt,"sssss",$fecha,$usuario,$titulo,$descrip,$imagen);
		mysqli_stmt_execute($stmt);
		# Comprobar si se ha ejecutado correctamente
		if (mysqli_stmt_errno($stmt)!=0) {
			echo 'Error de sentencia: ' . mysqli_stmt_error($stmt);
		}else{
			echo 'True';
		}
		break;
		
	case "BorrarImagenes":
		$idBorrar = $_POST["idBorrar"];
		
		$correcto = True;
		
		foreach($idBorrar as $id){
			# Ejecutar la sentencia SQL
			$resultado = mysqli_query($con, "DELETE FROM galeria WHERE nombreU='$usuario' AND fecha='$id'");
			# Comprobar si se ha ejecutado correctamente
			if (!$resultado) {
				$resultado = 'Ha ocurrido algún error: ' . mysqli_error($con);
				$correcto = False;
				echo $resultado;
			}
			
		}
		
		if ($correcto) echo 'True';
		break;

	case "ModifImagen":
		$fecha = $_POST["fecha"];
		$titulo = $_POST["titulo"];
		$descrip = $_POST["descrip"];
		
		# Ejecutar la sentencia SQL
		$resultado = mysqli_query($con, "UPDATE galeria SET titulo='$titulo', descripcion='$descrip' WHERE nombreU='$usuario' AND fecha='$fecha'");
		# Comprobar si se ha ejecutado correctamente
		if (!$resultado) {
			$resultado = 'Ha ocurrido algún error: ' . mysqli_error($con);
			echo $resultado;
		}else{
			echo 'True';
		}
		break;
}




mysqli_close($connection); 

?>