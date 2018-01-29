<?php

    function connexionBaseDeDonnees($login,$pass){
        $tns = "(DESCRIPTION = (ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = 192.168.32.197)(PORT = 1521))) (CONNECT_DATA = (SERVICE_NAME = logi)))";
        $db_username = "logi";
        $db_password = "sb";
        try
        {
          $conn = new PDO("oci:dbname=".$tns,$login,$pass);
        }catch(PDOException $e)
        {
          echo ($e->getMessage());
        }
        return $conn;
    }

    $pdo = connexionBaseDeDonnees('logi','sb');
?>