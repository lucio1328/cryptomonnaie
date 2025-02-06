alter table utilisateur drop column mot_de_passe;

alter table fonds drop column id_portefeuilles;

alter table fonds add column id_utilisateur integer references utilisateur(id_utilisateur);
