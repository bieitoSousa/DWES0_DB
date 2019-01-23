<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <title> Edición de un producto </title>
  <link href="dwes.css" rel="stylesheet" type="text/css">
    <?php
            require_once("index.php");// recuperamos la conesion DB $base_datos_PDO
            require_once("listado.php");// recuperamos los datos del listado
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
        <?php
    try {
            $base_datos_PDO->beginTransaction();
                $sql = "update usuarios set cuenta = 0 where id = :id";
                $sentencia = $base_datos_PDO->prepare($sql);
                $sentencia->bindValue(":id", 1);
                $sentencia->execute();
                $sentencia->bindValue(":id", 2);
                $sentencia->execute();
                $sentencia->bindValue(":id", 3);
                $sentencia->execute();
            $base_datos_PDO->commit();
            } catch (PDOException $e) {
            $base_datos_PDO->rollBack();
            echo "Hubo algún error en la transacción " . $e->getMessage();
            }
     ?>  
        
</div>

<div id="pie">
</div>
</body>
</html>
