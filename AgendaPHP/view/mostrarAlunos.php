<?php
    session_start();
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
    <title>Lista de Alunos</title>
</head>

<body>
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
                                href="#">Alunos</a></button>
                    </li>
                    <li class="nav-item">
                        <button type="button" class="btn-mint"><a class="nav-link"
                                href="mostrarUsuarios.php">Usuários</a></button>
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
            <h1>Alunos cadastrados</h1>
            </br>
            <div class="table-responsive-lg">
                <table class='table table-info'>
                    <thead>
                        <tr>
                            <th scope='col'>Nome</th>
                            <th scope='col'>Email</th>
                            <th scope='col'>Telefone</th>
                            <th scope="col">Status</th>
                            <th scope='col'>Deletar</th>
                        </tr>
                    </thead>
                    <?php    
                    $resultados = mostrarUsuarios();
                    foreach($resultados as $resultado){ 
                        if($resultado['tipo'] == 'aluno'){?>
                    <tr>
                        <td><?php echo $resultado['nome'] ?>
                        <td><?php echo $resultado['email'] ?>
                        <td><?php echo $resultado['telefone'] ?>
                        <td><?php echo $resultado['status'] ?>
                        <td>
                            <button type="button" class="btn btn-danger"
                                onclick="confirmarExclusao(<?=$resultado['id_usuario']?>)">Excluir</button>
                        </td>
                        <form method="post" action="../controller/controleUsuario.php" id="formExcluir"
                            style="display: none;">
                            <input type="hidden" name="id_usuario" id="id_usuario_excluir" value="">
                            <input type="hidden" name="opcao" value="DeletarUsuario">
                        </form>
                        <?php
                    }}?>
                </table>
            </div>
            </br>
        </div>
    </div>
</body>

<script>
function confirmarExclusao(idUsuario) {
    if (confirm("Tem certeza de que deseja excluir a conta?")) {
        document.getElementById("id_usuario_excluir").value = idUsuario;
        document.getElementById("formExcluir").submit();
    }
}
</script>

</html>