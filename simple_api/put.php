<?php 

/**
 * permet d'envoyer une requete put à noter api rest
 * pour tester la maj d'un produit
 *  @author : the tmc 
 */

 $url = "http://api.nml/simple_api/produits/5"; # modifier le produit 1 
 $data = array(
     'name' => 'Basket',
     'description' => 'shoes for player',
     'price' => '5000',
     'category' => '8'
 );

 $ch = curl_init($url);
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
 curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

 $response = curl_exec($ch);

 var_dump($response);

 if (!$response)
 {
    return false;
 }