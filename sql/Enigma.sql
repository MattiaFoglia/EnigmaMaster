DROP DATABASE IF EXISTS enigmi;
CREATE DATABASE enigmi;
USE enigmi;

-- Tabella Utenti
CREATE TABLE utenti (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL, -- Cripta con password_hash()
    punteggio INT DEFAULT 0,
    data_reg TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabella Enigmi (ogni enigma è una singola sfida)
CREATE TABLE enigmi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titolo VARCHAR(200) NOT NULL,
    descrizione TEXT,
    risposta_corretta VARCHAR(255) NOT NULL, -- Risposta esatta
    suggerimento TEXT,
    data_inizio DATETIME NOT NULL,
    data_fine DATETIME NOT NULL,
    creata_da INT NOT NULL,
    FOREIGN KEY (creata_da) REFERENCES utenti(id) ON DELETE CASCADE
);

-- Tabella Leaderboard (classifica dei migliori giocatori)
CREATE TABLE leaderboard (
    id INT AUTO_INCREMENT PRIMARY KEY,
    utente_id INT NOT NULL,
    enigma_id INT NOT NULL,
    punteggio INT NOT NULL,
    tempo_totale INT, -- Tempo impiegato per risolvere l’enigma
    FOREIGN KEY (utente_id) REFERENCES utenti(id) ON DELETE CASCADE,
    FOREIGN KEY (enigma_id) REFERENCES enigmi(id) ON DELETE CASCADE
);