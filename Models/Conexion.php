<?php

class Conexion {

    public $db;

    function __construct()
    {
        try {
            $this->db = new PDO('mysql:dbname=sys_ti;host=localhost','root','');
        } catch (PDOException $e) {
            echo 'Error en la Conexión: '.$e->getMessage();
        }
    }

}

?>