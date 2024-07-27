<?php
    include 'conexaoDB.php';

    //Cadastra o usuário no banco de dados
    function cadastrarUsuario($nome, $email, $telefone, $senha){
        connect();
        query("INSERT INTO usuario (nome, email, telefone, tipo, senha, status) VALUES ('$nome', '$email', '$telefone', 'aluno', '$senha', 'ativo')");
        close();
    }

    //Função para verificar se o email inserido no cadastro já existe
    function emailExiste($email) {
        $usuario = buscarUsuario($email);
        return $usuario !== false;
    }

    //Busca o usuário pelo email cadastrado e retorna todos os valores correspondentes - função vai ser utilizada para login
    function buscarUsuario($email){
        connect();
        $consulta = query("SELECT * FROM usuario WHERE email = '$email'");
        if (mysqli_num_rows($consulta) > 0) {
            $resultadoSeparado = mysqli_fetch_assoc($consulta);
            close();
            return $resultadoSeparado;
        } else {
            close();
            return false;
        }
    }

    //Mostra todos os usuários cadastrados na base de dados
    function mostrarUsuarios(){
        connect();
        $consulta = query("SELECT * FROM usuario");
        close();

        $resultados = [];
        if(mysqli_num_rows($consulta) > 0){
            while($resultadoSeparado = mysqli_fetch_assoc($consulta)){
                $resultados[] = $resultadoSeparado;
            }
        }
        return $resultados;
    }

    //Mostra todos os alunos cadastrados na base de dados
    function mostrarAlunos($tipo){
        connect();
        $consulta = query("SELECT * FROM usuario WHERE tipo = '$tipo'");
        close();

        $resultados = [];
        if(mysqli_num_rows($consulta) > 0){
            while($resultadoSeparado = mysqli_fetch_assoc($consulta)){
                $resultados[] = $resultadoSeparado;
            }
        }
        return $resultados;
    }

    //Procura as informações do usuário que será alterado pelo id enviado
    function mostrarUsuarioAlterar($id){
        connect();
        $consulta = query("SELECT * FROM usuario WHERE id_usuario = $id");
        close();

        $resultadoSeparado = mysqli_fetch_assoc($consulta);
        return $resultadoSeparado;
    }

    //Envia para o banco as novas informações do usuário, após a edição
    function atualizarUsuario($id, $nome, $email, $telefone, $tipo, $senha, $status){
        connect();
        query("UPDATE usuario SET nome = '$nome', email = '$email', telefone = '$telefone', tipo = '$tipo', senha = '$senha', 
            status = '$status' WHERE id_usuario = $id");
        close();
    }

    //Deleta um usuário pelo id selecionado
    function deletarUsuario($id){
        connect();
        query("DELETE FROM usuario WHERE id_usuario = $id");
        close();
    }

    function masterSQL($nome, $email, $telefone, $tipo, $senha){
        connect();
        query("INSERT INTO usuario (nome, email, telefone, tipo, senha, status) VALUES ('$nome', '$email', '$telefone', '$tipo', '$senha', 'ativo')");
        close();
    }
?>