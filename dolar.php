#!/usr/bin/php -q
<?php
//
// Script que obtiene el valor del dolar en pesos chilenos segun el Banco Central de Chile
//
// 2014-03-12 jzorrilla@x-red.com - Creo la version inicial basado en un scritp de Henry Lopez
// 2017-10-23 jzorrilla@x-red.com - Actualizo el script para que utilice webservices desde mindicador.cl
// 2019-12-22 jzorrilla@x-red.com - Modifico el script para obtener el valor del dolar

// Valida el numero de argumentos
if ($argc ==  2 and $argv[1] == "--h") {
	exit( "Uso: php $argv[0] [fecha inicio en formato dd-mm-yyyy]\n     Sin el parametro fecha asume la fecha actual.\n" );
}

// Valida que exista archivo de configuracion
if (file_exists(dirname(__FILE__) . "/config.php")) {
	include(dirname(__FILE__) . "/config.php");
} else {
	echo "Error: Archivo de configuracion " . dirname(__FILE__) . "/config.php no existe\n";
	exit;
}

// Si existe archivo de configuracion local lo incluye, este archivo esta en .gitignore
// Este archivo sobre escribe las variables de config.php
if (file_exists(dirname(__FILE__) . "/config_local.php")) {
        include(dirname(__FILE__) . "/config_local.php");
}

// Define el timezone
date_default_timezone_set('America/Santiago');

// Conexion a la base de datos
$con = mysqli_connect($DB_SERVIDOR,$DB_USUARIO,$DB_CLAVE) or die("Imposible conectarse al servidor.");
mysqli_select_db($con, $DB_BASE) or die("Imposible abrir Base de datos");

if ($argc < 2) {
	$fecha = date_create(date('Y-m-d'));
} else {
	$fecha = date_create($argv[1]);
}

$fin = 0;

while (!$fin) {
	$jsonsource = $URL . date_format($fecha,'d-m-Y');
	if ($source = file_get_contents($jsonsource)) {
		echo "Obtiene los datos desde $jsonsource\n";
		$json = json_decode($source);
		if (sizeof($json->serie)!=0) {
				$sql = "insert ignore into dolar (dolar_fecha,dolar_valor,dolar_fechaact) values ('" .
					date_format($fecha,'Y-m-d') . "'," . $json->serie[0]->valor .",now())";
				mysqli_query($con, $sql);
		}
		else
			$fin =1;
		date_add($fecha, date_interval_create_from_date_string('1 days'));

	}
	else {
		echo "\nError: No se puede ebtener los datos desde el webservice\n";
		exit;
	}
}
?>
