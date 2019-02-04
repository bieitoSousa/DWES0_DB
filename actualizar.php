

<?php
            require_once("configuracion.php");
        ?> 
<?php
function actualizaProducto($cod,$nom_cor,$nom,$desc,$pvp){ 

        global $base_datos_PDO;
            if($base_datos_PDO == null){
                  openDB();
             } 
            $conn=$base_datos_PDO;
     try{        
            //$conn->beginTransaction();  Inecesaria : se trata de una única sentencia SQL o se ejecuta o no.
            // update nombre_corto,nombre,descripcion,PVP
            $sql ='update producto set'
                            . ' nombre_corto = "'.$nom_cor.'" '
                            . ', nombre = "'.$nom.'"'
                            . ', descripcion = "'.$desc.'"'
                            . ', PVP = "'.$pvp.'"'
                     . 'where cod ="'.$cod.'";'; 
                 $sentencia = $conn->prepare($sql);
                 $sentencia->execute();
            //$conn->commit(); Inecseario :  se trata de una única sentencia SQL no es necesario actualizar
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
                 $_POST["cod"]
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
    //En un archivo HTML en el heder :  
    //echo '<meta http-equiv="refresh" content="1"; url= "listado.php">'
    //En un archivo PHP: || fuera del header
   header('Location: index.php');
  
  ?> 