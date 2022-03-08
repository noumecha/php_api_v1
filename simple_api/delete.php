<?php 

/**
 * permet d'envoyer une requete put à notre api rest
 * pour tester la surpression d'un nouveau produit
 *  @author : the tmc 
 */

$url = "http://api.nml/simple_api/produits/0"; // delete product 1
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch,CURLOPT_CUSTOMREQUEST, "DELETE");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
var_dump($response);
curl_close($ch);