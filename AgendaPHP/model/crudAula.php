<?php
include_once 'conexaoDB.php';

// Função para verificar conflitos e inserir nova aula
function agendarAula($idUsuario, $materia, $tipoAula, $descricao, $data, $horaInicio, $horaFim, $metodoPagamento, $momentoPagamento, $frequencia) {
    $conexao = connect();

    // Iniciar transação
    queryComConexao($conexao, "START TRANSACTION");

    // Verificar conflitos
    if (!verificarConflitoHorario($conexao, $data, $horaInicio, $horaFim, $frequencia)) {
        // Inserir na tabela aula e obter o ID
        $idAula = inserirAula($conexao, $idUsuario, $materia, $tipoAula, $descricao, $data, $horaInicio, $horaFim, $metodoPagamento, $momentoPagamento, $frequencia);

        // Inserir na tabela requisição
        $idRequisicao = inserirRequisicao($idAula);

        // Commit da transação se não houver erros
        queryComConexao($conexao, "COMMIT");

        // Retornar sucesso ou mensagem de sucesso
        return "Aula agendada com sucesso!";
    } else {
        // Rollback se houver conflitos
        queryComConexao($conexao, "ROLLBACK");

        // Retornar mensagem de erro
        return "Erro";
    }

    close($conexao);
}

// Função para verificar conflitos de horário
function verificarConflitoHorario($conexao, $data, $horaInicio, $horaFim, $frequencia) {
    // Converter $data para formato de data no banco de dados (YYYY-MM-DD)
    $dataFormatada = date('Y-m-d', strtotime($data));

    // Buscar no banco todos os valores que têm horário de início ou término coincidindo com o horário que deseja-se inserir
    $consultaHorariosFixos = query("SELECT * FROM aulas_fixas WHERE dia_semana = '$data' AND hora_inicio < '$horaFim' AND hora_fim > '$horaInicio'");
    $consultaHorariosUnicos = query("SELECT * FROM aulas_unicas WHERE data = '$dataFormatada' AND hora_inicio < '$horaFim' AND hora_fim > '$horaInicio'");

    while ($aulaUnica = mysqli_fetch_assoc($consultaHorariosUnicos)) {
        // Conflito encontrado para aula única
        return true;
    }

    while ($aulaFixa = mysqli_fetch_assoc($consultaHorariosFixos)) {
        // Conflito encontrado para aula fixa
        return true;
    }

    if ($frequencia == 'unica') {
        // Verificar conflito com aulas fixas
        $diaSemana = date('w', strtotime($data));
        $diaSemanaNomes = [
            0 => 'domingo',
            1 => 'segunda',
            2 => 'terça',
            3 => 'quarta',
            4 => 'quinta',
            5 => 'sexta',
            6 => 'sábado'
        ];
        $diaSemana = isset($diaSemanaNomes[$diaSemana]) ? $diaSemanaNomes[$diaSemana] : 'desconhecido';        
        $consultaFixas = query("SELECT * FROM aulas_fixas WHERE dia_semana = '$diaSemana' AND hora_inicio < '$horaFim' AND hora_fim > '$horaInicio'");

        while ($aulaFixa = mysqli_fetch_assoc($consultaFixas)) {
            // Conflito encontrado para aula fixa
            return true;
        }
    } elseif ($frequencia == 'fixa') {
        // Verificar conflito com aulas únicas
        $consultaUnicas = query("SELECT * FROM aulas_unicas WHERE hora_inicio < '$horaFim' AND hora_fim > '$horaInicio'");

        while ($aulaUnica = mysqli_fetch_assoc($consultaUnicas)) {
            // Converter as datas das aulas únicas para dias da semana
            $diaSemanaAulaUnica = date('w', strtotime($aulaUnica['data']));

            $diaSemanaNomes = [
                0 => 'domingo',
                1 => 'segunda',
                2 => 'terça',
                3 => 'quarta',
                4 => 'quinta',
                5 => 'sexta',
                6 => 'sábado'
            ];
            $diaSemanaAulaUnica = isset($diaSemanaNomes[$diaSemanaAulaUnica]) ? $diaSemanaNomes[$diaSemanaAulaUnica] : 'desconhecido';  

            // Verificar se há sobreposição de horários
            if ($diaSemanaAulaUnica == $data) {
                return true;
            }
        }
    }

    return false; // Não há conflito
}

// Função para inserir na tabela aula
function inserirAula($conexao, $idUsuario, $materia, $tipoAula, $descricao, $data, $horaInicio, $horaFim, $metodoPagamento, $momentoPagamento, $frequencia) {
    queryComConexao($conexao, "INSERT INTO aula (id_usuario, materia, tipo_aula, descricao, data_aula, horario_inicio, horario_fim, metodo_pagamento,
                                momento_pagamento, frequencia)
        VALUES ('$idUsuario', '$materia', '$tipoAula', '$descricao', '$data', '$horaInicio', '$horaFim', '$metodoPagamento',
                        '$momentoPagamento', '$frequencia')");

    // Obter o ID da última aula inserida
    $idAula = mysqli_insert_id($conexao);

    return $idAula;
}

// Função para inserir na tabela requisicao
function inserirRequisicao($idAula) {
    global $conexao;  // Certifique-se de ter a conexão disponível globalmente

    query("INSERT INTO requisicao (id_aula, status) VALUES ('$idAula', 'pendente')");

    // Obter o ID da última requisição inserida
    $idRequisicao = mysqli_insert_id($conexao);

    return $idRequisicao;
}

function mostrarAgendamentos($idUsuario){
    connect();

    $consulta = query("SELECT aula.*, requisicao.* 
                      FROM aula 
                      LEFT JOIN requisicao ON aula.id_aula = requisicao.id_aula 
                      WHERE aula.id_usuario = $idUsuario");

    close();

    $resultados = [];
    if(mysqli_num_rows($consulta) > 0){
        while($resultadoSeparado = mysqli_fetch_assoc($consulta)){
            $resultados[] = $resultadoSeparado;
        }
    }
    return $resultados;
}

function mostrarAgendamentoAlterar($id){
    connect();

    $consulta = query("SELECT * FROM aula WHERE id_aula = $id");
    if (mysqli_num_rows($consulta) > 0) {
        close();
        $resultado = mysqli_fetch_assoc($consulta);
        return $resultado;
    }

    close();
    return 'sem resultados';
}

function buscarUsuario($id_usuario){
    connect();

    $consultaNome = query("SELECT usuario.nome FROM usuario INNER JOIN aula ON usuario.id_usuario = aula.id_usuario
                            WHERE aula.id_usuario = $id_usuario");

    if (mysqli_num_rows($consultaNome) > 0) {
        $resultado = mysqli_fetch_assoc($consultaNome);
        close();
        return $resultado['nome'];
    }

    close();
}

function atualizarAgendamento($idAula, $materia, $tipoAula, $descricao, $data, $horaInicio, $horaFim, $metodoPagamento, $momentoPagamento, $frequencia){
    $conexao = connect();

    // Verificar conflito de horário antes de atualizar
    if (verificarConflitoHorario($conexao, $data, $horaInicio, $horaFim, $frequencia)) {
        close();
        return "Erro";
    }

    query("UPDATE aula SET materia = '$materia', tipo_aula = '$tipoAula', descricao = '$descricao', data_aula = '$data', 
            horario_inicio = '$horaInicio', horario_fim = '$horaFim', metodo_pagamento = '$metodoPagamento', 
            momento_pagamento = '$momentoPagamento', frequencia = '$frequencia' WHERE id_aula = $idAula");

    query("UPDATE requisicao SET status = 'pendente' WHERE id_aula = $idAula");

    close();
}

// Função para excluir agendamento
function excluirAgendamento($idAgendamento) {
    $conexao = connect();

    // Iniciar transação
    queryComConexao($conexao, "START TRANSACTION");

    query("DELETE FROM requisicao WHERE id_aula = '$idAgendamento'");

    // Excluir agendamento
    queryComConexao($conexao, "DELETE FROM aula WHERE id_aula = '$idAgendamento'");
    // Outras tabelas relacionadas também podem precisar de exclusão

    // Commit da transação se não houver erros
    queryComConexao($conexao, "COMMIT");

    // Retornar sucesso ou mensagem de sucesso
    return "Agendamento excluído com sucesso!";
}

function mostrarRequisicoes(){
    connect();

    $consulta = query("SELECT aula.data_aula, aula.horario_inicio, aula.horario_fim, aula.frequencia, requisicao.* 
                        FROM aula 
                        LEFT JOIN requisicao ON aula.id_aula = requisicao.id_aula 
                        WHERE status = 'pendente'");

    close();

    $resultados = [];
    if(mysqli_num_rows($consulta) > 0){
        while($resultadoSeparado = mysqli_fetch_assoc($consulta)){
            $resultados[] = $resultadoSeparado;
        }
    }
    return $resultados;
}

function mostrarRequisicoesAlterar($id){
    connect();

    $consulta = query("SELECT * FROM requisicao WHERE id_requisicao = $id");
    if (mysqli_num_rows($consulta) > 0) {
        close();
        $resultado = mysqli_fetch_assoc($consulta);
        return $resultado;
    }

    close();
    return 'sem resultados';
}

function buscarAula($idRequisicao){
    connect();

    $consulta = query("SELECT aula.* FROM aula INNER JOIN requisicao ON requisicao.id_aula = aula.id_aula
                        WHERE requisicao.id_requisicao = $idRequisicao");
    if (mysqli_num_rows($consulta) > 0) {
        close();
        $resultado = mysqli_fetch_assoc($consulta);
        return $resultado;
    }    

    close();
    return 'sem resultados';
}

function atualizarRequisicao($idRequisicao, $status, $frequencia){
    connect();

    // Verificar conflito de horário antes de atualizar    
    if($status == 'aceito'){
        $aula = buscarAula($idRequisicao);
        if (verificarConflitoHorario(connect(), $aula['data_aula'], $aula['horario_inicio'], $aula['horario_fim'], $frequencia)) {
            return "Erro";
        }
        include '../model/crudMeusHorarios.php';
        if($frequencia == 'unica'){
            novaAulaUnica($aula['tipo_aula'], $aula['data_aula'], $aula['horario_inicio'], $aula['horario_fim'], $aula['id_aula']);
        }
        else if($frequencia == 'fixa'){
            novaAulaFixa($aula['tipo_aula'], $aula['data_aula'], $aula['horario_inicio'], $aula['horario_fim'], $aula['id_usuario']);
        }
    }

    connect();

    query("UPDATE requisicao SET status = '$status' WHERE id_requisicao = $idRequisicao");

    close();
}

function deletarRequisicao($idRequisicao){
    connect();

    query("DELETE FROM requisicao WHERE id_requisicao = $idRequisicao");

    close();
}
?>