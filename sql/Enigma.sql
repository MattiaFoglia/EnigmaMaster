-- Creazione del database
DROP DATABASE IF EXISTS Enigmi;
CREATE DATABASE Enigmi;
USE Enigmi;

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

-- Tabella Tentativi (memorizza le risposte degli utenti)
CREATE TABLE tentativi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    utente_id INT,
    enigma_id INT NOT NULL,
    risposta VARCHAR(255) NOT NULL,
    esito BOOLEAN NOT NULL, -- 1 = corretto, 0 = sbagliato
    tempo_impiegato INT, -- Tempo in secondi
    data_tentativo TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (utente_id) REFERENCES utenti(id) ON DELETE CASCADE,
    FOREIGN KEY (enigma_id) REFERENCES enigmi(id) ON DELETE CASCADE
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

-- Inserimento di un utente admin di test
INSERT INTO utenti (nome, email, password) 
VALUES ('Admin', 'admin@example.com', 'admin123'); -- Ricorda di criptare la password in PHP!


-- Inserimento di enigmi di esempio
INSERT INTO enigmi (titolo, descrizione, risposta_corretta, suggerimento, data_inizio, data_fine, creata_da) VALUES
('La Chiave Segreta', 'Sono sempre con te, ma a volte mi perdi. Apro porte e misteri, ma non sono una persona. Cosa sono?', 'CHIAVE', 'Si usa per aprire qualcosa.', NOW(), DATE_ADD(NOW(), INTERVAL 30 DAY), 1),
('Il Numero Misterioso', 'Sono un numero, ma se mi capovolgi divento di più. Quale numero sono?', '6', 'Prova a girarlo al contrario.', NOW(), DATE_ADD(NOW(), INTERVAL 30 DAY), 1),
('L’Oggetto Invisibile', 'Se mi nomini, non esisto più. Cosa sono?', 'SILENZIO', 'Si rompe facilmente, ma non è un oggetto fisico.', NOW(), DATE_ADD(NOW(), INTERVAL 30 DAY), 1),
('Il Viaggiatore Immobile', 'Non cammino, ma viaggio per tutto il mondo. Cosa sono?', 'FRANCOBOLLO', 'Si attacca e poi parte.', NOW(), DATE_ADD(NOW(), INTERVAL 30 DAY), 1),
('Il Custode del Tempo', 'Ho numeri, ma non posso fare calcoli. Ho mani, ma non posso afferrare. Cosa sono?', 'OROLOGIO', 'Segna le ore.', NOW(), DATE_ADD(NOW(), INTERVAL 30 DAY), 1),
('Il Re Senza Corona', 'Sono bianco, ma non sono neve. Se mi tocchi, cambio aspetto. Chi sono?', 'CARTA', 'Si usa per scrivere.', NOW(), DATE_ADD(NOW(), INTERVAL 30 DAY), 1),
('Il Guardiano della Notte', 'Di giorno scompare, di notte illumina il cielo. Cosa sono?', 'LUNA', 'Non è il sole.', NOW(), DATE_ADD(NOW(), INTERVAL 30 DAY), 1);

