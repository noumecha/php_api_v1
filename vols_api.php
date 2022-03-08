<?php 
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

    // requete de pour recupere les information de la bd vols: 
    $req = $con_pdo->prepare("SELECT * FROM vols;");
    try 
    {
        $req->execute();
        $retour["success"] = true;
        $retour["message"] = "Voici les vols en cours : ";
        $retour["res"]["vols"] = $req->fetchAll();
    } 
    catch (Exception $e) 
    {
        echo "Erreur : ".$e->getMessage()." code erreur : ".$e->getCode();
    }

    // retoor des informations à la fin : 
    echo json_encode($retour);