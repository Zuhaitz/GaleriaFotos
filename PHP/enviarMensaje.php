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

#TODO: sa car los token de la base de datos
$usuario = $_POST["usuario"];
$tokenUsu = $_POST["token"];
$arraytokens = array();

# Ejecutar la sentencia SQL
mysqli_set_charset($con, 'utf8');
$resultado = mysqli_query($con, "SELECT token FROM usuarios WHERE NOT nombre = '$usuario' AND NOT token = '$tokenUsu' AND token IS NOT NULL");

# Comprobar si se ha ejecutado correctamente
if (!$resultado) {
	echo 'Ha ocurrido algún error: ' . mysqli_error($con);
}else{
	while ($fila = $resultado->fetch_array()) {
		$arraytokens[] = $fila[0];
	}
	
	print_r($arraytokens);


	#Preparamos el mensaje para enviar
	$cabecera= array(
	'Authorization: key=AAAA3p2k6rM:APA91bG23wKU0QdJPlT9Pmc974QdlsUhnEHpuHYhptSC4PU5XdxynMWhzvDKBztvlm6uUKwkngUh_wUZW76sNAOzSfjwFTAksOU1m_XkNLVkj9kZNLy0W_c5Ae1asYvtVXuvitFFJMCM',
	'Content-Type: application/json'
	);

	$msg= array(
			'registration_ids'=> $arraytokens,
			'notification' => array(
				'body' => $usuario . ' a subido una nueva imagen!',
				'title' => $usuario . ' a actualizado su galeria',
				'icon' => 'ic_stat_ic_notification'
			)
	);
	
	$msgJSON= json_encode ( $msg);

	$ch = curl_init(); #inicializar el handler de curl
	#indicar el destino de la petición, el servicio FCM de google
	curl_setopt( $ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
	#indicar que la conexión es de tipo POST
	curl_setopt( $ch, CURLOPT_POST, true );
	#agregar las cabeceras
	curl_setopt( $ch, CURLOPT_HTTPHEADER, $cabecera);
	#Indicar que se desea recibir la respuesta a la conexión en forma de string
	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
	#agregar los datos de la petición en formato JSON
	curl_setopt( $ch, CURLOPT_POSTFIELDS, $msgJSON );
	#ejecutar la llamada
	$resultado= curl_exec( $ch );

	#Comprobamos si ha ocurrido algun error
	if (curl_errno($ch)) {
	print curl_error($ch);
	}
	echo $resultado;

	#cerrar el handler
	curl_close( $ch );
}

mysqli_close($connection);

?>