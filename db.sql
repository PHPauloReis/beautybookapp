CREATE DATABASE IF NOT EXISTS `beautybook` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `beautybook`;

-- Copiando estrutura para tabela beautybook.manicures
CREATE TABLE IF NOT EXISTS `manicures` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `telefone` varchar(15) DEFAULT NULL,
  `especialidade` varchar(50) DEFAULT NULL,
  `data_criacao` timestamp NOT NULL DEFAULT current_timestamp(),
  `data_atualizacao` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela beautybook.manicures: ~9 rows (aproximadamente)
INSERT INTO `manicures` (`id`, `nome`, `telefone`, `especialidade`, `data_criacao`, `data_atualizacao`) VALUES
	(5, 'Vanessa Santos', '(71) 99999-8888', 'Unhas decoradas', '2026-01-19 23:15:15', '2026-01-19 23:16:42'),
	(6, 'Julia Amorin', '(71) 99999-7777', 'Cutículas', '2026-01-19 23:15:15', '2026-01-19 23:16:46'),
	(8, 'Ana Júlia', '(71) 98888-8888', 'manicure e pedicure', '2026-01-19 23:52:56', '2026-01-19 23:52:56'),
	(12, 'Ana Júlia 3', '71 98881-7772', NULL, '2026-01-20 22:57:42', '2026-01-20 22:57:42'),
	(13, 'Ana Júlia 3', '71 98881-7772', NULL, '2026-01-20 23:03:51', '2026-01-20 23:03:51'),
	(14, 'Ana Júlia 4', '71 98749-8129', NULL, '2026-01-20 23:09:50', '2026-01-20 23:09:50'),
	(16, 'Ana Júlia 5', '71 98881-7772', NULL, '2026-01-20 23:39:07', '2026-01-20 23:39:07'),
	(20, 'Ana Júlia 6', '71 98881-7772', 'manicure e pedicure', '2026-01-21 00:07:17', '2026-01-21 00:07:17'),
	(21, 'Ana Júlia 7', '71 98881-7772', 'Teste de Software', '2026-01-21 00:14:03', '2026-01-21 00:14:03');

-- Copiando estrutura para tabela beautybook.usuarios
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela beautybook.usuarios: ~1 rows (aproximadamente)
INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`) VALUES
	(1, 'Jamily', 'jamily@beautybook.app.br', '$2y$10$NVvdmegPdycCuUtTViHJHOkIy7CgE1rPu5glON2wtlmNJkU5e9dGy');
