<?php
    if (session_status() == PHP_SESSION_NONE) {
        // A sessão não foi iniciada, inicie-a
        session_start();
    }
    if(isset($_SESSION['tipo']) && ($_SESSION['tipo'] == 'desenvolvedor' || $_SESSION['tipo'] == 'professor')){
        //usuário é um desenvolvedor ou professor. pode acessar esta página
    }
    else{
        header("Location: paginaPrincipal.php");
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
    <title>Informações da Aula</title>
</head>

<body>
    <?php
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
                    <li class="nav-item">
                        <button type="button" class="btn-mint"><a class="nav-link active" aria-current="page"
                                href="#">Usuários</a></button>
                    </li>
                    <li class="nav-item">
                        <button type="button" class="btn-mint"><a class="nav-link"
                                href="mostrarAlunos.php">Alunos</a></button>
                    </li>
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
            <h1>Informações sobre a aula</h1>
            </br>
            <div class="table-responsive-lg">
                <table class='table table-info'>
                    <thead>
                        <tr>
                            <th scope='col'>Nome do Aluno</th>
                            <th scope='col'>Matéria</th>
                            <th scope='col'>Modalidade</th>
                            <th scope='col'>Descrição</th>
                            <th scope="col">Data</th>
                            <th scope="col">Frequência</th>
                        </tr>
                    </thead>
                    <?php
                        include '../model/crudAula.php';
                        $id = $_GET["id"];
                        $resultado = mostrarRequisicoesAlterar($id);
                        $aula = mostrarAgendamentoAlterar($resultado['id_aula']);
                    ?>
                        <tr>
                            <td><?php echo buscarUsuario($aula['id_usuario']) ?>
                            <td><?php echo $aula['materia'] ?>
                            <td><?php echo $aula['tipo_aula'] ?>
                            <td><?php echo $aula['descricao'] ?>
                            <td><?php echo ($aula['data_aula'])?>
                            <td><?php echo $aula['frequencia'] ?>
                        </tr>
                </table>
                <table class='table table-info'>
                    <thead>
                    <tr>
                            <th scope="col">Início</th>
                            <th scope='col'>Fim</th>
                            <th scope='col'>Forma de Pagamento</th>
                            <th scope="col">Momento do Pagamento</th>
                            <th scope='col'>Aceitar</th>
                            <th scope='col'>Recusar</th>
                        </tr>
                    </thead>
                    <tr>
                            <td><?php echo $aula['horario_inicio'] ?>
                            <td><?php echo $aula['horario_fim'] ?>
                            <td><?php echo $aula['metodo_pagamento'] ?>
                            <td><?php echo ($aula['momento_pagamento'])?>
                            <td><button type="button" class= "btn btn-success" onclick="mudarStatus('aceito')">Aceitar</button></td>
                            <td><button type="button" class="btn btn-danger" onclick="mudarStatus('recusado')">Recusar</button></td>
                            <form method="post" action="../controller/controleAulas.php" id="formStatus" style="display: none;">
                                <input type="hidden" name="id_requisicao" id="id_requisicao" value="<?= $resultado['id_requisicao']?>">
                                <input type="hidden" name="frequencia" id="frequencia" value="<?= $aula['frequencia']?>">
                                <input type="hidden" name="status" id="status" value="">
                                <input type="hidden" name="opcao" value="AtualizarRequisicao">
                            </form>
                        </tr>
                </table>
            </div>
            </br>
            <div class="botoes-container">
                <a href="../view/verRequisicoes.php" class="botaoVoltar">Voltar</a>
            </div>
        </div>
    </div>
</body>

<script>
function mudarStatus(status) {
    document.getElementById("status").value = status;
    document.getElementById("formStatus").submit();
}
</script>

</html>