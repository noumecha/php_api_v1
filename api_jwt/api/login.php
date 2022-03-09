<?php

include_once './config/database.php';
require "../vendor/autoload.php";
use \Firebase\JWT\JWT;

/**
 * ce fichier contient le code pour la vérification des infos 
 * d'identification des user et renvoyer le jetons jwt au client 
 * @author : the tmc
 */

# header : 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, x-Requested-with");

# variables : 
$email = '';
$password = '';

$databaseservice = new DatabaseService();
$conn = $databaseservice->getConnection();

$data = json_decode(file_get_contents("php://input"));

$email = $data->email;
$password = $data->password;

$table_name = 'Users';


try {
    $query = "SELECT id, first_name, last_name, password_usr FROM " . $table_name . " WHERE email = ? LIMIT 0,1";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(1, $email);
    $stmt->execute();
    $num = $stmt->rowCount();
} catch (PDOException $ex) {
    echo "Erreur lors de la selection des données , erreur : ". $ex->getMessage();
}

# single test : 

#echo $num;
#$arr = [];
#$arr = $stmt->fetch(PDO::FETCH_ASSOC);
#$is_id = $arr["id"];

#echo $is_id . "<br>";
#echo $email . "<br>";
#echo $password;

if($num > 0)
{
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $id = $row["id"];
    $firstname = $row["first_name"];
    $last_name = $row["last_name"];
    $password2 = $row["password"];

    if(password_verify($password, $password2))
    {
        $secret_key = "NOUMEL_API_JWT";
        $issuer_claim = "ADMINER.SKR"; // ce peut etre le nom du serveur
        $audience_claim = "JUST_FOR_THE_CODE";
        $issuedat_claim = time(); // fin a 
        $notbefore_claim = $issuedat_claim + 10; // en seconds
        $expire_claim = $issuedat_claim + 60; // expiration en seconds
        $token = array(
            "iss" => $issuer_claim, // chaine contenant le nom ou l'identifiant de l'application emettrice.
            "aud" => $audience_claim,
            "iat" => $issuedat_claim, // horodatage de l'emisson du jeton
            "nbf" => $notbefore_claim, // Horodatage du moment ou le jeton doit commencer à etre considére comme valide doit etre >= a iat
            "exp" => $expire_claim, // Hordage du momement ou le jeton doit s'arreter pour etre valide doti etre en tre [iat et nbf]
            "data" => array(
                "id" => $id,
                "firstname" => $firstname,
                "lastname" => $lastname,
                "email" => $email
            )
            );
        http_response_code(200);

        $jwt = JWT::encode($token, $secret_key,null);
        echo json_encode(
            array(
                "message" => "connection reussi",
                "jwt" => $jwt,
                "email" => $email,
                "expireAt" => $expire_claim
            )
            );
        /**
         * 
         * le jeton jwt creer doit etre conservé dans le stockage local du brwoser
         * ou dans les cookies à l'aide de javascript puis attaché à chaque requete HTTP 
         * envoyée pour accéder à une ressource protégé sur le serveur php.
         */
    }
    else
    {
        http_response_code(401);
        echo json_encode(
            array(
                "message" => "Echec d'authenification",
                "password" => $password
            )
            );
    }
}