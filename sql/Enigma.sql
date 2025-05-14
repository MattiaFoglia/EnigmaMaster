DROP DATABASE IF EXISTS enigmi;
CREATE DATABASE enigmi;
USE enigmi;

-- Tabella Utenti (senza ultimo_accesso)
CREATE TABLE utenti (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    is_admin BOOLEAN DEFAULT FALSE,
    data_reg TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabella Enigmi
-- CREATE TABLE enigmi (
--     id INT AUTO_INCREMENT PRIMARY KEY,
--     titolo VARCHAR(200) NOT NULL,
--     descrizione TEXT,
--     risposta_corretta VARCHAR(255) NOT NULL,
--     suggerimento TEXT,
--     data_inizio DATETIME NOT NULL,
--     data_fine DATETIME NOT NULL,
--     creata_da INT NOT NULL,
--     FOREIGN KEY (creata_da) REFERENCES utenti(id) ON DELETE CASCADE
-- );

-- Tabella Leaderboard (con tempo_risoluzione)
CREATE TABLE leaderboard (
    id INT AUTO_INCREMENT PRIMARY KEY,
    utente_id INT NOT NULL,
    punteggio INT NOT NULL,
    FOREIGN KEY (utente_id) REFERENCES utenti(id) ON DELETE CASCADE
);

-- Inserimento dati utenti (senza ultimo_accesso)
INSERT INTO `utenti` (`id`, `nome`, `email`, `password`,`is_admin`, `data_reg`) VALUES
(1, 'Prova', 'Prova@gmail.com', '$2y$10$UQn/Z55cChuZ2NA/6z8pOe3lxFqhzW./WQkZXJDDI7BXNR/TcV0S2',  0, '2025-04-04 05:05:59'),
(2, 'Pippo', 'pippo@gmail.com', '$2y$10$1ANkRel9o5wOkzGkCPSeWOZGQ8DjRBm5WgoduQjmUmpKLnOxFK76O', 0, '2025-04-04 13:44:54'),
(3, 'rigo72', 'matty.gory27@gmail.com', '$2y$10$gqHYuAh4sEueXfueskUCWOfqD1/Ag2ydOEJnWpyixTjTFUT8z1DgS', 0, '2025-04-04 14:18:13'),
(4, 'Samson', 'awwright8@gmail.com', '$2y$10$mxRXBz5YMn5zCwC/DxXnhOiG0mvlprJf2IKdOMpceF0Rcg5HEBkdu',  0, '2025-04-06 01:10:47'),
(5, 'm4A', 'm4A@gmail.com', '$2y$10$MMezQ5PbOWDjcLrVa3VACOUXjisdBIMR/tkUxkE0F1XCGK/jGQUVq',  0, '2025-04-10 10:16:48'),
(6, 'pippi', 'pippi@gmail.com', '$2y$10$OEU4ZknFayY3bBlghsaiFuGAZDbnySZa/.UFxLlrX7bf/mmVC.IXG',  0, '2025-04-13 13:07:51'),
(7, 'V', 'v@gmail.com', '$2y$10$nzE6e5mPUQoNiZ0J2SXmpu8wNozrXlDvZZn6MACoDMPCzosqn2Z8.',  0, '2025-04-16 07:16:07'),
(8, 'davide', 'ciaofoglia6363@gmail.com', '$2y$10$tGSVKFjlwisnXgl2zKKP.u9sSrIb8GCPxxe1UH1TJg3yjE//7cu.e',  0, '2025-04-16 13:45:11'),
(10, 'Admin', 'admin@example.com', '$2y$10$Lg4Lk/85/pt7Q9RutOQGneMYLXaNFRd5DeJbaxYU0Vr.StSKzvCim',  1, '2025-05-05 00:26:12');

INSERT INTO leaderboard (utente_id, punteggio) VALUES (1, 0);
INSERT INTO leaderboard (utente_id, punteggio) VALUES (7, 0);
-- INSERT INTO leaderboard (utente_id, punteggio) VALUES (15, 0);
INSERT INTO leaderboard (utente_id, punteggio) VALUES (4, 40);
INSERT INTO leaderboard (utente_id, punteggio) VALUES (10, 40);
INSERT INTO leaderboard (utente_id, punteggio) VALUES (8, 50);
INSERT INTO leaderboard (utente_id, punteggio) VALUES (6, 60);
INSERT INTO leaderboard (utente_id, punteggio) VALUES (2, 100);
INSERT INTO leaderboard (utente_id, punteggio) VALUES (5, 100);
-- INSERT INTO leaderboard (utente_id, punteggio) VALUES (9, 100);
-- INSERT INTO leaderboard (utente_id, punteggio) VALUES (11, 100);

