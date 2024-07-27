<?php
    session_start();
    include '../model/crudUsuario.php';
    $id = $_GET["id"];
    $resultado = mostrarUsuarioAlterar($id);
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
    <title>Editar usuário</title>
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
            <a href="../controller/controleUsuario.php?opcao=Sair" class="btn btn-danger">Sair</a>
        </nav>
        <div class="meuContainer">
            <h1>Editar</h1>
            <form method="post" action="../controller/controleUsuario.php" id="formularioUsuario">
                <label for="nome">Nome: </label>
                <input type="text" name="nome" id="nome" value="<?=$resultado['nome']?>" required>

                <label for="email">Email: </label>
                <input type="email" name="email" id="email" value="<?=$resultado['email']?>" required>

                <label for="telefone">Telefone: </label>
                <input type="text" name="telefone" id="telefone" value="<?=$resultado['telefone']?>" required>

                <!-- Password field -->
                <label for="senha">Nova Senha: </label>
                <input type="password" name="senha" id="senha" required>
                <!-- An element to toggle between password visibility -->
                <input type="checkbox" onclick="minhaSenha()">Mostrar senha

                <input type="hidden" name="id_usuario" value="<?=$resultado['id_usuario']?>">

                <input type="hidden" name="tipo" value="<?=$resultado['tipo']?>">

                <button type="submit" name="opcao" value="Atualizar" class="btn btn-success">Salvar</button>

                <button type="button" class="btn btn-danger" onclick="confirmarExclusao()">Excluir</button>
            </form>
            <form method="post" action="../controller/controleUsuario.php" id="formExcluir" style="display: none;">
                <input type="hidden" name="id_usuario" value="<?=$resultado['id_usuario']?>">
                <input type="hidden" name="opcao" value="Excluir">
            </form>
        </div>
    </div>
</body>

<script>
function confirmarExclusao() {
    if (confirm("Tem certeza de que deseja excluir sua conta?")) {
        document.getElementById("formExcluir").submit();
    }
}

function minhaSenha() {
    var x = document.getElementById("senha");
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
}
</script>

</html>