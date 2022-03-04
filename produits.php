<?php 

/**
 * fichier contennt toute les méthodes d'API REST
 * PUT,GET,POST,DELETE
 *  @author : the tmc 
 */

# fichier de connection à la bd : 
    require_once 'login.php';

    # la méthode utiliser :

    $request_method = $_SERVER["REQUEST_METHOD"];

    # en fonction de l améthode : 

    switch($request_method)
    {
        case 'GET':
            if(!empty($_GET["id"]))
            {
                # recupération d'un seul id :
                $id = intval($_GET["id"]);
                getProduct($id);
            } 
            else 
            {
                # récupération de tout les prods : 
                getProducts();
            }
            break;
        case 'POST':
            addProduct();
            break;
        case 'PUT':
            $id = intval($_GET["id"]);
            updateProduct($id);
            break;
        case 'DELETE':
            $id = intval($_GET["id"]);
            deleteProduct($id);
            break;
        default:
            # requete invalide : 
            header("HTTP/1.0 405 Method Not Allowed");
            break;
    }

    # methode getproducts() : 

    /**
     * la fonction de notre api pour récuperer les produits
     * 
     * @author : the tmc
     */

    function getProducts()
    {
        global $con_sqli;
        $query = "SELECT * From produit";
        $response = array();
        $result = $con_sqli->query($query);

        try {

            while($row = mysqli_fetch_array($result))
            {
                $response[] = $row;
            }
            header('Conten-Type: application/json');
            echo json_encode($response, JSON_PRETTY_PRINT);

        } catch (\Throwable $th) {
            
            echo "erreur de connection : ".$th->getMessage()." ".$th->getCode();

        }


    }

    /**
     * cette fonction permet de recuperer un produit 
     * en fonction de son id 
     * @author : the tmc 
     */

    function getProduct($id=0)
    {

        global $con_sqli;
        $query = "SELECT * From produit";
        if($id!=0)
        {
            $query .= " WHERE id=".$id." LIMIT 1";
        }

        $response = array();
        $result = $con_sqli->query($query);

        try {

            while($row = mysqli_fetch_array($result))
            {
                $response[] = $row;
            }
            header('Conten-Type: application/json');
            echo json_encode($response, JSON_PRETTY_PRINT);

        } catch (\Throwable $th) {
            
            echo "erreur de connection : ".$th->getMessage()." ".$th->getCode();

        }

    }

    /**
     * 
     * function pour la creation d'un nouvel enregistrement dans
     * la bd 
     */
    function addProduct()
    {

        global $con_sqli;
        $name = $_POST["name"];
        $description = $_POST["description"];
        $price = $_POST["price"];
        $category = $_POST["category"];
        $created = date('Y-m-d H:i:s');
        $modified = date('Y-m-d H:i:s');

        echo $query = "INSERT INTO produit(name,description,price, category_id,created,modified) VALUES ('".$name."','".$description."','".$price."','".$category."','".$created."','".$modified."')";

        if ($con_sqli->query($query))
        {
            $response = array('status'=> 1, 'status_message'=>'Produit ajouté avec succès.');
        }
        else
        {
            $response = array('status'=>0, 'status_message'=> 'ERREUR!.'. mysqli_error($con_sqli));
        }
        header('Content-Type: application/json');
        echo json_encode($response);

    }

    /**
     * 
     * fonction pour la maj d'n produit à partir de son id
     * PHP n'a pas de var global $_PUT , on utilisera don les flux d'entrée:
     * input stream 'php://input' 
     */
    function updateProduct($id)
    {

        global $con_sqli;
        $_PUT = array(); // tableau qui contiendra les data

        parse_str(file_get_contents('php://input'), $_PUT);
        $name = $_PUT["name"];
        $description = $_PUT["description"];
        $price = $_PUT["price"];
        $category = $_PUT["category"];
        $modified = date('Y-m-d H:i:s');

        # requete de d'update : 
        $query = "UPDATE produit SET name='".$name."', description ='".$description."', price='".$price."', category_id='".$category."', modified='".$modified."' WHERE id=".$id;

        if ($con_sqli->query($query))
        {
            $response = array('status'=>1, 'status_message'=>'Produit mis a jour');
        }        
        else 
        {
            $response = array('status'=>0, 'status_message'=>'Echec de la mise à jour du produit.'.mysqli_error($con_sqli));
        }
        header('Conten-Type: application/json');
        echo json_encode($response);

    }

    /**
     * fonction pour supprimer un produit de la bd 
     * $_DELETE
     */
    function deleteProduct($id)
    {
        global $con_sqli;
        $query = "DELETE FROM produit WHERE id=".$id;

        if ($con_sqli->query($query))
        {
            $response= array(
                'status'=> 1, 
                'status_message'=>'produit supprimé avec succès.'
            );
        }
        else
        {
            $response = array(
                'status' => 0,
                'status_message' => 'echec de la surpression du produit'
            );
        }
        header('Conten-Type: application/json');
        echo json_encode($response);
    }