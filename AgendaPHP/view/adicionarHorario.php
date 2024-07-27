<?php
    if (session_status() == PHP_SESSION_NONE) {
        // A sessão não foi iniciada, inicie-a
        session_start();
    }
    if(isset($_SESSION['tipo']) && ($_SESSION['tipo'] == 'professor')){
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
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
    <title>Adicionar Horário</title>
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
            <h1>Adicionar Horário</h1>
            </br>
            <form method="post" action="../controller/controleHorarios.php">
                <div class="mb-3">
                    <label for="local">Local: </label>
                    <input type="text" name="local" id="local" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="frequencia">Frequência: </label>
                    <select class="form-select form-control" name="frequencia" id="frequencia" required>
                        <<option value="" disabled selected hidden>Escolha a frequência da aula</option>
                            <option value="2">Aula fixa</option>
                    </select>
                </div>
                <div class="row auto" id="diasHorariosContainer" style="display: none;">
                    <div class="col">
                        <label for="diaSemana">Dias da semana: </label>
                        <select class="form-select form-control" name="diaSemana" id="diaSemana">
                            <option value="Segunda">Segunda</option>
                            <option value="Terça">Terça</option>
                            <option value="Quarta">Quarta</option>
                            <option value="Quinta">Quinta</option>
                            <option value="Sexta">Sexta</option>
                        </select>
                    </div>
                    <div class="col">
                        <label for="horaInicio">Início: </label>
                        <input type="time" class="form-control" name="horaInicio" id="horaInicio">
                    </div>
                    <div class="col">
                        <label for="horaFim">Fim: </label>
                        <input type="time" class="form-control" name="horaFim" id="horaFim">
                    </div>
                </div>
                </br>
                <input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $_SESSION['id_usuario']; ?>">

                <?php
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        // Verifica se a opção é Adicionar Aula Fixa
                        if(isset($_POST['opcao']) && $_POST['opcao'] == 'AddAulaFixa') {
                            // Processa os campos relevantes para aula fixa
                            $local = $_POST['local'];
                            $diaSemana = $_POST['diaSemana'];
                            $horaInicioFixa = $_POST['horaInicioFixa'];
                            $horaFimFixa = $_POST['horaFimFixa'];
                        }
                    }
                ?>
                <button type="submit" name="opcao" id="botaoAdicionar" class="btn btn-primary">Adicionar</button>
            </form>
        </div>
    </div>
</body>

<script>
//script para mudar as ações dependendo da frequência escolhida
document.getElementById('frequencia').addEventListener('change', function() {
    var frequenciaSelecionada = this.value;

    if (frequenciaSelecionada == '2') {
        diasHorariosContainer.style.display = 'flex';
        document.getElementById('diaSemana').setAttribute('required', true);
        document.getElementById('horaInicioFixo').setAttribute('required', true);
        document.getElementById('horaFimFixo').setAttribute('required', true);
    } else {
        diasHorariosContainer.style.display = 'none';
    }
});

//script para mudar o tipo de aula que será adicionada: se for adicionada uma aula fixa, deve ir pra tabela de aulas fixas,
//caso contrário, deve ir para a tabela de aulas únicas
document.getElementById('botaoAdicionar').addEventListener('click', function(){
    var frequenciaSelecionada = document.getElementById('frequencia').value;

    if(frequenciaSelecionada == '2'){
        document.getElementsByName('opcao')[0].value = 'AddAulaFixa';
    }    
})

</script>

</html>