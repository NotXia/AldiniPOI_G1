CREATE DATABASE aldini_poi;
USE aldini_poi;

CREATE TABLE permessi (
	id INT AUTO_INCREMENT PRIMARY KEY,
	tipologia VARCHAR(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
INSERT permessi VALUES(null, "Base");
INSERT permessi VALUES(null, "Avanzato");
INSERT permessi VALUES(null, "Admin");

CREATE TABLE dispositivi (
	id INT AUTO_INCREMENT PRIMARY KEY,
	descrizione VARCHAR(100) NOT NULL,
	mac_address VARCHAR(20) UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE visite (
	id INT AUTO_INCREMENT PRIMARY KEY,
	data_inizio DATE NOT NULL,
	ora_inizio TIME NOT NULL,
	ora_fine TIME NOT NULL,
	posti_disponibili INT NOT NULL,
	CHECK (ora_inizio < ora_fine AND posti_disponibili >= 0)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE laboratori (
	tag VARCHAR(20) PRIMARY KEY,
	nome VARCHAR(100) NOT NULL,
	piano INT NOT NULL,
	num_pc INT,
	presenza_lim BOOLEAN,
	descrizione VARCHAR(500),
	id_html_map VARCHAR(100) UNIQUE,
	label_html_map VARCHAR(100) UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE utenti (
	id INT AUTO_INCREMENT PRIMARY KEY,
	email VARCHAR(100) UNIQUE,
	psw VARCHAR(60) NOT NULL,
	nome VARCHAR(100) NOT NULL,
	cognome VARCHAR(100) NOT NULL,
	ddn DATE NOT NULL,
	data_creazione DATETIME NOT NULL,
	verifica_mail BOOLEAN NOT NULL,
	ultima_modifica_psw DATETIME,
	cod_permesso INT NOT NULL,
	FOREIGN KEY (cod_permesso) REFERENCES permessi(id) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE autenticazioni (
	selector VARCHAR(20) PRIMARY KEY,
	token VARCHAR(60) NOT NULL,
	ip VARCHAR(15),
	web_agent VARCHAR(500),
	data_scadenza DATETIME NOT NULL,
	cod_utente INT NOT NULL,
	FOREIGN KEY (cod_utente) REFERENCES utenti(id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE prenotazioni (
	id INT AUTO_INCREMENT PRIMARY KEY,
	username VARCHAR(100), /* Generato per la visita */
	psw VARCHAR(60), /* Generato per la visita */
	cod_utente INT NOT NULL,
	cod_dispositivo INT,
	cod_visita INT NOT NULL,
	cod_permesso INT NOT NULL,
	FOREIGN KEY (cod_utente) REFERENCES utenti(id) ON DELETE RESTRICT ON UPDATE CASCADE,
	FOREIGN KEY (cod_dispositivo) REFERENCES dispositivi(id) ON DELETE SET NULL ON UPDATE CASCADE,
	FOREIGN KEY (cod_visita) REFERENCES visite(id) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY (cod_permesso) REFERENCES permessi(id) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE immagini (
	id INT AUTO_INCREMENT PRIMARY KEY,
	percorso VARCHAR(500) NOT NULL,
	descrizione VARCHAR(500),
	cod_laboratorio VARCHAR(20) NOT NULL,
	cod_permesso INT NOT NULL,
	FOREIGN KEY (cod_laboratorio) REFERENCES laboratori(tag) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY (cod_permesso) REFERENCES permessi(id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
