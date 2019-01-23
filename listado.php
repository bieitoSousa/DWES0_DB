<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <title> Listado de los productos de una familia </title>
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
  function getfamilias($conn) {
    $sql = 'SELECT cod ,nombre FROM familia ORDER BY nombre';
    
       // print $row['cod'] . "\t";
        //print $row['nombre'] . "\n";
        echo " <select multiple name='familias'> " ;
             foreach ($conn->query($sql) as $row) {
              echo '  <option value="'.$row["nombre"].'">'.$row["nombre"].'</option> ' ;//
               }     
         echo '   </select>';
}
 
function getProductos($conn,$familia){ 
    $sql = 'SELECT nombre_corto ,PVP FROM producto where familia='.$familia.' ORDER BY nombre';
    echo ' <form id="form_seleccion" action='. $_SERVER['PHP_SELF'].' method="post"> ' ;
    foreach ($conn->query($sql) as $row) {
         echo  $row['nombre_corto']." : ". $row['PVP']. " "  ;
         echo ' <input type="submit" value="Editar" > ';
         echo "\n" ;
    }
    echo '</form>'."\n";
}
?>   
  
</head>

<body>
    

<div id="encabezado">
	<h1>Tarea : Listado de los productos de una familia </h1>
	<form id="form_seleccion" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
            Familias : 
                    <?php 
                        try {
                            $base_datos_PDO->beginTransaction();
                            getfamilias($base_datos_PDO);
                            $base_datos_PDO->commit();
                        } catch (PDOException $e) {
                        $base_datos_PDO->rollBack();
                        echo "Hubo algún error en la transacción " . $e->getMessage();
                        }
          
                        ?>
            <input type="submit" value="Mostrar Productos" >
	</form>
        
        
</div>

<div id="contenido">
	<h2>Contenido</h2>
        
        <?php
        $familia = $_POST["familias"];
        echo $familia;
        if (isset($_POST["submit"]) ){
             echo "se ha presionado submit";
        }
        
        /*
         
         
        if (true){
             try {
                            $base_datos_PDO->beginTransaction();
                            getProductos($base_datos_PDO,$selectFamilia);
                            $base_datos_PDO->commit();
                        } catch (PDOException $e) {
                        $base_datos_PDO->rollBack();
                        echo "Hubo algún error en la transacción " . $e->getMessage();
                        }
            
        }       
    /*try {
            $base_datos_PDO->beginTransaction();
            getfamilias($base_datos_PDO);
            
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
            }*/
     ?>  
        
</div>

<div id="pie">
</div>
</body>
</html>
