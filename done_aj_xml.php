<?php
    //Definition du nom de fichier
    $fichier = 'biens.xml';

    $corps = '</organisme>';

    file_put_contents($fichier,$corps,FILE_APPEND);

    header('Location:complete.php');
?>