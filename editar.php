<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <title> Edición de un producto </title>
  <link href="dwes.css" rel="stylesheet" type="text/css">
     <?php
        require_once("configuracion.php"); 
        ?> 
   <?php
   /*
    * Con la conexion a la DB y el codigo del productos muestar los elementos de los  productos en una caja de texto 
    * permitiendo actualizar sus datos en la DB 
    */
    function getProductos($cod){ 
          global $base_datos_PDO;
            if($base_datos_PDO == null){
                  openDB();
             }
              $conn=$base_datos_PDO;
        try {        
              //$conn->beginTransaction(); Inecesario : se trata de una única sentencia SQL o se ejecuta o no.
                //echo  '$sql  = [ SELECT cod,nombre_corto, nombre,descripcion, PVP FROM producto where cod="'.$cod.'";';
                $sql = 'SELECT cod,nombre_corto, nombre,descripcion, PVP FROM producto where cod="'.$cod.'";]';
                echo ' <form id="form_seleccion" action= actualizar.php method="post"> ' ;
                foreach ($conn->query($sql) as $row) {
                     echo ' <input type="hidden" name="cod" value="'.$row['cod'].'"> '; 
                     echo " Nombre Corto:" ;
                     echo ' <input type="text" size="60" maxlength="90" name="nombre_corto" value="'.$row['nombre_corto'].'" maxlength="50">'
                             . '</input> <br> ';
                     echo "<p> Nombre:</p> " ;
                     echo    '<textarea name="nombre"  size="120" rows="10" cols="60">'
                             .$row['nombre']
                             . '</textarea><br> '
                             ;  
                    
                     echo "<p> Descripcion: </p>" ;
                     echo ' <textarea  name="descripcion"  size="120" rows="10" cols="60"    >'
                                .$row['descripcion']
                                 . ' </textarea><br><br><br>'
                                 ;                      
                     echo " PVP: " ;
                     echo ' <input type="text" size="15" maxlength="30" name="PVP"  value="'.$row['PVP'].'" maxlength="50">'
                             . '</input><br><br> '; 

                     echo ' <input type="submit" name="button" value="Actualizar">';
                     echo ' <input type="submit" name="button" value="Cancelar">';
                    
                }
                echo '</form>';
            // $conn->commit(); Inecesario : se trata de una única sentencia SQL no es necesario actualizar
        } catch (PDOException $e) {
            $conn->rollBack();
            closeDB(); // cerrar conesion
           // $conn=null;
            echo "Hubo algún error en la transacción " . $e->getMessage();
        } finally {
            closeDB(); // cerrar conesion
           // $conn=null;
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
            getProductos($_POST["cod"]);
     ?>  
        
</div>

<div id="pie">
</div>
</body>
</html>
