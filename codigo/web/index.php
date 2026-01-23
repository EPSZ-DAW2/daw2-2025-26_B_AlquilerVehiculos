<?php
try {
		$conexion = new mysqli('localhost', 'root', '');
} catch (Exception $e) {
		die("<h3>Error:</h3> No puedo conectar con XAMPP. Asegúrate de que MySQL está en Start (Verde).");
}

try {
		$existeBD = $conexion->select_db('gestion_alquiler');
} catch (Exception $e) {
		$existeBD = false;
}

if (!$existeBD) {
		$archivoSQL = realpath(__DIR__ . '/../../sql/vehiculos.sql');
		$mysqlExe = 'C:\\xampp\\mysql\\bin\\mysql.exe';

		if ($archivoSQL && file_exists($archivoSQL) && file_exists($mysqlExe)) {
				$comando = "\"$mysqlExe\" -u root < \"$archivoSQL\"";
				shell_exec($comando);
				
				$conexion->close();

				header("Refresh:0");
				exit("<h1>⚙️ Instalando Sistema...</h1>");
		} else {
			die("<h3>Error de Instalación:</h3> No encuentro el archivo SQL en: <br>");
		}
}

$conexion->close();

//EPSZ-DAW2: Adaptación para cargar "vendor" en una ubicación compartida.

// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

$base= dirname( dirname( __DIR__)).'/librerias';
$requires= [ 
		[ $base, 'vendor', 'autoload.php']
	, [ $base, 'vendor', 'yiisoft', 'yii2', 'Yii.php']
];
foreach( $requires as $path) {
	$path= implode( DIRECTORY_SEPARATOR, $path);
	//print_r($path); echo '<br>';
	require $path;
}

$config = require dirname( __DIR__) . '/config/web.php';
//--echo '<pre>'; print_r( $config); echo '</pre>'; die();

(new yii\web\Application($config))->run();

