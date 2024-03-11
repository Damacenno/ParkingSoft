-- --------------------------------------------------------
-- Servidor:                     127.0.0.1
-- Versão do servidor:           10.4.28-MariaDB - mariadb.org binary distribution
-- OS do Servidor:               Win64
-- HeidiSQL Versão:              12.5.0.6677
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Copiando estrutura do banco de dados para parkingsoft
CREATE DATABASE IF NOT EXISTS `parkingsoft` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `parkingsoft`;

-- Copiando estrutura para tabela parkingsoft.config_estacionamento
CREATE TABLE IF NOT EXISTS `config_estacionamento` (
  `id_estacionamento` int(11) NOT NULL AUTO_INCREMENT,
  `envia_sms` int(11) DEFAULT NULL,
  `tipo_cobranca` int(11) DEFAULT NULL,
  `aceita_diaria` int(11) DEFAULT NULL,
  `aceita_mensal` int(11) DEFAULT NULL,
  `aceita_pag_ant` int(11) DEFAULT NULL,
  `aceita_convenio` int(11) DEFAULT NULL,
  `preco_hora` int(11) DEFAULT NULL,
  `preco_fixo` int(11) DEFAULT NULL,
  `preco_diaria` int(11) DEFAULT NULL,
  `vinculo_convenio` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_estacionamento`),
  KEY `id_estacionamento` (`id_estacionamento`),
  CONSTRAINT `FK_configuracoes_usuarios` FOREIGN KEY (`id_estacionamento`) REFERENCES `usuarios` (`id_estac`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela parkingsoft.config_estacionamento: ~1 rows (aproximadamente)
DELETE FROM `config_estacionamento`;
INSERT INTO `config_estacionamento` (`id_estacionamento`, `envia_sms`, `tipo_cobranca`, `aceita_diaria`, `aceita_mensal`, `aceita_pag_ant`, `aceita_convenio`, `preco_hora`, `preco_fixo`, `preco_diaria`, `vinculo_convenio`) VALUES
	(1, 0, 0, 0, 0, 0, 0, 3, 4, 28, 78);

-- Copiando estrutura para tabela parkingsoft.registros
CREATE TABLE IF NOT EXISTS `registros` (
  `id_registro` int(11) NOT NULL AUTO_INCREMENT,
  `categoria` varchar(50) NOT NULL DEFAULT '0',
  `placa_auto` varchar(50) DEFAULT NULL,
  `modelo_auto` varchar(50) DEFAULT NULL,
  `vaga_auto` int(11) DEFAULT NULL,
  `entrada_auto` bigint(255) DEFAULT NULL,
  `saida_auto` bigint(255) DEFAULT NULL,
  `status_pago_auto` int(11) DEFAULT NULL,
  `id_estacionamento` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_registro`) USING BTREE,
  KEY `id_estacionamento` (`id_estacionamento`),
  CONSTRAINT `estac` FOREIGN KEY (`id_estacionamento`) REFERENCES `usuarios` (`id_estac`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=124 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela parkingsoft.registros: ~9 rows (aproximadamente)
DELETE FROM `registros`;
INSERT INTO `registros` (`id_registro`, `categoria`, `placa_auto`, `modelo_auto`, `vaga_auto`, `entrada_auto`, `saida_auto`, `status_pago_auto`, `id_estacionamento`) VALUES
	(115, 'Carro', 'ABC123', 'Ford Ka', 1, 1710178957579, 1710179081218, 1, 1),
	(116, 'Carro', 'JEA456', 'Civic', 2, 1710178964787, 1710179158874, 1, 1),
	(117, 'Moto', 'MIC853', 'Marea', 3, 1710178972091, 1710179125475, 1, 1),
	(118, 'Moto', 'ABC123', 'Civic', 3, 1710180028273, NULL, 0, 1),
	(119, 'Moto', 'JEA456', 'Eclipse', 1, 1710180065711, NULL, 0, 1),
	(120, 'Moto', 'MUE973', 'Kwid', 2, 1710180160748, NULL, 0, 1),
	(121, 'Carro', '123ABC', 'Jaguar', 1, 1710180326043, NULL, 0, 1),
	(122, 'Carro', 'MIC853', 'Jaguar', 2, 1710180411819, NULL, 0, 1),
	(123, 'Carro', 'MKJ241', 'Kwid', 4, 1710180467204, NULL, 0, 1);

-- Copiando estrutura para tabela parkingsoft.usuarios
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id_estac` int(11) NOT NULL AUTO_INCREMENT,
  `nome_estac` varchar(50) NOT NULL,
  `cnpj_estac` varchar(50) NOT NULL,
  `login_estac` varchar(50) NOT NULL,
  `senha_estac` varchar(255) NOT NULL,
  `endereco_estac` varchar(255) NOT NULL,
  `numero_contato_estac` int(11) NOT NULL,
  `email_estac` varchar(255) NOT NULL,
  `total_vagas_carro_estac` int(11) NOT NULL,
  `total_vagas_moto_estac` int(11) NOT NULL,
  `status_pago_estac` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id_estac`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Copiando dados para a tabela parkingsoft.usuarios: ~1 rows (aproximadamente)
DELETE FROM `usuarios`;
INSERT INTO `usuarios` (`id_estac`, `nome_estac`, `cnpj_estac`, `login_estac`, `senha_estac`, `endereco_estac`, `numero_contato_estac`, `email_estac`, `total_vagas_carro_estac`, `total_vagas_moto_estac`, `status_pago_estac`) VALUES
	(1, 'Joao Estacionamentos', '11111111000111', 'admin', '$2y$10$Zn9VYWg3BnbeOb9OcbDhxuE4gA0yXFErtWNr0p1YI95BzOYatWKcC', 'Rua do Ka Sete', 1169696969, 'estacionei@gmail.com', 5, 10, 0);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
