<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <title> Edición de un producto </title>
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
   <?php
    function getProductos($conn,$cod){ 

      echo  '$sql  = [ SELECT cod,nombre_corto, nombre,descripcion, PVP FROM producto where cod="'.$cod.'";';
      $sql = 'SELECT cod,nombre_corto, nombre,descripcion, PVP FROM producto where cod="'.$cod.'";';
      echo ' <form id="form_seleccion" action= actualizar.php method="post"> ' ;
      foreach ($conn->query($sql) as $row) {
           echo  $row['cod'];
           echo "<p> Nombre Corto: </p>" ;
           echo ' <input type="text" name="nombre_corto" maxlength="50">'
                      .  $row['nombre_corto']
                   . '</input><br> ';
           echo "<p> Nombre: </p>" ;
           echo ' <input type="text" name="nombre" maxlength="50">'
                      .  $row['nombre']
                   . '</input><br> ';        
           echo "<p> Descripcion: </p>" ;
           echo ' <input type="text" name="nombre" maxlength="50">'
                      .  $row['descripcion']
                   . '</input><br> ';  
           echo "<p> PVP: </p>" ;
           echo ' <input type="text" name="nombre" maxlength="50">'
                      .  $row['descripcion']
                   . '</input><br> '; 

           echo ' <input type="submit" value="Actualizar">';
           echo ' <input type="submit" value="Cancelar">';
          // echo "<\p>" ;
      }
      echo '</form>';
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
        <?php
    try {
            $base_datos_PDO->beginTransaction();
            
            $_POST["producto"]
            
            
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
