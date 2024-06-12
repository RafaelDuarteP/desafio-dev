CREATE DATABASE IF NOT EXISTS `desafio_dev_mysql`;

USE `desafio_dev_mysql`;

CREATE TABLE IF NOT EXISTS `cidadao`(
    `nis` VARCHAR(11) PRIMARY KEY,
    `nome` VARCHAR(100) NOT NULL,
);

