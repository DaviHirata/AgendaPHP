<?php
    session_start();
    if (isset($_SESSION['msg'])) {
        echo '<script>alert("' . $_SESSION['msg'] . '");</script>';
        unset($_SESSION['msg']);
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/reset.css">
        <link rel="stylesheet" href="../css/geral.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
            integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
            integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
        </script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
            integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
            integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
        </script>
        <link href="https://fonts.cdnfonts.com/css/love-light" rel="stylesheet">
        <title>Agenda de aulas</title>
    </head>

    <body>
        <div class="container">
            <nav class="navbar navbar-expand-lg">
                <div class="container-fluid">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <a href="paginaPrincipal.php" class="navbar-brand">
                            <img src="../images/logo.jpg" alt="logo do site" width="60">
                            <p class="logo_site">Prof.ª Janaina</p>
                        </a>
                        <?php
                        if (session_status() == PHP_SESSION_NONE){
                            echo '<li class="nav-item">';
                                echo '<button type="button" class="btn-mint"><a class="nav-link" 
                                    href="../view/cadastrarUsuario.php">Cadastrar</a></button>';
                            echo '</li>';
                            echo '<li class="nav-item">';
                                echo '<button type="button" class="btn-mint"><a class="nav-link"
                                        href="../view/paginaLogin.php">Acessar</a></button>';
                            echo '</li>';
                        }
                        ?>
                        <li class="nav-item espacado">
                            <button type="button" class="btn-mint"><a class="nav-link"
                                    href="../view/precos.php">Preços</a></button>
                        </li>
                        <li class="nav-item">
                            <button type="button" class="btn-mint"><a class="nav-link" href="../view/sobre.php">Sobre a
                                    Professora</a></button>
                        </li>
                    </ul>
                </div>
                <?php
                if(isset($_SESSION['email'])){
                    // Explode a string em partes usando o espaço como delimitador
                    $nomeCompleto = $_SESSION['nome'];
                    $partesNome = explode(' ', $nomeCompleto);

                    // Pega o primeiro elemento do array resultante
                    $primeiroNome = $partesNome[0];
                ?>

                <div class="dropdown">
                    <button class="user-btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <?php echo $primeiroNome; ?>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="../view/perfilUsuario.php">Meu Perfil</a>
                        <a class="dropdown-item" href="../controller/controleUsuario.php?opcao=Sair">
                            <button class="btn-danger">Sair</button>
                        </a>
                    </div>
                </div>

                <?php
                }
                ?>

            </nav>

            <div class="meuContainer">
                <?php
                    if(isset($_SESSION['tipo']) && ($_SESSION['tipo'] == 'desenvolvedor')){
                        echo '<br><a href="../view/mostrarUsuarios.php" class="botaoPP">Ver Usuários</a>';
                        echo '<br><a href="../view/mostrarAlunos.php" class="botaoPP">Ver Alunos</a>';
                    } elseif(isset($_SESSION['tipo']) && ($_SESSION['tipo'] == 'professor')){
                        echo '<br><a href="../view/mostrarUsuarios.php" class="botaoPP">Ver Usuários</a>';
                        echo '<br><a href="../view/mostrarAlunos.php" class="botaoPP">Ver Alunos</a>';
                        //echo '<br><a href="../view/verAgenda.php" class="botaoPP">Ver Agenda</a>';
                        echo '<br><a href="../view/verRequisicoes.php" class="botaoPP">Ver Requisições de Aula</a>';
                        echo '<br><a href="../view/verMeusHorarios.php" class="botaoPP">Ver Meus Horários</a>';
                    } elseif(isset($_SESSION['tipo']) && ($_SESSION['tipo'] == 'aluno')){
                        echo '<br><a href="../view/agendarAula.php" class="botaoPP">Novo agendamento</a>';
                        echo '<br><a href="../view/verAgendamentos.php" class="botaoPP">Minhas aulas</a>';
                    } else{
                        echo '<br><a href="../view/agendarAula.php" class="botaoPP">Agende uma aula!</a>';
                    }
                ?>
            </div>
        </div>
        </br>
    </body>
</html>