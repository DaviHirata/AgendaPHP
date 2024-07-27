-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 26/07/2024 às 16:01
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `agenda`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `aula`
--

CREATE TABLE `aula` (
  `id_aula` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `materia` varchar(255) NOT NULL,
  `tipo_aula` varchar(20) NOT NULL,
  `descricao` text NOT NULL,
  `data_aula` varchar(20) NOT NULL,
  `horario_inicio` time NOT NULL,
  `horario_fim` time NOT NULL,
  `metodo_pagamento` enum('pix','dinheiro') DEFAULT NULL,
  `momento_pagamento` enum('ao_encerrar','final_mes','inicio_mes') DEFAULT 'ao_encerrar',
  `frequencia` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `aula`
--

INSERT INTO `aula` (`id_aula`, `id_usuario`, `materia`, `tipo_aula`, `descricao`, `data_aula`, `horario_inicio`, `horario_fim`, `metodo_pagamento`, `momento_pagamento`, `frequencia`) VALUES
(25, 6, 'ingles', 'presencial', 'To be verb', '2024-03-21', '07:39:00', '08:39:00', 'pix', 'ao_encerrar', 'unica'),
(27, 8, 'matematica', 'ead', 'afaffsaf', '2024-03-21', '09:00:00', '11:00:00', 'pix', 'ao_encerrar', 'unica'),
(29, 12, 'matematica', 'ead', 'funções', '2024-05-16', '20:00:00', '22:00:00', 'dinheiro', 'ao_encerrar', 'unica'),
(30, 12, 'ingles', 'ead', 'nome de coisas', '2024-09-13', '14:00:00', '15:00:00', 'pix', 'final_mes', 'unica');

-- --------------------------------------------------------

--
-- Estrutura para tabela `aulas_fixas`
--

CREATE TABLE `aulas_fixas` (
  `id_aulas_fixas` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `local` varchar(20) NOT NULL,
  `dia_semana` varchar(20) NOT NULL,
  `hora_inicio` time NOT NULL,
  `hora_fim` time NOT NULL,
  `origem` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `aulas_unicas`
--

CREATE TABLE `aulas_unicas` (
  `id_aulas_unicas` int(11) NOT NULL,
  `id_aula` int(11) DEFAULT NULL,
  `local` varchar(20) NOT NULL,
  `data` date NOT NULL,
  `hora_inicio` time NOT NULL,
  `hora_fim` time NOT NULL,
  `origem` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `aulas_unicas`
--

INSERT INTO `aulas_unicas` (`id_aulas_unicas`, `id_aula`, `local`, `data`, `hora_inicio`, `hora_fim`, `origem`) VALUES
(8, 25, 'presencial', '2024-03-21', '07:39:00', '08:39:00', 'unica');

-- --------------------------------------------------------

--
-- Estrutura para tabela `dividas`
--

CREATE TABLE `dividas` (
  `id_divida` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_aula` int(11) NOT NULL,
  `valor_devido` decimal(10,2) DEFAULT NULL,
  `status_pagamento` enum('pendente','pago') DEFAULT 'pendente',
  `data_vencimento` date DEFAULT NULL,
  `metodo_pagamento` enum('ao_encerrar','final_mes','inicio_mes') DEFAULT 'ao_encerrar'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `requisicao`
--

CREATE TABLE `requisicao` (
  `id_requisicao` int(11) NOT NULL,
  `id_aula` int(11) NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `requisicao`
--

INSERT INTO `requisicao` (`id_requisicao`, `id_aula`, `status`) VALUES
(25, 25, 'aceito'),
(26, 27, 'pendente'),
(28, 30, 'pendente');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telefone` varchar(11) NOT NULL,
  `tipo` enum('desenvolvedor','professor','aluno') DEFAULT 'aluno',
  `senha` varchar(255) NOT NULL,
  `status` varchar(11) NOT NULL DEFAULT 'ativo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nome`, `email`, `telefone`, `tipo`, `senha`, `status`) VALUES
(5, 'Murilo Hirata', '14muriloh.delima@gmail.com', '55559997828', 'aluno', 'c682957acf3186f1cf12ccc9546d02d3bbf670ac', 'ativo'),
(6, 'Marcus', 'mvaglima@gmail.com', '55996603327', 'aluno', '62f68e0e6d8a4d2c3d00281e20662ec418b410d2', 'ativo'),
(7, 'Janaina', 'jota.hirata@gmail.com', '55996905935', 'professor', '59ec641fc80bb8823744283f7bb93ce9949286bb', 'ativo'),
(8, 'miguel', 'miguel@123', '123123123', 'aluno', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'ativo'),
(10, 'teste', 'jota@gmail', '2342345234', 'professor', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'ativo'),
(11, 'Janaina', 'jota@123', 'fsdfsfdf', 'professor', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'ativo'),
(12, 'Carlos', 'carlos@gmail.com', '12312312321', 'aluno', '$2y$10$7ngVXh.7syVzcfLQUIu/0uvZMX5naULGmB7azJ6AvL8Lv3gKxcKQ6', 'ativo'),
(13, 'Davi Hirata', 'davi@gmail', '1111111', 'aluno', '$2y$10$blFmJcf.SHo3it6ZlwBEduhqyOAG16YI.pAiuRDaO.OyDKtAfW1Am', ''),
(14, 'Davi', 'davi@email.com', '1231231223', 'aluno', '$2y$10$oAT9KHoUBbWu3qaXeFx5X.7HNao6haImCN.p8qbTgnr5o/VBLRBk2', 'ativo');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `aula`
--
ALTER TABLE `aula`
  ADD PRIMARY KEY (`id_aula`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Índices de tabela `aulas_fixas`
--
ALTER TABLE `aulas_fixas`
  ADD PRIMARY KEY (`id_aulas_fixas`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Índices de tabela `aulas_unicas`
--
ALTER TABLE `aulas_unicas`
  ADD PRIMARY KEY (`id_aulas_unicas`),
  ADD KEY `id_aula` (`id_aula`);

--
-- Índices de tabela `dividas`
--
ALTER TABLE `dividas`
  ADD PRIMARY KEY (`id_divida`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_aula` (`id_aula`);

--
-- Índices de tabela `requisicao`
--
ALTER TABLE `requisicao`
  ADD PRIMARY KEY (`id_requisicao`),
  ADD KEY `id_aula` (`id_aula`);

--
-- Índices de tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `aula`
--
ALTER TABLE `aula`
  MODIFY `id_aula` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de tabela `aulas_fixas`
--
ALTER TABLE `aulas_fixas`
  MODIFY `id_aulas_fixas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `aulas_unicas`
--
ALTER TABLE `aulas_unicas`
  MODIFY `id_aulas_unicas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `dividas`
--
ALTER TABLE `dividas`
  MODIFY `id_divida` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `requisicao`
--
ALTER TABLE `requisicao`
  MODIFY `id_requisicao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `aula`
--
ALTER TABLE `aula`
  ADD CONSTRAINT `aula_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Restrições para tabelas `aulas_fixas`
--
ALTER TABLE `aulas_fixas`
  ADD CONSTRAINT `aulas_fixas_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Restrições para tabelas `aulas_unicas`
--
ALTER TABLE `aulas_unicas`
  ADD CONSTRAINT `aulas_unicas_ibfk_1` FOREIGN KEY (`id_aula`) REFERENCES `aula` (`id_aula`);

--
-- Restrições para tabelas `dividas`
--
ALTER TABLE `dividas`
  ADD CONSTRAINT `dividas_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`),
  ADD CONSTRAINT `dividas_ibfk_2` FOREIGN KEY (`id_aula`) REFERENCES `aula` (`id_aula`);

--
-- Restrições para tabelas `requisicao`
--
ALTER TABLE `requisicao`
  ADD CONSTRAINT `requisicao_ibfk_1` FOREIGN KEY (`id_aula`) REFERENCES `aula` (`id_aula`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
