<?php

/**
 * ce fichier nous sert pour la connexion à la base de donnnée mysql
 * @author : the tmc
 */

class DatabaseService
{
    private $db_host = "adminer.skr";
    private $db_name = "tmc_test";
    private $db_user = "root";
    private $db_pwd = "root";
    private $connection;

    /**
     * fonction pour la connection
     */
    public function getConnection()
    {
        $this->connection = null;

        try 
        {
            $this->connection = new PDO("mysql:host=" . $this->db_host . ";dbname=" .$this->db_name, $this->db_user,$this->db_pwd);
        } 
        catch (PDOException $ex)
        {
            echo "Echec de la connection: " . $ex->getMessage();
        }
        return $this->connection;
    }

}