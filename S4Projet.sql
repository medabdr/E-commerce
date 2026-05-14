CREATE DATABASE IF NOT EXISTS S4Projet;
USE S4Projet;

CREATE TABLE IF NOT EXISTS utilisateurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'client') NOT NULL DEFAULT 'client'
);

CREATE TABLE IF NOT EXISTS produits (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    categorie VARCHAR(255) NOT NULL,
    prix DECIMAL(10,2) NOT NULL,
    image VARCHAR(500),
    stock INT NOT NULL DEFAULT 0
);

CREATE TABLE IF NOT EXISTS commandes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    date DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES utilisateurs(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS commande_details (
    id INT AUTO_INCREMENT PRIMARY KEY,
    commande_id INT NOT NULL,
    produit_id INT NOT NULL,
    quantite INT NOT NULL,
    FOREIGN KEY (commande_id) REFERENCES commandes(id) ON DELETE CASCADE,
    FOREIGN KEY (produit_id) REFERENCES produits(id) ON DELETE CASCADE
);
CREATE TABLE IF NOT EXISTS produitstatus (
    id int primary key auto_increment,
    nom varchar(50),
    statut varchar(50)
);

-- insert data into produitstatus table
INSERT INTO produitstatus (id, nom, statut) VALUES
(1, 'Microsoft', 'boycotté'),
(2, 'Google', 'boycotté'),
(3, 'Intel', 'boycotté'),
(4, 'Amazon AWS', 'boycotté'),
(5, 'Cisco', 'boycotté'),
(6, 'Oracle', 'boycotté'),
(7, 'Dell', 'boycotté'),
(8, 'Apple', 'boycotté'),
(9, 'NVIDIA', 'boycotté'),
(10, 'IBM', 'boycotté'),
(11, 'Xiaomi', 'Non boycotté'),
(12, 'Huawei', 'Non boycotté'),
(13, 'Oppo', 'Non boycotté'),
(14, 'Vivo', 'Non boycotté'),
(15, 'Realme', 'Non boycotté'),
(16, 'Lenovo', 'Non boycotté'),
(17, 'Condor', 'Non boycotté'),
(18, 'Iris', 'Non boycotté'),
(19, 'Nokia', 'boycotté'),
(20, 'HP', 'boycotté'),
(21, 'Samsung', 'boycotté'),
(22, 'Asus', 'boycotté'),
(23, 'Canon', 'boycotté'),
(24, 'Epson', 'boycotté'),
(25, 'Brother', 'boycotté'),
(26, 'Xerox', 'boycotté'),
(27, 'Kyocera', 'Non boycotté');

-- insert data into produits table

INSERT INTO `produits` (`id`, `nom`, `categorie`, `prix`, `image`, `stock`) VALUES
(1, 'Xiaomi 17 Pro Max', 'Téléphone', 999.00, 'uploads/d55033df042afabd6db6176666b1d330.jpeg', 10),
(2, 'Realme book', 'Ordinateur', 140000.00, 'uploads/21aaa77d213acd92f8c8bf145e921c49.jpeg', 10),
(3, 'Xiaomi 17 Ultra', 'Téléphone', 19000.00, 'uploads/122506c6ea602a5ac0af32f90b4cedfa.jpeg', 9),
(4, 'HUAWEI Pura 80 Pro', 'Téléphone', 15000.00, 'uploads/1823390d24cf4637ca6b94af23f44c1e.jpeg', 8),
(5, 'HUAWEI P50 Pro', 'Téléphone', 16000.00, 'uploads/a0fb3e9b9ba09089f541ad9579813a27.jpeg', 0),
(6, 'Xiaomi 14 Ultra ', 'Téléphone', 20000.00, 'uploads/ea74689b279ae500973fa4e8df39029f.jpeg', 8),
(7, 'Realme Pad 2', 'Tablette', 90000.00, 'uploads/804ad16aee4ca2bbe7ba9594c2880d85.jpeg', 10),
(8, 'Oppo Pad Neo', 'Tablette', 50000.00, 'uploads/4dc9cba0e9a40e9be78800bf9d948945.jpeg', 10),
(9, 'Oppo Pad Air', 'Tablette', 50000.00, 'uploads/2136c37f1c480d60dd677804e3d5fcc8.jpeg', 10),
(10, 'Lenovo ThinkBook', 'Ordinateur', 99999.99, 'uploads/9986ae6d91aca313e2cf51a782a6350d.jpeg', 10),
(11, 'Huawei MateBook X Pro', 'Ordinateur', 110000.00, 'uploads/de4304734564befda997b1c96411eb92.jpeg', 10),
(12, 'RisoPhy Mouse', 'Autre', 500.00, 'uploads/25775d51e252bdda7ea4c19f9459bcc0.jpeg', 10),
(13, 'RisoPhy Keyboard', 'Autre', 1500.00, 'uploads/8ccaae01e16a5077e60f43505dc64e56.jpeg', 10),
(14, 'Kyocera Printer', 'Autre', 25000.00, 'uploads/ee0293b168bcf96c117bb6bdf2e5953f.jpeg', 10);

-- insert data into utilisateurs table

INSERT INTO `utilisateurs` (`id`, `username`, `email`, `password`, `role`) VALUES
(1, 'mohamed', 'client1@gmail.com', '11111111', 'client'),
(2, 'ahmedab', 'ahmed@gmail.com', '22222222', 'admin');

