<?php
    require_once '../config/config.php';
    $conexao;   

    function connect(){
        global $conexao;
        $servidor='db';
        $nomeUsuario='php_docker';
        $senhaUsuario='password';
        $base='agenda';
        $conexao=mysqli_connect($servidor, $nomeUsuario, $senhaUsuario, $base) or die(mysqli_connect_error());

        return $conexao;
    }

    // Função original com apenas um parâmetro
    function query($sql) {
        global $conexao;  // Certifique-se de ter a conexão disponível globalmente
        mysqli_query($conexao, "SET CHARACTER SET utf8");
        $query = mysqli_query($conexao, $sql) or die(mysqli_error($conexao));
        return $query;
    }

    // Nova função com dois parâmetros (conexao e sql)
    function queryComConexao($conexao, $sql) {
        mysqli_query($conexao, "SET CHARACTER SET utf8");
        $query = mysqli_query($conexao, $sql) or die(mysqli_error($conexao));
        return $query;
    }
    
    function close(){
        global $conexao;
        mysqli_close($conexao);
    }
?>