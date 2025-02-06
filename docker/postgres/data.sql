INSERT INTO cryptos (nom_crypto, symbole, prix_actuel, pourcentage) VALUES
('Bitcoin', 'BTC', 45000.00, 3.24),
('Ethereum', 'ETH', 3000.00, -1.10),
('Binance Coin', 'BNB', 350.25, 5.68),
('Ripple', 'XRP', 1.25, 2.75),
('Cardano', 'ADA', 1.15, -0.92),
('Solana', 'SOL', 150.00, 1.36),
('Polkadot', 'DOT', 40.00, 4.58),
('Dogecoin', 'DOGE', 0.065, 0.89),
('Shiba Inu', 'SHIB', 0.000006, 10.45),
('Litecoin', 'LTC', 150.75, 0.11);

INSERT INTO utilisateur (nom, email, mot_de_passe) VALUES
('Rakotoniaina', 'luciorakotoniaina8@gmail.com', '123456');

INSERT INTO statut (libelle) VALUES
('en attente'),
('confirme'),
('rejete');

INSERT INTO type_fonds (type) VALUES
('depot'),
('retrait');

INSERT INTO type_transaction (type) VALUES
('vente'),
('achat');

INSERT INTO commission (Id_cryptos, Id_type_transaction, pourcentage, daty) VALUES
(1, 1, 0.50, '2025-02-06'),
(1, 2, 0.75, '2025-02-06'),
(2, 1, 0.60, '2025-02-06'),
(2, 2, 0.85, '2025-02-06'),
(3, 1, 0.55, '2025-02-06'),
(3, 2, 0.80, '2025-02-06'),
(4, 1, 0.40, '2025-02-06'),
(4, 2, 0.70, '2025-02-06'),
(5, 1, 0.45, '2025-02-06'),
(5, 2, 0.78, '2025-02-06'),
(6, 1, 0.65, '2025-02-06'),
(6, 2, 0.90, '2025-02-06'),
(7, 1, 0.50, '2025-02-06'),
(7, 2, 0.85, '2025-02-06'),
(8, 1, 0.30, '2025-02-06'),
(8, 2, 0.60, '2025-02-06'),
(9, 1, 0.20, '2025-02-06'),
(9, 2, 0.55, '2025-02-06'),
(10, 1, 0.35, '2025-02-06'),
(10, 2, 0.65, '2025-02-06');
