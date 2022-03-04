<?php 

	/**
	 * fichier de connection à ma base de donnée pour mes test 
	 * v.0.0.1 : version 1
	 * @author : the tmc
	 */

	// définition des paramètre de connection 

	$db_hn = "adminer.skr";
	$db_usr = "root";
	$db_pwd = "root";
	$db_name = "tmc_test";
	$table = "produit";

	/**
	 * je définis la syntaxe de connecton des trois méthodes 
	 * à vous de choisir celle qui vous siet le plus parmis : 
	 * PDO , mysqli et mysql 
	 * @author : the tmc
	 */


	/**
	 * 
	 * connection avec mysqli;
	 * 
	 * avec mysqli les basics : 
	 * mysqli_connect : pour creer une nouvelle connection
	 * mysqli_query : pour éxécuter des requete mysql
	 * mysqli_fetch_row : pour lire les données d'une table 
	 * mysqli_close : pour fermener la connection à la bd 
	 */

	$con_sqli = $mysqli_connect($db_hn,$db_usr,$db_pwd,$db_name);

	/**
	 * 
	 * connection avec le PDO ;
	 * 
	 * PDO est un object :D 
	 * exemple de con via pdo : 
	 * try {
	 * 		$con_pdo;
	 * } catch (PDOException $ex) 
	 * {
	 * 		echo "impossible de se ...".$e->getMessage();
	 * 
	 * }
	 * 
	 * req avec pdo : 
	 * $res = $pdo->prepare($req);
	 * $exec = $res->execute();
	 */

	$con_pdo = new PDO("mysql:host=$db_hn;$db_name",$db_usr,$db_pwd);

	/**
	 * 
	 * connection à la base donnée via mysql_connect ;
	 * 
	 * syntaxe : mysql_connect(serveur,nom_user,pwd); 
	 */

	//$con_sql = mysql_connect($db_hn,$db_usr,$db_pwd);