<?php
/**
 * ce fichier est une classe utiliser pour la connection à notre bdd 
 * @author : the tmc
 */

   $connect = new PDO("mysql:host=adminer.skr; dbname=tmc_test",'root','root');

   use PDO;
   
   class Connect {

      private $pdo;

      # constructeur : 
      public function Connect(){

      }

      private function con(){
         $this->pdo = new PDO("mysql:host=adminer.skr; dbname=tmc_test", 'root','root');
      }

   }
