CREATE DATABASE central_ppi;

CREATE TABLE empresa (
    id_empresa int(11) NOT NULL AUTO_INCREMENT,
    nome varchar(255) NOT NULL,
    CNPJ varchar(18) NOT NULL,
    DDD int(3) NOT NULL,
    num_municipal int(11) NOT NULL,
    num_externo int(3) NOT NULL,
    ramal_inicial int(3) NOT NULL,
    ramal_final int(3) NOT NULL,
    created_at timestamp NULL DEFAULT NULL,
    updated_at timestamp NULL DEFAULT NULL,
	PRIMARY KEY (id_empresa)
);

CREATE TABLE ramal (
  id_ramal int(11) NOT NULL AUTO_INCREMENT,
  descricao varchar(255) NOT NULL,
  numero int(3) NOT NULL,
  id_empresa int(11) NOT NULL,
  ativo tinyint(1) NOT NULL,
  created_at timestamp NULL DEFAULT NULL,
  updated_at timestamp NULL DEFAULT NULL,
  PRIMARY KEY (id_ramal),
  FOREIGN KEY (id_empresa) REFERENCES empresa (id_empresa)
);
