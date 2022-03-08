<?php 

    // for displaying error : 
    ini_set('display_errors',1);
    error_reporting(E_ALL);
/**
 * ce fichier correspond à un simple test d'api 
 * just for the fun 
 * @author : the tmc
 */
    header('Content-Type: application/json');

    // import : 
    require_once('../login.php');

    // connection à la bd : 
    try
    {

        $con_pdo; 
        $retour["success"] = true;
        $retour["message"] = "Connexion à la base de donnée reussie";

    }
    catch (Exception $e)
    {

        $retour["success"] = false;
        $retour["message"] = "Connexion à la base de donnée impossible";

    }
    // avec un post pour le tri : 
    if (!empty($_POST["ville_depart"]) && !empty($_POST["ville_destination"]) && !empty($_POST["date_depart"]) && !empty($_POST["nb_heure_vol"]) && !empty($_POST["prix"])) {

        // vérification de la valeur du prix  
        if (intval($_POST["prix"]) > 0){

            $req = $con_pdo->prepare("INSERT INTO vols ('ville_depart','ville_destination','date_depart','nb_heure_vol','prix') values (:ville_d, :ville_dest,:date_d,:nbhv,:prix)");
            $req->bindParam(':ville_d', $_POST["ville_depart"]);
            $req->bindParam(':ville_dest', $_POST["ville_destination"]);
            $req->bindParam(':date_d', $_POST["date_depart"]);
            $req->bindParam(':nbhv',$_POST["nb_heure_vol"]);
            $req->bindParam(':prix',$_POST["prix"]);
            $req->execute();

            $retour["success"] = true;
            $retour["message"] = "le vol a été ajouté";
            $retour["results"] = array();

        }
        else 
        {

            $retour["success"] = false;
            $retour["message"] = "Le prix indiqué n'est pas correct";

        }

    } else {

        $retour["success"] = false;
        $retour["message"] = "il manque des informations";

    }
    
    // toujours retour des informations à la fin de l'exécution
    # formatage en json : 
    echo json_encode($retour);