<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <title>Plantilla para Ejercicios Tema 3</title>
  <link href="dwes.css" rel="stylesheet" type="text/css">
  
 <?php
            require_once("configuracion.php");
            try {
               $base_datos_PDO = new PDO("mysql:host=$servidor;dbname=$base_datos", $usuario, $pass);
               echo " El usuario [".$usuario."] se a conectado a la base de datos [".$base_datos."] en el servidor [".$servidor."]";   
            } catch (PDOException $e) {
                echo "Imposible conectar con la base de datos";
                exit;
            }
        ?>


</head>

<body>

<div id="encabezado">
	<h1>Ejercicio: </h1>
	<form id="form_seleccion" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
	</form>
</div>

<div id="contenido">
	<h2>Contenido</h2>
</div>

<div id="pie">
</div>
</body>
</html>
