
CREATE DATABASE phonetrack;

USE phonetrack;

CREATE TABLE IF NOT EXISTS phonetrack.cliente (
	id INT PRIMARY KEY AUTO_INCREMENT UNIQUE NOT NULL,
	nome_completo VARCHAR(150) NOT NULL,
    data_nascimento DATE NOT NULL,
    rua VARCHAR(255),
    numero VARCHAR(10),
    cep VARCHAR(9),
    cidade VARCHAR(45),
    estado VARCHAR(45),
    telefone_fixo VARCHAR(14),
    telefone_celular VARCHAR(15),
    step INT DEFAULT 0,
    token VARCHAR(255) NOT NULL,
    status INT,
    created_at DATETIME,
    updated_at DATETIME
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;