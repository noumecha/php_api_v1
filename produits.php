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