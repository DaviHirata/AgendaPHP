<?php
    require_once 'config.php';

    //Criar conexão com a base de dados
    $db = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

    //Checar conexão
    if($db->connect_error){
        die("Connection failed: " . $db->connect_error);
    }
?>