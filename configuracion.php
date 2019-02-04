<?php
// $dwes = new PDO("mysql:host=localhost; dbname=dwes", "dwes", "abc123.");
// Datos de La conexion
$servidor  = 'localhost';
$base_datos  = 'dwes';
$usuario  = 'dwes';
$pass  = 'abc123.'; 
static $base_datos_PDO;

/*    ?? DUDA  Es recomendable [static $base_datos_PDO;]
              *    ?  Para hacer mas comodo no repetir la operacion de Conexion y ya que no vimos POO obte por variable statica pero : 
              *    ?  Hacer que un objeto, que se trasmite por referencia, sea una variable statica es conveniente ?
              *    ?  Si tenemos en cuenta que la consexion a la DB, deveria de ser una variable pribada    
              *    ?  y a la que no deberia de acceder desde fuera. La mejor alternativa es un objeto Conesion ??
              */


function openDB(){
    global $servidor,$base_datos,$usuario,$pass,$base_datos_PDO;
    try { // conexion con la DB
               $base_datos_PDO = new PDO("mysql:host=$servidor;dbname=$base_datos;charset=utf8", $usuario, $pass);
               //echo " El usuario [".$usuario."] se a conectado a la base de datos [".$base_datos."] en el servidor [".$servidor."]";  
               
   } catch (PDOException $e) { // tratamiento de errores
                echo "Imposible conectar con la base de datos".$e;
                exit;
    }
}
function closeDB(){
    global $base_datos_PDO;
    try { // conexion con la DB
        if(is_a($base_datos_PDO, 'PDO')){ // es un objeto de clase PDO
            $base_datos_PDO = null;
        }else{
            throw new Exception('es necesario una parametro de clase PDO');
        }
    }catch (Exception $p){
        echo $p;
    }
}