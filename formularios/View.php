<?php
require_once("../db/AccessDB.php");

if(isset($_POST['accion']))
  if($_POST['accion']=="Ver")
  {
    //Then get the data from MYSQL
     $query = "SELECT cns_documento, id_carpeta, id_tipoDocumento, name, mime, size, data FROM detalle_documentos WHERE cns_documento=".$_POST['id_doc'];
     $result = mysqli_query($db->getConnection(),$query);
     if($result){
     	$row = mysqli_fetch_assoc($result);
        if(file_exists($row['data']))
            if($row['mime']=="application/pdf")
            {
                // Print headers
                header("Content-Type: ". $row['mime']);
                header("Content-Length: ". $row['size']);
                header("Content-Disposition: inline; filename=". $row['name']);
                header("Cache-Control: max-age=0, must-revalidate");
                header("Pragma: private");    

                // Print data
                $datos = file_get_contents($row['data']);
                echo $datos;
                exit;
            }
            else{
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="'.$row['name'].'"');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: '.$row['size']);
                readfile($row['data']);
                exit;
            }     	
     }
     else{
     	echo "Error! Falló la consulta: <pre>{".mysqli_error($db->getConnection())."}</pre>";
     }
 }
?>