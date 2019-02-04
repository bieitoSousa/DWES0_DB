<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
  <?php  

/*  Resumen Estructura Conesion MYSQL (PDO):
 * ----------------------------------------
 * Iniciar Objeto PDO
 * --------------------
 * Try { // conexion con la DB , charset=utf8 utilizar en la DB caraceteres : como acentos, Ñ
 *              $base_datos_PDO = new PDO("mysql:host=$servidor;dbname=$base_datos;charset=utf8", $usuario, $pass);
 *               // Ejemplo de comprobacion conesion
 *              echo " El usuario [".$usuario."] se a conectado a la base de datos [".$base_datos."] en el servidor [".$servidor."]";  
 *            
 *  } catch (PDOException $e) { // tratamiento de errores
 *  echo "Imposible conectar con la base de datos";
 *  exit;
 *  }
 * 
 * Operaciones con el Objeto PDO (conn en este caso )
 * --------------------------------------------------
 * try{
 *      $conn->beginTransaction(); Inecesario : si se trata de una única sentencia SQL o se ejecuta o no.
 *      $sql = 'SELECT cod ,nombre FROM familia ORDER BY nombre'; // consulta
 *          foreach ($conn->query($sql) as $row) { // recorrer los resultado de la consultaMysql
 *              print $row['cod'] . "\t"; // mostrar resultado de la columna cod
 *              echo $row['nombre']; // mostrar resultado de la columna cod
 *              }// resto de operaciones
 *      // $conn->commit(); Inecesario : Si se trata de una única sentencia SQL no es necesario actualizar
 *  } catch (PDOException $e) {// tratamiento de errores
 *             $conn->rollBack(); // deshacer cambios
 *             $conn = null; // cerrar conesion si es necesario mejor con funcion
 *             echo "Hubo algún error en la transacción " . $e->getMessage(); // mostrar informacion
 *  } finally {// si es necesario despues de las operaciones cierro la DB
 *         $conn=null;
 *  }
 * 
 */
  ?>  
    
    
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <title> Listado de los productos de una familia </title>
  <link href="dwes.css" rel="stylesheet" type="text/css">
  
         
   <?php  //************** Conexion DB ****************//
    require_once("configuracion.php"); // datos de configuracion de la conexion
    
        ?>
 <?php  //************** FUNCIONES ****************//
   
       function getfamilias() {
            
             global $base_datos_PDO;
              /*    ?? DUDA en [$base_datos_PDO] seria recomendable el uso del global al ser una variable estatica ??????
               *    ?? DUDA en [$base_datos_PDO] hay alguna diferencia entre global y coger la variable por referencia  ??????
               *    ?  ejemplo : function getfamilias($base_datos_PDO;)
               */
             if($base_datos_PDO == null){
                  openDB();
             }
             $conn=$base_datos_PDO;
             /*    ?? DUDA  Tiene sentido [$conn=$base_datos_PDO;] 
              *    ?     me suena que por seguridad se deve de copiar un objeto,
              *    ?     pero en este caso pasaria la referencia creo que si  modifico el $conn
              *    ?     en consecuencia modificaria $conn  
              */
         try {    
            $sql = 'SELECT cod ,nombre FROM familia ORDER BY nombre';

                echo " <select name='familias'> " ;
                foreach ($conn->query($sql) as $row) {
                     echo '  <option value="'.$row["cod"].'">'.$row["nombre"].'</option> ' ;
                 }     
                echo '   </select>';
                 
                //$conn=null; // cierro la conesion DB
                
        } catch (PDOException $e) {// tratamiento de errores
               $conn->rollBack(); // deshacer 
               closeDB();// cerrar conesion
               //$conn =null;
               echo "Hubo algún error en la transacción " . $e->getMessage();
        } 
    }
 
    /*
     * Muestro los productos pertenecientes a esa familia
     * 
     */    
    function getProductos($familia){ 
          
            global $base_datos_PDO;
            if($base_datos_PDO == null){
                  openDB();
             } 
            $conn=$base_datos_PDO;
        try{
            //echo  '$sql  = [ SELECT cod, nombre_corto ,PVP FROM producto where familia="'.$familia.'" ORDER BY nombre ; ]';
            $sql = 'SELECT cod, nombre_corto ,PVP FROM producto where familia="'.$familia.'" ORDER BY nombre ;';
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
               closeDB(); // cerrar conesion
         /*??????   DUDA [$conn =null;] tanto en el catch como en el finally tendria alguna utilidad ??????
         *      ?    al final de la funcion se pierde la informacion de la variable
         * 
         */
               // $conn =null;
               echo "Hubo algún error en la transacción " . $e->getMessage();
        } finally {
            closeDB();// cierro la conesion DB
            //$conn=null;
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
                            getfamilias();
                     ?>
            <input type="submit"  value="Mostrar Productos" >
	</form>
        
        
</div>

<div id="contenido">
	<h2>Productos de la familia: </h2>
        
 <?php
        if (isset($_POST["familias"]) ){ // Si recibimos datos de un una familia muestra los productos de esta
                     getProductos($_POST["familias"]);
        }
     ?>  
        
</div>

<div id="pie">
</div>
</body>
</html>
