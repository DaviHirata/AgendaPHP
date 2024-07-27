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
    <title>Editar horário</title>
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
            <h1>Editar</h1>
            <?php
                include '../model/crudMeusHorarios.php';
                $id = $_GET["id"];
                $origem = $_GET["origem"];
                $resultado = mostrarHorarioAlterar($id, $origem);
            ?>
            <form method="post" action="../controller/controleHorarios.php" id="formularioHorario">
                <label for="local">Local: </label>
                <input type="text" name="local" id="local" value="<?=$resultado['local']?>" required>

                <?php
                    if($resultado['origem'] == 'fixa'){
                        echo "<label for='dia_semana'>Dia da Semana: </label>";
                        echo "<input type='dia_semana' name='dia_semana' id='dia_semana' value='" . $resultado['dia_semana'] . "' required>";
                        }
                    else if($resultado['origem'] == 'unica'){
                        echo "<label for='data'>Data: </label>";
                        echo "<input type='data' name='data' id='data' value='" . $resultado['data'] . "' required>";
                    }
                ?>

                <label for="hora_inicio">Início da aula: </label>
                <input type="hora_inicio" name="hora_inicio" id="hora_inicio" value="<?=$resultado['hora_inicio']?>" required>

                <label for="hora_fim">Fim da aula: </label>
                <input type="hora_fim" name="hora_fim" id="hora_fim" value="<?=$resultado['hora_fim']?>" required>

                <input type="hidden" name="origem" value="<?=$resultado['origem']?>">

                <?php
                    if($resultado['origem'] == 'fixa'){
                        echo "<input type='hidden' name='id_aulas_fixas' value='" . $resultado['id_aulas_fixas'] . "'>";
                        }
                    else if($resultado['origem'] == 'unica'){
                        echo "<input type='hidden' name='id_aulas_unicas' value='" . $resultado['id_aulas_unicas'] . "'>";
                    }
                ?>
                <button type="submit" name="opcao" value="Atualizar" class="btn btn-success">Salvar</button>
                <button type="button" class="btn btn-danger" onclick="confirmarExclusao()">Excluir</button>
            </form>
            <form method="post" action="../controller/controleHorarios.php" id="formExcluir" style="display: none;">
                <?php
                    if($resultado['origem'] == 'fixa'){
                        echo "<input type='hidden' name='id_aula_excluir' value='{$resultado['id_aulas_fixas']}'>";
                        echo "<input type='hidden' name='origem' value='{$resultado['origem']}'>";
                    }
                    else if($resultado['origem'] == 'unica'){
                        echo "<input type='hidden' name='id_aula_excluir' value='{$resultado['id_aulas_unicas']}'>";
                        echo "<input type='hidden' name='origem' value='{$resultado['origem']}'>";
                    }
                ?>
                <input type="hidden" name="opcao" value="Excluir">
            </form>
        </div>
    </div>
</body>

<script>
    function confirmarExclusao() {
        var confirmacao = confirm("Tem certeza que deseja excluir?");

        if (confirmacao) {
            document.getElementById("formExcluir").submit();
        }
    }
</script>

</html>