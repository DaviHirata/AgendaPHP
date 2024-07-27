<?php
    session_start();
    include '../model/crudAula.php';

    function obterIdAula($resultado) {
        // Verifica se a aula é fixa ou única
        if (!empty($resultado['id_aulas_fixas'])) {
            // Aula Fixa
            return $resultado['id_aulas_fixas'];
        } elseif (!empty($resultado['id_aulas_unicas'])) {
            // Aula Única
            return $resultado['id_aulas_unicas'];
        }
        
        // Caso não seja nem aula fixa nem aula única
        return 'ID não encontrado';
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
    <title>Meus Agendamentos</title>
</head>

<body>
    <?php
        if (session_status() == PHP_SESSION_NONE) {
            // A sessão não foi iniciada, inicie-a
            session_start();
        }
        if(isset($_SESSION['tipo']) && ($_SESSION['tipo'] == 'aluno')){
            //usuário é um desenvolvedor ou professor. pode acessar esta página
        }
        else{
            header("Location: paginaPrincipal.php");
        }

        if(isset($_SESSION['email'])){
            // Explode a string em partes usando o espaço como delimitador
            $nomeCompleto = $_SESSION['nome'];
            $partesNome = explode(' ', $nomeCompleto);

            // Pega o primeiro elemento do array resultante
            $primeiroNome = $partesNome[0];
        }
    ?>
    <div class="container">
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <a href="paginaPrincipal.php" class="navbar-brand">
                        <img src="../images/logo.jpg" alt="logo do site" width="60">
                        <p class="logo_site">Prof.ª Janaina</p>
                    </a>
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
        </nav>
        <div class="meuContainer">
            <h1>Meus Agendamentos</h1>
            </br>
            <div class="table-responsive-lg">
                <table class='table table-info'>
                    <thead>
                        <th scope='col'>Matéria</th>
                        <th scope='col'>Tipo de Aula</th>
                        <th scope='col'>Dia da aula</th>
                        <th scope='col'>Início</th>
                        <th scope="col">Fim</th>
                        <th scope='col'>Status</th>
                        <th scope='col'>Editar</th>
                    </thead>

                    <?php
                        $resultados = mostrarAgendamentos($_SESSION['id_usuario']);
                        foreach($resultados as $resultado){
                            echo "<tr>";
                            echo "<td>".$resultado['materia']."</td>";
                            echo "<td>".$resultado['tipo_aula']."</td>";
                            echo "<td>".$resultado['data_aula']."</td>";
                            echo "<td>".$resultado['horario_inicio']."</td>";
                            echo "<td>".$resultado['horario_fim']."</td>";
                            echo "<td>".$resultado['status']."</td>";
                            if($resultado['status'] !=  'aceito'){
                                echo "<td>" . "<a href='editarAgendamento.php?id=" . $resultado['id_aula'] . "' class='btn btn-primary'>Editar</a>" . "</td>";
                            }
                            echo "</tr>";
                        }
                    ?>
                </table>
            </div>
            </br>
            <div class="botoes-container">
                <a href="../view/agendarAula.php" class="botaoVoltar">Novo agendamento</a>
                <a href="../view/paginaPrincipal.php" class="botaoVoltar">Voltar</a>
            </div>
        </div>
    </div>
</body>

</html>