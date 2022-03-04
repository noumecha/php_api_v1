<?php 

/**
 * fichier permettant d'envoyer une requete post à noter api rest
 * pour tester l'ajout d'un nouveau produit
 *  @author : the tmc 
 */

$url = 'http://api.nml/produits';
$data = array(
    'name' => 'Car',
    'description' => 'Ferrari 90',
    'price' => '500000000',
    'category' => '7'
);

    # important : utiliser http meme si la req est envoyé à https
    $options = array(
        'http' => array(
            'header' => "Content-type: application/x-www-form-urlencoded\r\n",
            'method' => 'POST',
            'content' => http_build_query($data)
        )
    );

    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    if ($result === FALSE)
    {
        /* error occurs */
    }

    var_dump($result);