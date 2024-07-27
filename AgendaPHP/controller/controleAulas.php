<?php
include '../model/crudAula.php';
session_start();

if (isset($_POST["opcao"])) {
    $opcao = $_POST["opcao"];
} else {
    $opcao = $_GET["opcao"];
}

// Arquivo de controle das funções - recebe o valor pelas páginas e envia para o CRUD. O valor recebido define qual query executar
switch ($opcao) {
    case 'Agendar':
        $idUsuario = $_POST["id_usuario"];
        $materia = $_POST["materia"];
        $tipoAula = $_POST["tipoAula"];
        $descricao = $_POST["descricao"];
        $frequencia = $_POST["frequencia"];
        $metodoPagamento = $_POST["metodoPagamento"];
        $momentoPagamento = $_POST["momentoPagamento"];

        // Verifica o tipo de aula escolhido
        if ($frequencia == '1' || $frequencia == '2') {
            $data = $_POST["dataUnica"];
            $horaInicio = $_POST["horaInicioUnica"];
        } elseif ($frequencia == '3') {
            $data = $_POST["diaSemana"];
            $horaInicio = $_POST["horaInicioSemana"];
        }

        // Define o horário de término com base na frequência
        if ($frequencia == '1') {
            // Aula única, adiciona 1 hora ao horário de início
            $horaFim = date('H:i', strtotime($horaInicio . '+1 hour'));
            // Transforma para 'única' antes de chamar a função do CRUD
            $frequencia = 'unica';
        } elseif ($frequencia == '2') {
            // Duas aulas em sequência, adiciona 2 horas ao horário de início
            $horaFim = date('H:i', strtotime($horaInicio . '+2 hours'));
            // Transforma para 'única' antes de chamar a função do CRUD
            $frequencia = 'unica';
        } else {
            // Para frequência '3' (semanalmente), não precisa definir horário de término aqui
            $horaFim = date('H:i', strtotime($horaInicio . '+1 hour'));
            $frequencia = 'fixa';
        }

        // Chama a função do CRUD para agendar a aula
        $resultado = agendarAula($idUsuario, $materia, $tipoAula, $descricao, $data, $horaInicio, $horaFim, $metodoPagamento, $momentoPagamento, $frequencia);

        // Lida com o resultado
        if ($resultado == "Erro") {
            $_SESSION['dados_formulario'] = $_POST;
            echo "<script>alert('O dia ou horário escolhido já está ocupado. Altere o agendamento.');</script>";
            echo "<script>window.location='../view/agendarAula.php';</script>";
            exit(); // Importante para evitar mais saídas
        } else {
            echo "<script>alert('Requisição de aula feita com sucesso!');</script>";
            echo "<script>window.location='../view/paginaPrincipal.php';</script>";
            exit(); // Importante para evitar mais saídas
        }

    case 'Atualizar':
        $idAula = $_POST["id_aula"];
        $materia = $_POST["materia"];
        $tipoAula = $_POST["tipoAula"];
        $descricao = $_POST["descricao"];
        $frequencia = $_POST["frequencia"];
        $metodoPagamento = $_POST["metodoPagamento"];
        $momentoPagamento = $_POST["momentoPagamento"];

        // Verifique o tipo de aula escolhido
        if ($frequencia == '1' || $frequencia == '2') {
            $data = $_POST["dataUnica"];
            $horaInicio = $_POST["horaInicioUnica"];
        } elseif ($frequencia == '3') {
            $data = $_POST["diaSemana"];
            $horaInicio = $_POST["horaInicioSemana"];
        }

        // Defina o horário de término com base na frequência
        if ($frequencia == '1') {
            // Aula única, adicione 1 hora ao horário de início
            $horaFim = date('H:i', strtotime($horaInicio . '+1 hour'));
            // Transforme para 'única' antes de chamar a função do CRUD
            $frequencia = 'unica';
        } elseif ($frequencia == '2') {
            // Duas aulas em sequência, adicione 2 horas ao horário de início
            $horaFim = date('H:i', strtotime($horaInicio . '+2 hours'));
            // Transforme para 'única' antes de chamar a função do CRUD
            $frequencia = 'unica';
        } else {
            // Para frequência '3' (semanalmente), não precisa definir horário de término aqui
            $horaFim = date('H:i', strtotime($horaInicio . '+1 hour'));
            $frequencia = 'fixa';
        }

        // Chame a função do CRUD para atualizar o agendamento
        $resultado = atualizarAgendamento($idAula, $materia, $tipoAula, $descricao, $data, $horaInicio, $horaFim, $metodoPagamento, $momentoPagamento, $frequencia);

        // Lida com o resultado
        if ($resultado == "Erro") {
            echo "<script>alert('O dia ou horário escolhido já está ocupado. Escolha outro horário.');</script>";
            echo "<script>window.location='../view/verAgendamentos.php';</script>";
            exit(); // Importante para evitar mais saídas
        } else {
            echo "<script>alert('Requisição de aula feita com sucesso!');</script>";
            echo "<script>window.location='../view/verAgendamentos.php';</script>";
            exit(); // Importante para evitar mais saídas
        }
        break;

    case 'ExcluirAgendamento':
        $idAgendamentoExcluir = $_POST["id_agendamento_excluir"];
        $resultado = excluirAgendamento($idAgendamentoExcluir);
    
        // Lida com o resultado
        if ($resultado == "Agendamento excluído com sucesso!") {
            $_SESSION['msg'] = "Agendamento excluído com sucesso!";
            header("Location: ../view/paginaPrincipal.php");
            exit(); // Importante para evitar mais saídas
        } else {
            $_SESSION['msg'] = "O agendamento não pôde ser excluído!";
            header("Location: ../view/paginaPrincipal.php");
            exit(); // Importante para evitar mais saídas
        }
        break;

    case 'AtualizarRequisicao':
        $idRequisicao = $_POST["id_requisicao"];
        $status = $_POST["status"];
        $frequencia = $_POST["frequencia"];

        $resultado = atualizarRequisicao($idRequisicao, $status, $frequencia);

        // Lida com o resultado
        if ($resultado == "Erro") {
            echo "<script>alert('O dia ou horário escolhido já está ocupado. Recuse a aula.');</script>";
            echo "<script>window.location='../view/verRequisicoes.php';</script>";
            exit(); // Importante para evitar mais saídas
        } else {
            echo "<script>window.location='../view/verRequisicoes.php';</script>";
            exit(); // Importante para evitar mais saídas
        }
        break;
}
?>