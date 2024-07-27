<?php
    session_start();
    if (!isset($_SESSION['email'])) {
        header("Location: paginaLogin.php");
        exit();
    }

    include '../model/crudUsuario.php';
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
    <title>Lista de Usuários</title>
</head>

<body>
    <?php
        if (isset($_SESSION['email'])) {
            $nomeCompleto = $_SESSION['nome'];
            $partesNome = explode(' ', $nomeCompleto);
            $primeiroNome = $partesNome[0];
        }

        $dadosFormulario = isset($_SESSION['dados_formulario']) ? $_SESSION['dados_formulario'] : array();
        unset($_SESSION['dados_formulario']);
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
            <h2>Agende a aula</h2>
            </br>
            <form method="post" action="../controller/controleAulas.php" class="formulario mb-3" id="formAula">
                <div class="mb-3" for="materia" required>
                    <div class="form-check form-check-inline mb-3">
                        <input class="form-check-input" type="radio" id="matematica" name="materia" value="matematica" <?php echo (isset($dadosFormulario['materia']) && $dadosFormulario['materia'] == 'matematica') ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="matematica">Matemática</label>
                    </div>

                    <div class="form-check form-check-inline mb-3">
                        <input class="form-check-input" type="radio" id="ingles" name="materia" value="ingles" <?php echo (isset($dadosFormulario['materia']) && $dadosFormulario['materia'] == 'ingles') ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="ingles">Inglês</label>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="tipoAula">Modalidade: </label>
                    <select class="form-select form-control" name="tipoAula" id="tipoAula" required>
                        <option value="" disabled selected hidden>Escolha a modalidade da aula</option>
                        <option value="presencial" <?php echo (isset($dadosFormulario['tipoAula']) && $dadosFormulario['tipoAula'] == 'presencial') ? 'selected' : ''; ?>>Presencial</option>
                        <option value="ead" <?php echo (isset($dadosFormulario['tipoAula']) && $dadosFormulario['tipoAula'] == 'ead') ? 'selected' : ''; ?>>Remota</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="descricao">Conteúdos que deseja estudar: </label>
                    <input type="text" name="descricao" id="descricao" class="form-control" value="<?php echo isset($dadosFormulario['descricao']) ? htmlspecialchars($dadosFormulario['descricao']) : ''; ?>" required>
                    <small id="descricaoHelp" class="form-text text-muted">Separe os conteúdos diferentes por vírgula
                        (,).</small>
                </div>

                <div class="mb-3">
                    <label for="frequencia">Frequência: </label>
                    <select class="form-select form-control" name="frequencia" id="frequencia" required>
                        <option value="" disabled selected hidden>Escolha a frequência da aula</option>
                        <option value="1">Aula única</option>
                        <option value="2">Duas aulas (em sequência)</option>
                        <option value="3">Semanalmente</option>
                    </select>
                </div>

                <div class="row mb-3" id="dataHoraContainer" style="display: none;" required>
                    <div class="col">
                        <label for="data">Data: </label>
                        <input type="date" class="form-control" name="dataUnica" id="dataUnica"
                            min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>">
                    </div>
                    <div class="col">
                        <label for="horaInicio">Início: </label>
                        <input type="time" class="form-control" name="horaInicioUnica" id="horaInicioUnica">
                    </div>
                </div>

                <div class="row auto" id="diasHorariosContainer" style="display: none;" required>
                    <div class="col">
                        <label for="diaSemana">Dias da semana: </label>
                        <select class="form-select form-control" name="diaSemana" id="diaSemana">
                            <option value="segunda">Segunda</option>
                            <option value="terca">Terça</option>
                            <option value="quarta">Quarta</option>
                            <option value="quinta">Quinta</option>
                            <option value="sexta">Sexta</option>
                        </select>
                    </div>
                    <div class="col">
                        <label for="horaInicioSemana">Início: </label>
                        <input type="time" class="form-control" name="horaInicioSemana" id="horaInicioSemana">
                    </div>
                </div>


                <div class="mb-3">
                    <label for="metodoPagamento">Método de pagamento: </label>
                    <select class="form-select form-control" name="metodoPagamento" id="metodoPagamento" required>
                        <option value="" disabled selected hidden>Escolha o método de pagamento</option>
                        <option value="pix">PIX</option>
                        <option value="dinheiro">Dinheiro</option>
                    </select>
                </div>

                <div class="mb-3" id="momentoPagamentoContainer" style="display: none;">
                    <label for="momentoPagamento">Escolha quando será feito o pagamento: </label>
                    <select class="form-select form-control" name="momentoPagamento" id="momentoPagamento" required>
                        <option value="" disabled selected hidden>Escolha quando será feito o pagamento</option>
                        <option value="ao_encerrar">Final da aula</option>
                        <option value="inicio_mes" style="display: none;">Início de cada mês</option>
                        <option value="final_mes" style="display: none;">Final de cada mês</option>
                    </select>
                </div>
                
                <input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $_SESSION['id_usuario']; ?>">

                <div class="botoes-container">
                    <button  type="submit" name="opcao" class="botaoVoltar" value="Agendar">Agendar aula</button>
                    <a href="../view/paginaPrincipal.php" class="botaoVoltar">Voltar</a>
                </div>
            </form>
            </br>
        </div>
    </div>
</body>

<script>
// Script para mudar as ações dependendo da frequência escolhida
document.getElementById('frequencia').addEventListener('change', function() {
    var frequenciaSelecionada = this.value;
    var dataHoraContainer = document.getElementById('dataHoraContainer');
    var diasHorariosContainer = document.getElementById('diasHorariosContainer');

    if (frequenciaSelecionada == '1' || frequenciaSelecionada == '2') {
        dataHoraContainer.style.display = 'flex';
    } else {
        dataHoraContainer.style.display = 'none';
    }
    if (frequenciaSelecionada == '3') {
        diasHorariosContainer.style.display = 'flex';
    } else {
        diasHorariosContainer.style.display = 'none';
    }
});

document.getElementById('formAula').addEventListener('submit', function(event) {
    var frequenciaSelecionada = document.getElementById('frequencia').value;

    if (frequenciaSelecionada == '1' || frequenciaSelecionada == '2') {
        // Aula única ou duas aulas
        // Não é necessário validar diasSemana e horaInicioSemana
    } else if (frequenciaSelecionada == '3') {
        // Semanalmente
        var diasHorariosContainer = document.getElementById('diasHorariosContainer');
        var diaSemana = document.getElementById('diaSemana');
        var horaInicioSemana = document.getElementById('horaInicioSemana');

        // Valida apenas se o container de diasHorarios estiver visível
        if (diasHorariosContainer.style.display == 'flex') {
            if (diaSemana.value === '' || horaInicioSemana.value === '') {
                alert('Preencha os campos Dias da Semana e Início Semana corretamente.');
                event.preventDefault(); // Impede o envio do formulário
            }
        }
    }
});

// Script para mostrar opções de quando será feito o pagamento
var metodoPagamento = document.getElementById('metodoPagamento');
var momentoPagamento = document.getElementById('momentoPagamento');
var momentoPagamentoContainer = document.getElementById('momentoPagamentoContainer');
var frequencia = document.getElementById('frequencia');

// Adiciona um evento 'change' ao elemento 'metodoPagamento'
metodoPagamento.addEventListener('change', function() {
    // Reinicie as opções do momentoPagamento
    document.querySelectorAll('#momentoPagamento option').forEach(function(option) {
        option.style.display = 'none';
    });

    // Mostra ou oculta as opções com base na escolha do método de pagamento
    if (metodoPagamento.value == 'pix' && (frequencia.value == '1' || frequencia.value == '2')) {
        document.querySelector('#momentoPagamento option[value="ao_encerrar"]').style.display = 'block';
    } else if (frequencia.value == '3') {
        document.querySelector('#momentoPagamento option[value="ao_encerrar"]').style.display = 'block';
        document.querySelector('#momentoPagamento option[value="inicio_mes"]').style.display = 'block';
        document.querySelector('#momentoPagamento option[value="final_mes"]').style.display = 'block';
    } else {
        document.querySelector('#momentoPagamento option[value="ao_encerrar"]').style.display = 'block';
    }

    // Mostra o container apenas se houver opções visíveis
    momentoPagamentoContainer.style.display = document.querySelector(
        '#momentoPagamento option:not([style="display: none;"])') ? 'block' : 'none';
});
</script>

</html>