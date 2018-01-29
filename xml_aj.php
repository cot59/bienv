<?php
       

    function connexionBDD($login,$pass){
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

    function createBiensFile($lklo){
         
        //Connexion base de donnees
        $pdo = connexionBDD('logi','sb');
        
        if(isset($_POST['check_dispo'])){
            $dispo_now = 'O';
        }else{
            $dispo_now = 'N';
        }
        
        
        //Photo n°1
        if(isset($_FILES['photo1'])){
            $dossier = 'upload/';
            $fichier = basename($_FILES['photo1']['name']);
            if(move_uploaded_file($_FILES['photo1']['tmp_name'], $dossier . $fichier))
            {
                $photo1 = $dossier . $fichier;
            }else{
                echo 'Echec de l\'upload de la photo 1';
            }
        }
        
        //Photo n°2
        if(isset($_FILES['photo2'])){
            $dossier = 'upload/';
            $fichier = basename($_FILES['photo2']['name']);
            if(move_uploaded_file($_FILES['photo2']['tmp_name'], $dossier . $fichier)){
                $photo2 = $dossier . $fichier;
            }else{
                echo 'Echec de l\'upload de la photo 2';
            }
        }else{
            
        }
        
        //Photo n°3
        if(isset($_FILES['photo3'])){
            $dossier = 'upload/';
            $fichier = basename($_FILES['photo3']['name']);
            if(move_uploaded_file($_FILES['photo3']['tmp_name'], $dossier . $fichier)){
                $photo3 = $dossier . $fichier;
            }else{
                echo 'Echec de l\'upload de la photo 3';
            }
        }

        //Photo n°4
        if(isset($_FILES['photo4'])){
            $dossier = 'upload/';
            $fichier = basename($_FILES['photo4']['name']);
            if(move_uploaded_file($_FILES['photo4']['tmp_name'], $dossier . $fichier)){
                $photo4 = $dossier . $fichier;
            }else{
                echo 'Echec de l\'upload de la photo 4';
            }
        }
                
        try{
            
            //Definition du nom de fichier
            $fichier = 'biens.xml';
                    
            //Recuperation des donnees du logement from KLOGEMT
            $queryInfosLogement = $pdo -> prepare("SELECT PNPR, CMC, LOHA, HCHC, COC FROM KLOGEMT WHERE LKLO = :lklo");
            $queryInfosLogement -> execute(array('lklo' => $lklo));
                        
            while($infosLogement = $queryInfosLogement -> fetch(PDO::FETCH_ASSOC)){
                //Recuperation adresse Postale du lot
                $queryAdressePostale = $pdo -> prepare("SELECT ADRMOD0, ADRMOD1, ADRMOD3, ADRMOD4 FROM ADRWEB WHERE LKLO = :lklo");
                $queryAdressePostale -> execute(array('lklo' => $lklo));
                
                while($adressePostale = $queryAdressePostale -> fetch(PDO::FETCH_ASSOC)){
                    
                    $queryDateConstruction = $pdo -> prepare("SELECT TO_CHAR(DATECONS,'YYYY') AS DATECONS FROM KPROG WHERE PNPR = :pnpr AND DATECONS IS NOT NULL");
                    $queryDateConstruction -> execute(array('pnpr' => $infosLogement['PNPR']));
                    
                    while($dateConstruction = $queryDateConstruction -> fetch(PDO::FETCH_ASSOC)){
                        //Recuperation du code de type de logement
                        switch($infosLogement['CMC']){
                            case 'A':
                                $code_type = 1100;
                                break;
                            case 'M':
                                $code_type = 1200;
                                break;
                            case 'G':
                                $code_type = 1421;
                                break;
                            case 'H':
                                $code_type = 1421;
                                break;
                            case 'P':
                                $code_type = 1410;
                                break;
                            case 'Q':
                                $code_type = 1410;
                                break;
                            case 'O':
                                $code_type = 1420;
                                break;
                            default:
                                $code_type = 0000;
                        }

                        $queryTypeChauffage = $pdo -> prepare("SELECT ECE FROM KLOGEQP WHERE LKLO = :lklo AND ECE IN ('R2','R3','C1')");
                        $queryTypeChauffage -> execute(array('lklo' => $lklo));
                        
                        while($typeChauffage = $queryTypeChauffage -> fetch(PDO::FETCH_ASSOC)){
                            
                            $queryNombreDePieces = $pdo -> prepare("SELECT count(*) AS NB_PIECES FROM KLOGPIE WHERE LKLO = :lklo AND DATHS IS NULL AND PCPI IN ('SAL', 'SEJ', 'SCH', 'SCU', 'CH1', 'CH2', 'CH3', 'CH4', 'CH5', 'CH6', 'CH7','BUR','BU2','BU3','BU4','BU5','BU6')");
                            $queryNombreDePieces -> execute(array('lklo' => $lklo));
                            
                            switch($typeChauffage['ECE']){
                                case 'R2' :
                                    $typeChauff = 'individuel';
                                    break;
                                case 'R3' :
                                    $typeChauff = 'individuel';
                                    break;
                                case 'C1' :
                                    $typeChauff = 'collectif';
                                    break;
                            }
                            
                            while($nbrePieces = $queryNombreDePieces -> fetch(PDO::FETCH_ASSOC)){
                                
                                //Recuperation du nombre de pieces disponibles dans le lot
                                $codePostal = substr($adressePostale['ADRMOD4'],0,5);
                                $ville      = substr($adressePostale['ADRMOD4'],6);
                                $nomRue     = substr($adressePostale['ADRMOD1'],5);
                                $typeVoie   = substr($adressePostale['ADRMOD1'],0,3);
                                $numAppart  = $adressePostale['ADRMOD3'];
                                $numeroVoie = $adressePostale['ADRMOD0'];

                                $corps = '<annonce id="' . $lklo . '">';
                                
                                    $corps .= '<reference>' . $lklo . '</reference>';
                                    //A remplir dans un formulaire de saisie
                                    $corps .= '<titre>' . $_POST['titre'] . '</titre>';
                                    $corps .= '<texte>' . $_POST['corps'] . '</texte>';

                                    //Type de logement
                                    $corps .= '<code_type>' . $code_type . '</code_type>';
                                    $corps .= '<type>V</type>';

                                    //Adresse postale
                                    $corps .= '<numero_voie>' . $numeroVoie . ' ' . $numAppart . '</numero_voie>';
                                    $corps .= '<type_voie>' . $typeVoie . '</type_voie>';////////////////////////////////////////////////////////
                                    $corps .= '<nom_voie>' . $nomRue . '</nom_voie>';
                                    $corps .= '<code_postal>' . $codePostal . '</code_postal>';
                                    $corps .= '<ville>' . $ville . '</ville>';
                                    $corps .= '<pays>FRANCE</pays>';

                                    //Contact affiche sur l'annonce
                                    $corps .= '<contact_a_afficher>Flavie HUYSMAN</contact_a_afficher>';
                                    $corps .= '<telephone_a_afficher>03 28 58 09 51</telephone_a_afficher>';
                                    $corps .= '<email_a_afficher>fhuysman@cottage.fr</email_a_afficher>';

                                    //Disponibilite du bien
                                    $corps .= '<disponible_immediatement>' . $dispo_now . '</disponible_immediatement>';////////////////////////////////////////

                                    //Description "technique du bien"
                                    $corps .= '<surface>' . $infosLogement['LOHA'] . '</surface>';
                                    $corps .= '<nb_pieces_logement>' . $nbrePieces['NB_PIECES'] . '</nb_pieces_logement>';
                                    $corps .= '<annee_construction>' . $dateConstruction['DATECONS'] . '</annee_construction>';
                                    $corps .= '<ascenceur>N</ascenceur>';
                                    $corps .= '<chauffage_type>' . $typeChauff . '</chauffage_type>';
                                    $corps .= '<prix>' . $_POST['prix'] . '</prix>';

                                     //Photos du bien
                                    $corps .= '<photos>';
                                    if(isset($_FILES['photo1'])){
                                        $corps .= '<photo>' . $photo1 . '</photo>';
                                    }
                                    if(isset($_FILES['photo2'])){
                                        $corps .= '<photo>' . $photo2 . '</photo>';
                                    }
                                    if(isset($_FILES['photo3'])){
                                        $corps .= '<photo>' . $photo3 . '</photo>';
                                    }
                                    if(isset($_FILES['photo4'])){
                                        $corps .= '<photo>' . $photo4 . '</photo>';
                                    }
                                    $corps .= '</photos>';
                                $corps .= '</annonce>';

                                //Ecriture dans le fichier biens.xml
                                file_put_contents($fichier,$corps,FILE_APPEND);    
                            }
                        }
                    }
                }
            }            
                header('Location:done.php');
            
        }catch(Exception $e){
            echo 'Exception reçue : ', $e->getMessage(),"\n";
        }
        
    }

    createBiensFile($_POST['lklo']);

?>