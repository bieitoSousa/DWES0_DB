<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <title> Edición de un producto </title>
  <link href="dwes.css" rel="stylesheet" type="text/css">
     <?php
            require_once("configuracion.php");
            echo "<p> Datos Inicio :";  
            try {
               $base_datos_PDO = new PDO("mysql:host=$servidor;dbname=$base_datos", $usuario, $pass);
               echo "<p> *  El usuario [".$usuario."] se a conectado a la base de datos [".$base_datos."] en el servidor [".$servidor."]";  
               echo '<p> *  Datos recibidos:  cod ['.$_POST["cod"] .']';
            } catch (PDOException $e) {
                echo "Imposible conectar con la base de datos";
                exit;
            }
        ?> 
   <?php
   /*
    * Con la conexion a la DB y el codigo del productos muestar los elementos de los  productos en una caja de texto 
    * permitiendo actualizar sus datos en la DB 
    */
        function getProductos(&$conn,$cod){ 
        try {
             $conn->beginTransaction();
                echo  '$sql  = [ SELECT cod,nombre_corto, nombre,descripcion, PVP FROM producto where cod="'.$cod.'";';
                $sql = 'SELECT cod,nombre_corto, nombre,descripcion, PVP FROM producto where cod="'.$cod.'";]';
                echo ' <form id="form_seleccion" action= actualizar.php method="post"> ' ;
                foreach ($conn->query($sql) as $row) {
                     echo ' <input type="hidden" name="cod" value="'.$row['cod'].'"> '; 
                     echo " Nombre Corto:" ;
                     echo ' <input type="text" size="60" maxlength="90" name="nombre_corto" value="'.$row['nombre_corto'].'" maxlength="50">'
                             . '</input> <br> ';
                     echo "<p> Nombre:</p> " ;
                     //?????? DUDA Porque no me muestra un text area y me muestar lo mismo que contype="txt" ??????
                     echo ' <input type="textarea" size="120" rows="30" cols="40" name="nombre" value="'.$row['nombre'].'"  >'
                             . '</input><br> ';  
                     //?????? DUDA Porque no me muestra un text area y me muestar lo mismo que contype="txt" ??????
                     echo "<p> Descripcion: </p>" ;
                     echo ' <input type="textarea"  size="120" rows="10" cols="40" name="descripcion" value="'.$row['descripcion'].'"  >'
                             . '</input><br> ';  
                     echo " PVP: " ;
                     echo ' <input type="text" size="15" maxlength="30" name="PVP"  value="'.$row['PVP'].'" maxlength="50">'
                             . '</input><br> '; 

                     echo ' <input type="submit" name="button" value="Actualizar">';
                     echo ' <input type="submit" name="button" value="Cancelar">';
                    // echo "<\p>" ;
                }
                echo '</form>';
             $conn->commit();
        } catch (PDOException $e) {
            $conn->rollBack();
            echo "Hubo algún error en la transacción " . $e->getMessage();
        } finally {
            $conn=null;
        }
        
    }     

     
?>  
  
</head>

<body>

<div id="encabezado">
	<h1> Edición de un producto: </h1>
	<form id="form_seleccion" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
	</form>
</div>

<div id="contenido">
	<h2>Producto</h2>
     <?php
            getProductos($base_datos_PDO,$_POST["cod"]);
     ?>  
        
</div>

<div id="pie">
</div>
</body>
</html>
