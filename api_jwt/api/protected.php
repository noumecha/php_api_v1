<?php

/**
 * ce fichier permet de :  
 * -> protéger la terminaison api à l'aide de jwt 
 * -> avant d'acceder à un point de termination , un jeton jwt doit etre envoyé avec chaque demande du client.
 * @author : the tmc
 */
# inclusion et chargement des librairies : 

include_once './config/database.php';
require "../vendor/autoload.php";
use \Firebase\JWT\JWT;


# header : 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, x-Requested-with");

# variables : 

$secret_key = "NOUMEL_API_JWT";
$jwt = null;
$databaseservice = new DatabaseService();
$conn = $databaseservice->getConnection();

$data = json_decode(file_get_contents("php://input"));

$authHeader = $_SERVER['HTTP_AUTHORIZATION'];

$arr = explode (" ", $authHeader);

$jwt = $arr[1];

if($jwt){
    try{
        $decoded = JWT::decode($jwt, $secret_key, array('HS256'));

        # accès autoruisé : 

        echo json_encode(
            array(
                "messsage" => "Accès autorisé;",
                "error" => $e->getMessage()
            )
            );
    } 
    catch(Exception $e)
    {
        http_response_code(401);

        echo json_encode(
            array(
                "messsage" => "Accès refusé",
                "error" => $e->getMessage()
            )
            );
    }
}