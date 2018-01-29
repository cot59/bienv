<?php

    $dossier = 'upload/';
    $fichier = basename($_FILES['testfile']['name']);
    $taille  = filesize($_FILES['testfile']['tmp_name']);
    
    if(move_uploaded_file($_FILES['testfile']['tmp_name'], $dossier . $fichier)){
        echo 'Upload réalisé avec succès';
    }else{
        echo 'Problème lors de l\'upload !';
    }
?>