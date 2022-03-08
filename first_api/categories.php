<?php 

    # header de notre api : 
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json; charset-utf-8');

    /**
     * ce fichier nous permet de faire des test pour l'api des formations :)
     * @author : the tmc
     */
    # appel de notre classe :)
    #use \Connect;

    # fichier requis : 
    require_once 'Connect.php';

    # creation des objets : 
    #$con = new Connect();

    # test : 
    $sql = "SELECT * FROM categories";

    $query = $connect->prepare($sql);
    $query->execute();
    $all_user_info = $query->fetchAll(PDO::FETCH_ASSOC);

    echo(json_encode($all_user_info));