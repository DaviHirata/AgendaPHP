<?php
    include_once 'conexaoDB.php';

    //Insere novo horário ocupado no banco de dados 
    function novaAulaUnica($local, $data, $hora_inicio, $hora_fim, $id_aula){ 
        connect();
        query("INSERT INTO aulas_unicas (id_aula, local, data, hora_inicio, hora_fim, origem)
            VALUES ('$id_aula', '$local', '$data', '$hora_inicio', '$hora_fim', 'unica')");
        close();
    }

    //Insere novo horário ocupado no banco de dados 
    function novaAulaFixa($local, $diaSemana, $hora_inicio, $hora_fim, $id_usuario){ 
        connect();
        query("INSERT INTO aulas_fixas (id_usuario, local, dia_semana, hora_inicio, hora_fim, origem)
            VALUES ('$id_usuario', '$local', '$diaSemana', '$hora_inicio', '$hora_fim', 'fixa')");
        close();
    }

    //Mostra todos os horários ocupados na base de dados
    function mostrarHorarios(){
        connect();
        $consulta = query("SELECT * FROM aulas_fixas UNION SELECT id_aulas_unicas,
        id_aula, local, DATE_FORMAT(data, '%d-%m-%Y') AS data_formatada, hora_inicio, hora_fim, origem FROM aulas_unicas");
        close();

        $resultados = [];
        if(mysqli_num_rows($consulta) > 0){
            while($resultadoSeparado = mysqli_fetch_assoc($consulta)){
                $resultados[] = $resultadoSeparado;
            }
        }
        return $resultados;
    }

    function buscarNomeUsuario($id) {
        connect();
    
        // Consulta para buscar nome do usuário em aula_fixa
        $consultaAulaFixa = query("SELECT nome FROM usuario WHERE id_usuario = '$id'");
    
        if (mysqli_num_rows($consultaAulaFixa) > 0) {
            $resultadoAulaFixa = mysqli_fetch_assoc($consultaAulaFixa);
            close();
            return $resultadoAulaFixa['nome'];
        }
    
        // Consulta para buscar nome do usuário em aula_unica usando JOIN
        $consultaAulaUnica = query("SELECT usuario.nome
                                    FROM usuario
                                    INNER JOIN aula ON usuario.id_usuario = aula.id_usuario
                                    INNER JOIN aulas_unicas ON aulas_unicas.id_aula = aula.id_aula
                                    WHERE aulas_unicas.id_aula = '$id'");
    
        if (mysqli_num_rows($consultaAulaUnica) > 0) {
            $resultadoAulaUnica = mysqli_fetch_assoc($consultaAulaUnica);
            close();
            return $resultadoAulaUnica['nome'];
        }
    
        close();
        return 'Usuário não encontrado';
    }    

    //Procura as informações do horário que será alterado pelo id enviado
    function mostrarHorarioAlterar($id, $origem){
        connect();
        $consultaAulaFixa = query("SELECT * FROM aulas_fixas WHERE id_aulas_fixas = $id and origem = '$origem'");
        if (mysqli_num_rows($consultaAulaFixa) > 0) {
            close();
            $resultadoAulaFixa = mysqli_fetch_assoc($consultaAulaFixa);
            return $resultadoAulaFixa;
        }

        $consultaAulaUnica = query("SELECT * FROM aulas_unicas WHERE id_aulas_unicas = $id and origem = '$origem'");
        if (mysqli_num_rows($consultaAulaUnica) > 0) {
            close();
            $resultadoAulaUnica = mysqli_fetch_assoc($consultaAulaUnica);
            return $resultadoAulaUnica;
        }

        close();
        return 'sem resultados';
    }

    //Envia para o banco as novas informações do horário, após a edição
    function atualizarHorario($id, $local, $dia_semana, $data, $hora_inicio, $hora_fim, $origem){
        connect();

        if($origem == 'fixa'){
            query("UPDATE aulas_fixas SET local = '$local', dia_semana = '$dia_semana', hora_inicio = '$hora_inicio', hora_fim = '$hora_fim' WHERE id_aulas_fixas = $id");
        }
        else if($origem == 'unica'){
            query("UPDATE aulas_unicas SET local = '$local', data = '$data', hora_inicio = '$hora_inicio', hora_fim = '$hora_fim' WHERE id_aulas_unicas = $id");
        }

        close();
    }

    // Deleta um horário pelo id selecionado
    function deletarHorario($id, $origem){
        connect();
        if ($origem == 'fixa') {
            query("DELETE FROM aulas_fixas WHERE id_aulas_fixas = $id");
        } else if ($origem == 'unica') {
            query("DELETE FROM aulas_unicas WHERE id_aulas_unicas = $id");
        }
        close();
    }

    //Função para verificar se já existe horário marcado que pode coincidir
    function horarioMarcado($data, $horaInicio, $horaFim) {
        $banco = buscarHorario($data, $horaInicio, $horaFim);
        return $banco !== false;
    }

    // Função para buscar horário
    function buscarHorario($data, $horaInicio, $horaFim) {
        connect();

        // Use a consulta parametrizada para evitar SQL injection
        $consulta = query("SELECT * FROM meus_horarios WHERE data = ? AND ((hora_inicio <= ? AND hora_fim >= ?) OR (hora_inicio <= ? AND hora_fim >= ?))");
        mysqli_stmt_bind_param($consulta, "sssss", $data, $horaInicio, $horaInicio, $horaFim, $horaFim);
        mysqli_stmt_execute($consulta);

        $resultado = mysqli_stmt_get_result($consulta);

        if (mysqli_num_rows($resultado) > 0) {
            $resultadoSeparado = mysqli_fetch_assoc($resultado);
            close();
            return $resultadoSeparado;
        } else {
            close();
            return false;
        }
    }
?>