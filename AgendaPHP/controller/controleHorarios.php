<?php
    include '../model/crudMeusHorarios.php';

    if(isset($_POST["opcao"])){
        $opcao = $_POST["opcao"];
    }
    else{
        $opcao = $_GET["opcao"];
    }

    //Arquivo de controle das funções - recebe o valor pelas páginas e envia para o crud. O valor recebido define qual query executar
    switch($opcao){
        //valor recebido para adicionar novo horário
        //na página para adicionar novo horário, será enviado com o valor "Adicionar" os dados que serão inseridos no banco
        case 'AddAulaUnica':        
            novaAulaUnica($_POST["local"], $_POST["data"], $_POST["horaInicio"], $_POST["horaFim"], $_POST["id_aula"]);
            header("Location: ../view/verMeusHorarios.php");
            break;
        case 'AddAulaFixa':
            novaAulaFixa($_POST["local"], $_POST["diaSemana"], $_POST["horaInicio"], $_POST["horaFim"], $_POST["id_usuario"]);
            header("Location: ../view/verMeusHorarios.php");
            break;
        
        case 'Atualizar':
            if($_POST["origem"] == 'fixa'){
                atualizarHorario($_POST["id_aulas_fixas"], $_POST["local"], $_POST["dia_semana"], null, $_POST["hora_inicio"], $_POST["hora_fim"], $_POST["origem"]);
            }
            else if($_POST["origem"] == 'unica'){
                atualizarHorario($_POST["id_aulas_unicas"], $_POST["local"], null, $_POST["data"], $_POST["hora_inicio"], $_POST["hora_fim"], $_POST["origem"]);
            }
            
            header("Location: ../view/verMeusHorarios.php");
            break;
        
        case 'Excluir':
            $id_aula = isset($_POST["id_aula_excluir"]) ? $_POST["id_aula_excluir"] : null;
            $origem = isset($_POST["origem"]) ? $_POST["origem"] : null;
        
            // Debug - verificar os valores das variáveis
            echo "ID Aula: " . $id_aula . "<br>";
            echo "Origem: " . $origem . "<br>";
        
            deletarHorario($id_aula, $origem);
        
            header("Location: ../view/verMeusHorarios.php");
            break;                          
    }
?>