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
    <title>Cadastrar usuário</title>
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
                    <li class="nav-item">
                        <button type="button" class="btn-mint"><a class="nav-link active" aria-current="page"
                                href="#">Cadastrar</a></button>
                    </li>
                    <li class="nav-item">
                        <button type="button" class="btn-mint"><a class="nav-link"
                                href="../view/paginaLogin.php">Acessar</a></button>
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
        </nav>
        <div class="meuContainer">
            <h1>Cadastrar Usuário</h1>
            <form method="post" action="../controller/controleUsuario.php" onsubmit="return validarSenhas()">
                <div class="mb-3">
                    <label for="nome">Nome completo: </label>
                    <input type="text" name="nome" id="nome" required>
                </div>
                <div class="mb-3">
                    <label for="email">Email: </label>
                    <input type="email" name="email" id="email" required>
                </div>
                <div class="mb-3">
                    <label for="telefone">Número de celular: </label>
                    <input type="text" name="telefone" id="telefone" required>
                </div>
                <div class="mb-3">
                    <label for="senha">Senha: </label>
                    <input type="password" name="senha" id="senha" required>
                    <!-- An element to toggle between password visibility -->
                    <input type="checkbox" onclick="minhaSenha()">Mostrar senha
                </div>
                <div class="mb-3">
                    <label for="senha">Repetir senha: </label>
                    <input type="password" name="senhaRepetida" id="senhaRepetida" required>
                    <!-- An element to toggle between password visibility -->
                    <input type="checkbox" onclick="minhaSenha2()">Mostrar senha
                </div>
                <button type="submit" name="opcao" value="Cadastrar" class="btn btn-secondary">Cadastrar Usuário</button>
            </form>
        </div>
    </div>
</body>

<script>
function validarSenhas() {
    var senha = document.getElementById("senha").value;
    var senhaRepetida = document.getElementById("senhaRepetida").value;

    if (senha !== senhaRepetida) {
        alert("As senhas não coincidem. Por favor, digite senhas iguais.");
        return false; // Impede o envio do formulário se as senhas não coincidirem
    }
    return true; // Permite o envio do formulário se as senhas coincidirem
}

function minhaSenha() {
    var x = document.getElementById("senha");
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
}

function minhaSenha2() {
    var x = document.getElementById("senhaRepetida");
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
}
</script>

</html>