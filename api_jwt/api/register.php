<?php
include_once './config/database.php';
/**
 * ce fichier contien le code pour creer un
 * nouvel utilisateur dans la base de donnée
 * @author : the tmc
 */

# configuration du header : 

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, x-Requested-with");

# les variables : 

$firstName = '';
$lastName = '';
$email = '';
$password = '';
$conn = null;

# config des var necessaires : 

$database = new DatabaseService();
$conn = $database->getConnection();

$data = json_decode(file_get_contents("php://input"));

$firstName = $data->first_name;
$lastName = $data->last_name;
$email = $data->email;
$password = $data->password;

$table_name = 'Users';

# debut du code : 

$query = "INSERT INTO ". $table_name . " SET first_name = :firstname, last_name = :lastname, email = :email, password_usr = :password";
$stmt = $conn->prepare($query);

$stmt->bindParam(':firstname', $firstName);
$stmt->bindParam(':lastname',$lastName);
$stmt->bindParam(':email',$email);

$password_hash = password_hash($password, PASSWORD_BCRYPT);

$stmt->bindParam(':password',$password_hash);

if($stmt->execute())
{
    http_response_code(200);
    echo json_encode(
        array(
            "statut" => "200",
            "message" => "L'utilisateur a bien été enregistré."
        )
    );
}
else
{
    http_response_code(400);
    echo json_encode(
        array(
            "statut" => "400",
            "message" => "Impossible d'enregistrer l'utilisateur"
        )
    );
}