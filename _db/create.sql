CREATE DATABASE aldini_poi;
USE aldini_poi;

CREATE TABLE permessi (
	id INT AUTO_INCREMENT PRIMARY KEY,
	tipologia VARCHAR(50) NOT NULL
);
INSERT permessi VALUES(null, "Base");
INSERT permessi VALUES(null, "Avanzato");
INSERT permessi VALUES(null, "Admin");

CREATE TABLE dispositivi (
	id INT AUTO_INCREMENT PRIMARY KEY,
	descrizione VARCHAR(100) NOT NULL,
	mac_address VARCHAR(20)
);

CREATE TABLE visite (
	id INT AUTO_INCREMENT PRIMARY KEY,
<<<<<<< HEAD
	data_inizio DATE NOT NULL,
=======
	data DATE NOT NULL
>>>>>>> 1a2ce4965372ab3b70bccc7df82d12fd5fa8b0f0
	ora_inizio TIME NOT NULL,
	ora_fine TIME NOT NULL,
	CHECK (ora_inizio < ora_fine)
);

CREATE TABLE laboratori (
	tag VARCHAR(20) PRIMARY KEY,
	nome VARCHAR(100) NOT NULL,
	piano INT NOT NULL,
	num_posti INT,
	num_pc INT,
	presenza_lim BOOLEAN,
	descrizione VARCHAR(500)
);

CREATE TABLE utenti (
	id INT AUTO_INCREMENT PRIMARY KEY,
	email VARCHAR(100) UNIQUE,
	psw VARCHAR(60) NOT NULL,
	nome VARCHAR(100) NOT NULL,
	cognome VARCHAR(100) NOT NULL,
	ddn DATE NOT NULL,
	cod_permesso INT NOT NULL,
	FOREIGN KEY (cod_permesso) REFERENCES permessi(id) ON DELETE RESTRICT ON UPDATE CASCADE
);

CREATE TABLE prenotazioni (
	id INT AUTO_INCREMENT PRIMARY KEY,
	data_visita DATE NOT NULL,
	ora_inizio TIME,
	username VARCHAR(100) NOT NULL, /* Generato per la visita */
	psw VARCHAR(100) NOT NULL, /* Generato per la visita */
	cod_utente VARCHAR(100) NOT NULL,
	cod_dispositivo INT,
	cod_orario INT NOT NULL,
	cod_permesso INT NOT NULL,
	FOREIGN KEY (cod_utente) REFERENCES utenti(id) ON DELETE CASCADE ON UPDATE CASCADE,
	FOREIGN KEY (cod_dispositivo) REFERENCES dispositivi(id) ON DELETE RESTRICT ON UPDATE CASCADE,
	FOREIGN KEY (cod_orario) REFERENCES orari(id) ON DELETE RESTRICT ON UPDATE CASCADE,
	FOREIGN KEY (cod_permesso) REFERENCES permessi(id) ON DELETE RESTRICT ON UPDATE CASCADE
);

CREATE TABLE immagini (
	id INT AUTO_INCREMENT PRIMARY KEY,
	percorso VARCHAR(500) NOT NULL,
	descrizione VARCHAR(500),
	cod_laboratorio VARCHAR(20) NOT NULL,
	cod_permesso INT NOT NULL,
	FOREIGN KEY (cod_laboratorio) REFERENCES laboratori(tag) ON DELETE RESTRICT ON UPDATE CASCADE,
	FOREIGN KEY (cod_permesso) REFERENCES permessi(id) ON DELETE RESTRICT ON UPDATE CASCADE
);

CREATE TABLE configurazioni (
	id INT AUTO_INCREMENT PRIMARY KEY,
	descrizione_cpu VARCHAR(100),
	descrizione_ram VARCHAR(100),
	descrizione_hdd VARCHAR(100),
	descrizione VARCHAR(500),
	cod_laboratorio VARCHAR(20) NOT NULL,
	FOREIGN KEY (cod_laboratorio) REFERENCES laboratori(tag) ON DELETE RESTRICT ON UPDATE CASCADE
);
