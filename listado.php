<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <title> Listado de los productos de una familia </title>
  <link href="dwes.css" rel="stylesheet" type="text/css">
  
         
   <?php  ////************** Conexion DB ****************//
    require_once("configuracion.php"); // datos de configuracion de la conexion
            try { // conexion con la DB
               $base_datos_PDO = new PDO("mysql:host=$servidor;dbname=$base_datos", $usuario, $pass);
               echo " El usuario [".$usuario."] se a conectado a la base de datos [".$base_datos."] en el servidor [".$servidor."]";  
               if (isset($_POST["familias"]) ){ // Si me entran datos los muestro
                    echo '<p> *  Datos recibidos:  familias ['.$_POST["familias"] .']';
               }
            } catch (PDOException $e) { // tratamiento de errores
                echo "Imposible conectar con la base de datos";
                exit;
            }
        ?>
 <?php  //************** FUNCIONES ****************//
    /*
     * Muestra en un cuadro los tipos de familia que hay.
     */
 
    function getfamilias(&$conn) {
        try {
             $conn->beginTransaction(); 
             $sql = 'SELECT cod ,nombre FROM familia ORDER BY nombre';
            // print $row['cod'] . "\t";
             //print $row['nombre'] . "\n";
                echo " <select multiple name='familias'> " ;
                foreach ($conn->query($sql) as $row) {
                     //?????? DUDA como se muestra un desplegable sin mostrar la caja entera al principio.??????
                     echo '  <option value="'.utf8_encode($row["nombre"]).'">'.utf8_encode($row["nombre"]).'</option> ' ;
                 }     
                echo '   </select>';
                //$conn=null; // cierro la conesion DB
                
        } catch (PDOException $e) {// tratamiento de errores
               $conn->rollBack(); // deshacer 
               $conn = null; // cerrar conesion
               echo "Hubo algún error en la transacción " . $e->getMessage();
        }
        
        //?????? DUDA Porque si corto la conesion me da error.??????

                /*finally {  
                    $conn=null;// cierro la conesion DB
                }*/
              
    }
 
    /*
     * Muestro los productos pertenecientes a esa familia
     * 
     */    
    function getProductos(&$conn,$familia){ 
        try{
            echo  '$sql  = [ SELECT nombre_corto, PVP, cod FROM producto where familia= (SELECT cod FROM familia where nombre="'.$familia.'") ORDER BY nombre ; ]';
            //?????? DUDA Porque pegando la misma salida en el cmd-myslq funciona y ejecutandola por PDO las palabras con acentos no funcionan.??????
            $sql = 'SELECT cod, nombre_corto ,PVP FROM producto where familia=(SELECT cod FROM familia where nombre="'.$familia.'") ORDER BY nombre ;';
            echo ' <form id="form_seleccion" action= editar.php method="post"> ' ;
            foreach ($conn->query($sql) as $row) {
                echo "<p>" ;
                echo  $row['nombre_corto']." : ". $row['PVP']. " // " .$row['cod'] ;
                echo ' <input type="hidden" name="cod" value="'.$row['cod'].'"> '; 
                echo ' <input type="submit" value="Editar">';
               // echo "<\p>" ;

             } 
            
         
        } catch (PDOException $e) {// tratamiento de errores
               $conn->rollBack(); // deshacer 
               $conn = null; // cerrar conesion
               echo "Hubo algún error en la transacción " . $e->getMessage();
        } finally {
            $conn=null;// cierro la conesion DB
        }
    echo '</form>';
}
?>   
  
</head>

<body>
    

<div id="encabezado">
	<h1>Tarea : Listado de los productos de una familia </h1>
	<form id="form_seleccion" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
            Familias : 
                    <?php 
                            getfamilias($base_datos_PDO);
                     ?>
            <input type="submit"  value="Mostrar Productos" >
	</form>
        
        
</div>

<div id="contenido">
	<h2>Productos de la familia: </h2>
        
 <?php
        if (isset($_POST["familias"]) ){ // Si recibimos datos de un una familia muestra los productos de esta
                     getProductos($base_datos_PDO,$_POST["familias"]);
        }
     ?>  
        
</div>

<div id="pie">
</div>
</body>
</html>
