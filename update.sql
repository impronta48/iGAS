DROP TABLE costiattivita;
DROP TABLE aziende;
DROP TABLE citta;
DROP TABLE clienti;
DROP TABLE fornitori;
DROP TABLE impiegati;
DROP TABLE impiegati_attivita;
DROP TABLE legenda_tipi_persone;
DROP TABLE legenda_tipi_forniture;
DROP TABLE legenda_tipi_clienti;
DROP TABLE oauth2s;
DROP TABLE partecipanti;
DROP TABLE persone_extra;
DROP TABLE scadenze;


CREATE TABLE `impiegati` (
  `persona_id` int(11) NOT NULL,
  `legenda_tipo_impiegato_id` int(11) DEFAULT NULL,
  `numero_assistenza_sociale` varchar(30) DEFAULT NULL,
  `matricola_inps` varchar(30) DEFAULT NULL,
  `data_assunzione` datetime DEFAULT NULL,
  `stipendio_lordo_annuo` decimal(19,4) DEFAULT NULL,
  `luogo_di_nascita` varchar(50) DEFAULT NULL,
  `costo_h_aziendale` float DEFAULT NULL,
  `venduto_h_aziendale` float DEFAULT NULL,
  `valido_dal` date DEFAULT NULL,
  `disattivo` tinyint(4) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `modified_by` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`persona_id`),
  KEY `Reference6` (`legenda_tipo_impiegato_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
ALTER TABLE `legenda_tipi_impiegati` 
CHANGE COLUMN `IDTipoImpiegato` `id` INT(11) NOT NULL AUTO_INCREMENT FIRST,
CHANGE COLUMN `TipoImpiegato` `name` VARCHAR(50) NOT NULL , RENAME TO  `legenda_tipo_impiegato` ;
