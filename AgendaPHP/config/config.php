<?php
    //Configuração da base de dados
    define('DB_HOST', 'db');
    define('DB_USERNAME', 'php_docker');
    define('DB_PASSWORD', 'password');
    define('DB_NAME', 'agenda');

    //Iniciar sessão
    if(!session_id()) session_start();
?>