##Svuoto tutte le tabelle per avere gli ID=0
TRUNCATE aliases;
TRUNCATE attivita;
TRUNCATE clienti;
TRUNCATE costiattivita;
TRUNCATE ddt;
TRUNCATE faseattivita;
TRUNCATE fattureemesse;
TRUNCATE fatturericevute;
TRUNCATE persone;
TRUNCATE fornitori;
TRUNCATE impiegati;
TRUNCATE impiegati_attivita;
TRUNCATE ordini;
TRUNCATE progetti;

##Creazione dati ragionevoli
INSERT INTO progetti (NAME, DescrizioneProgetto, area_id) VALUES ('Progetto Generico', 'Progetto Generico',1);
INSERT INTO progetti (NAME, DescrizioneProgetto, area_id) VALUES ('Progetto Interno', 'Progetto Interno',1);
INSERT INTO persone(DisplayName) VALUES ('Tua Azienda - Da Compilare');
INSERT INTO attivita (NAME, progetto_id, cliente_id) VALUES ('Admin',2,1);
INSERT INTO attivita (NAME, progetto_id, cliente_id) VALUES ('Ferie',2,1);
INSERT INTO attivita (NAME, progetto_id, cliente_id) VALUES ('Malattia',2,1);
INSERT INTO attivita (NAME, progetto_id, cliente_id) VALUES ('Commerciale',2,1);
INSERT INTO attivita (NAME, progetto_id, cliente_id) VALUES ('Primo Progetto di Esempio',1,1);