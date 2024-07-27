<?php
    include '../model/crudUsuario.php';

    if(isset($_POST["opcao"])){
        $opcao = $_POST["opcao"];
    }
    else{
        $opcao = $_GET["opcao"];
    }
    session_start();

    //Arquivo de controle das funções - recebe o valor pelas páginas e envia para o crud. O valor recebido define qual query executar
    switch($opcao){
        case 'Mestre':
            $email = $_POST["email"];
            if (emailExiste($email)) {
                // Mudar os alertas para JavaScript em vez de PHP para evitar problemas de cabeçalhos
                echo "<script>alert('Este email já está sendo usado por outro usuário.');</script>";
                echo "<script>window.location='../view/cadastrarUsuario.php';</script>";
                exit();
            }
            masterSQL($_POST["nome"], $_POST["email"], $_POST["telefone"], $_POST["tipo"], sha1($_POST["senha"]), $_POST["status"]);
            header("Location: ../view/paginaLogin.php");
            exit();
            break;

        case 'Cadastrar':
            $email = $_POST["email"];
            if (emailExiste($email)) {
                echo "<script>alert('Este email já está sendo usado por outro usuário.');</script>";
                echo "<script>window.location='../view/cadastrarUsuario.php';</script>";
                exit();
            }
            cadastrarUsuario($_POST["nome"], $_POST["email"], $_POST["telefone"], sha1($_POST["senha"]));
            header("Location: ../view/paginaLogin.php");
            exit();
            break;        

        case 'Entrar':
            $email = $_POST["email"];
            $senha = sha1($_POST["senha"]);
            $status = "ativo";
            $banco = buscarUsuario($email);
            if($email === $banco['email']){
                if($senha === $banco['senha']){
                    if($status === $banco['status']){
                        // Defina as variáveis de sessão
                        $_SESSION['nome'] = $banco['nome'];
                        $_SESSION['tipo'] = $banco['tipo'];
                        $_SESSION['email'] = $banco['email'];
                        $_SESSION['telefone'] = $banco['telefone'];
                        $_SESSION['status'] = $banco['status'];
                        $_SESSION['senha'] = $banco['senha'];
                        $_SESSION['id_usuario'] = $banco['id_usuario'];

                        // Redirecione após iniciar a sessão
                        header("Location: ../view/paginaPrincipal.php");
                        exit(); // Certifique-se de sair após redirecionar
                    }
                    else{
                        echo "<script>alert('Usuário inativo ou inadimplente.');</script>";
                        echo "<script>window.location='../view/paginaLogin.php';</script>";
                        exit();
                    }
                }
                else{
                    echo "<script>alert('Senha incorreta!');</script>";
                    echo "<script>window.location='../view/paginaLogin.php';</script>";
                    exit();
                }
            }
            else{
                echo "<script>alert('Email de usuário não encontrado.');</script>";
                echo "<script>window.location='../view/paginaLogin.php';</script>";
                exit();
            }
            break;

        case 'Sair':
            session_start();
            session_destroy();
            $_SESSION['msg'] = 'Usuário deslogado!';
            header("Location: ../view/paginaLogin.php");
            exit();
            break;      

        case 'Atualizar':
            atualizarUsuario($_POST["id_usuario"], $_POST["nome"], $_POST["email"], 
                $_POST["telefone"], $_POST["tipo"], sha1($_POST["senha"]), 'ativo');
            header("Location: ../view/perfilUsuario.php");
            exit();
            break;

        case 'Excluir':
            atualizarUsuario($_SESSION["id_usuario"], $_SESSION["nome"], $_SESSION["email"], 
            $_SESSION["telefone"], $_SESSION["tipo"], $_SESSION["senha"], 'inativo');

            // Destruir a sessão
            session_start();
            session_destroy();

            // Redirecionar para a página de login ou qualquer outra página desejada
            header("Location: ../view/paginaPrincipal.php");
            exit();
            break;

        case 'DeletarUsuario':
            deletarUsuario($_POST["id_usuario"]);
            header("Location: ../view/paginaPrincipal.php");
            exit();
            break;
    }
?>