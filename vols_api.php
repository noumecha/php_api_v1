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
    require_once('login.php');

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
    if (!empty($_POST["ville_depart"])) {
        $req = $con_pdo->prepare("SELECT * FROM vols WHERE ville_depart LIKE :v");
        $req->bindParam(':v', $_POST["ville_depart"]);
        $req->execute();
    } else {
        $req = $con_pdo->prepare("SELECT * FROM vols");
        $req->execute();
    }

    // retrour des infos en fin d'execution 
    $results = $req->fetchAll();
    try 
    {
        $req->execute();
        $retour["success"] = true;
        $retour["message"] = "Voici les vols en cours : ";
        $retour["res"]["nb"] = count($results);
        $retour["res"]["vols"] = $results;
    } 
    catch (Exception $e) 
    {
        echo "Erreur : ".$e->getMessage()." code erreur : ".$e->getCode();
    }
    # formatage en json : 
    echo json_encode($retour);