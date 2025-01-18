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
('confirme');

INSERT INTO type_fonds (type) VALUES
('depot'),
('retrait');

INSERT INTO type_transaction (type) VALUES
('vente'),
('achat');

