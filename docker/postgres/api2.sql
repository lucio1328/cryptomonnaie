CREATE TABLE type_transaction(
   Id_type_transaction SERIAL,
   type VARCHAR(255)  NOT NULL,
   PRIMARY KEY(Id_type_transaction),
   UNIQUE(type)
);

CREATE TABLE cryptos(
   Id_cryptos SERIAL,
   nom_crypto VARCHAR(50)  NOT NULL,
   symbole VARCHAR(50)  NOT NULL,
   prix_actuel NUMERIC(20,2)   NOT NULL,
   pourcentage NUMERIC(15,2)   NOT NULL,
   PRIMARY KEY(Id_cryptos),
   UNIQUE(nom_crypto),
   UNIQUE(symbole)
);

CREATE TABLE utilisateur(
   Id_utilisateur SERIAL,
   nom VARCHAR(50)  NOT NULL,
   email VARCHAR(50)  NOT NULL,
   mot_de_passe VARCHAR(255)  NOT NULL,
   PRIMARY KEY(Id_utilisateur),
   UNIQUE(email)
);

CREATE TABLE statut(
   Id_statut SERIAL,
   libelle VARCHAR(50)  NOT NULL,
   PRIMARY KEY(Id_statut),
   UNIQUE(libelle)
);

CREATE TABLE type_fonds(
   Id_type_fonds SERIAL,
   type VARCHAR(50)  NOT NULL,
   PRIMARY KEY(Id_type_fonds),
   UNIQUE(type)
);

CREATE TABLE historique_cours(
   Id_historique_cours SERIAL,
   cours NUMERIC(20,5)   NOT NULL,
   date_enregistrement TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
   Id_cryptos INTEGER NOT NULL,
   PRIMARY KEY(Id_historique_cours),
   FOREIGN KEY(Id_cryptos) REFERENCES cryptos(Id_cryptos)
);

CREATE TABLE transactions(
   Id_transactions SERIAL,
   quantite INTEGER NOT NULL,
   prix NUMERIC(20,5)   NOT NULL,
   date_transaction DATE NOT NULL,
   Id_utilisateur INTEGER NOT NULL,
   Id_cryptos INTEGER NOT NULL,
   Id_type_transaction INTEGER NOT NULL,
   PRIMARY KEY(Id_transactions),
   FOREIGN KEY(Id_utilisateur) REFERENCES utilisateur(Id_utilisateur),
   FOREIGN KEY(Id_cryptos) REFERENCES cryptos(Id_cryptos),
   FOREIGN KEY(Id_type_transaction) REFERENCES type_transaction(Id_type_transaction)
);

CREATE TABLE portefeuilles(
   Id_portefeuilles SERIAL,
   nom_portefeuille VARCHAR(100) NOT NULL,
   solde NUMERIC(20,5)   NOT NULL,
   date_creation DATE NOT NULL,
   Id_utilisateur INTEGER NOT NULL,
   Id_cryptos INTEGER NOT NULL,
   PRIMARY KEY(Id_portefeuilles),
   FOREIGN KEY(Id_utilisateur) REFERENCES utilisateur(Id_utilisateur),
   FOREIGN KEY(Id_cryptos) REFERENCES cryptos(Id_cryptos)
);

CREATE TABLE fonds(
   Id_fonds SERIAL,
   montant_usd NUMERIC(20,5)   NOT NULL,
   montant_euro VARCHAR(50) ,
   montant_ariary VARCHAR(50) ,
   daty DATE NOT NULL,
   Id_portefeuilles INTEGER NOT NULL,
   Id_type_fonds INTEGER NOT NULL,
   Id_statut INTEGER NOT NULL,
   PRIMARY KEY(Id_fonds),
   FOREIGN KEY(Id_portefeuilles) REFERENCES portefeuilles(Id_portefeuilles),
   FOREIGN KEY(Id_type_fonds) REFERENCES type_fonds(Id_type_fonds),
   FOREIGN KEY(Id_statut) REFERENCES statut(Id_statut)
);

CREATE TABLE commission(
   Id_commission SERIAL,
   Id_cryptos INTEGER,
   Id_type_transaction INTEGER,
   pourcentage NUMERIC(10,5) NOT NULL,
   daty DATE NOT NULL,
   PRIMARY KEY(Id_commission),
   FOREIGN KEY(Id_cryptos) REFERENCES cryptos(Id_cryptos),
   FOREIGN KEY(Id_type_transaction) REFERENCES type_transaction(Id_type_transaction)
);