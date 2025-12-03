-- SQL to create kontak table
CREATE TABLE IF NOT EXISTS kontak (
    id_kontak INT(11) NOT NULL AUTO_INCREMENT,
    nama VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    no_telp VARCHAR(20) DEFAULT NULL,
    pesan TEXT NOT NULL,
    PRIMARY KEY (id_kontak)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
