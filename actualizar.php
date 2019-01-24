

<?php
            require_once("configuracion.php");
            echo "<p> Datos Inicio :";  
            try {
               $base_datos_PDO = new PDO("mysql:host=$servidor;dbname=$base_datos", $usuario, $pass);
               echo "<p> *  El usuario [".$usuario."] se a conectado a la base de datos [".$base_datos."] en el servidor [".$servidor."]";  
               echo '<p> *  Datos recibidos: '.'<br>'
               . ' --------------------------------------------------'.'<br>'
               . ' Button : ['.$_POST["button"] .']'.'<br>'
               . ' Codigo : ['.$_POST["cod"] .']'.'<br>'
               . ' Nombre_corto : ['.$_POST["nombre_corto"] .']' .'<br>'
               . ' Nombre : ['.$_POST["nombre"] .']' .'<br>'
               . ' Descripcion : ['.$_POST["descripcion"] .']'.'<br>'
               . ' PVP :   ['.$_POST["PVP"] .']'.'<br>'
                . ' --------------------------------------------------' .'<br>'       
               ;
            } catch (PDOException $e) {
                echo "Imposible conectar con la base de datos";
                exit;
            }
        ?> 
<?php
function actualizaProducto(&$conn,$cod,$nom_cor,$nom,$desc,$pvp){ 
    try{
        $conn->beginTransaction();
           
            // update nombre_corto
             $sql ='update producto set nombre_corto = "'.$nom_cor.'" where cod ="'.$cod.'";'; 
                 $sentencia = $conn->prepare($sql);
                 $sentencia->execute();
             // update nombre
            $sql ='update producto set nombre = "'.$nom.'" where cod ="'.$cod.'";';
                $sentencia = $conn->prepare($sql);
               // $sentencia->bindValue(":id", 1);
                $sentencia->execute();    
            // update descripcion    
            $sql ='update producto set descripcion = "'.$desc.'" where cod ="'.$cod.'";'; 
                 $sentencia = $conn->prepare($sql);
                 $sentencia->execute();
            // update PVP     
            $sql ='update producto set PVP = "'.$pvp.'" where cod ="'.$cod.'";'; 
                 $sentencia = $conn->prepare($sql);
                 $sentencia->execute();
         $conn->commit();  
    } catch (PDOException $e) {
            $conn->rollBack();
            echo "Hubo algún error en la transacción " . $e->getMessage();
            $conn=null;
    }
 }
?>


  <?php
  switch ($_POST["button"]) {
    case "Actualizar":
        actualizaProducto(
                $base_datos_PDO
                , $_POST["cod"]
                , $_POST["nombre_corto"]
                , $_POST["nombre"]
                , $_POST["descripcion"]
                , $_POST["PVP"]); 
        
       // echo ' se han actualizado Productos , redirigido a pagina principal'; 
        break;
    case "Cancelar":
       // echo ' Redirigido a pagina principal';
        break;
    //default :
}
    //?????? DUDA Porque no me funciona : 
    //echo '<meta http-equiv="refresh" content="1"; url= "listado.php">'
    //?????? hay diferencia entre hacerlo con header ????
   header('Location: listado.php');
  
  ?> 