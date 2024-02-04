CREATE DATABASE IF NOT EXISTS `db_vendas` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `db_vendas`;

-- Table structure for table `clientes`
CREATE TABLE IF NOT EXISTS `clientes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `cpf` varchar(11) NOT NULL,
  `endereco` varchar(255) NOT NULL,
  `cep` varchar(8) NOT NULL,
  `email` varchar(255) NOT NULL,
  `status` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Table structure for table `formas_pagamento`
CREATE TABLE IF NOT EXISTS `formas_pagamento` (
  `id` int NOT NULL AUTO_INCREMENT,
  `descricao` varchar(255) NOT NULL,
  `qtd_parcelas` int NOT NULL,
  `status` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Table structure for table `produtos`
CREATE TABLE IF NOT EXISTS `produtos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `descricao` varchar(255) NOT NULL,
  `quantidade` decimal(14,2) NOT NULL,
  `valor` decimal(14,2) NOT NULL,
  `status` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Table structure for table `usuarios`
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `login` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `login_UNIQUE` (`login`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Table structure for table `tokens_autorizados`
CREATE TABLE IF NOT EXISTS `tokens_autorizados` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_cad_usuarios` int NOT NULL,
  `token` varchar(150) NOT NULL,
  `status` enum('S','N') NOT NULL,
  `created_at` datetime NOT NULL,
  `expired_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `token_UNIQUE` (`token`),
  KEY `fk_tokens_autorizados_1_idx` (`id_cad_usuarios`),
  CONSTRAINT `fk_tokens_autorizados_1` FOREIGN KEY (`id_cad_usuarios`) REFERENCES `usuarios` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Table structure for table `vendas`
CREATE TABLE IF NOT EXISTS `vendas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_cad_clientes` int NOT NULL,
  `id_cad_forma_pagamento` int NOT NULL,
  `qtd_parcelas` int NOT NULL,
  `data_lancamento` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_vendas_1_idx` (`id_cad_clientes`),
  KEY `fk_vendas_2_idx` (`id_cad_forma_pagamento`),
  CONSTRAINT `fk_vendas_1` FOREIGN KEY (`id_cad_clientes`) REFERENCES `clientes` (`id`),
  CONSTRAINT `fk_vendas_2` FOREIGN KEY (`id_cad_forma_pagamento`) REFERENCES `formas_pagamento` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Table structure for table `vendas_produtos`
CREATE TABLE IF NOT EXISTS `vendas_produtos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_cad_vendas` int NOT NULL,
  `id_cad_produto` int NOT NULL,
  `qtd_vendida` decimal(14,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_vendas_produtos_1_idx` (`id_cad_produto`),
  KEY `fk_vendas_produtos_2_idx` (`id_cad_vendas`),
  CONSTRAINT `fk_vendas_produtos_1` FOREIGN KEY (`id_cad_produto`) REFERENCES `produtos` (`id`),
  CONSTRAINT `fk_vendas_produtos_2` FOREIGN KEY (`id_cad_vendas`) REFERENCES `vendas` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
