CREATE TABLE `vettori`(     `id` INT NOT NULL AUTO_INCREMENT ,     `name` VARCHAR(255) NOT NULL ,     PRIMARY KEY (`id`)  );
CREATE TABLE `legenda_causale_trasporto`(     `id` INT NOT NULL AUTO_INCREMENT ,     `name` VARCHAR(255) ,     PRIMARY KEY (`id`)  );
CREATE TABLE `legenda_porto`(     `id` INT NOT NULL AUTO_INCREMENT ,     `name` VARCHAR(255) ,     PRIMARY KEY (`id`)  );
ALTER TABLE `faseattivita`     ADD COLUMN `sc1` DOUBLE NULL AFTER `legenda_codici_iva_id`,     ADD COLUMN `sc2` DOUBLE NULL AFTER `sc1`,     ADD COLUMN `sc3` DOUBLE NULL AFTER `sc2`;	
ALTER TABLE `primanota`     ADD COLUMN `faseattivita_id` INT NULL AFTER `attivita_id`;
CREATE TABLE `ddt` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `attivita_id` INT(11) DEFAULT NULL,
  `data_inizio_trasporto` DATE DEFAULT NULL,
  `destinatario` VARCHAR(255) DEFAULT NULL,
  `destinatario_via` VARCHAR(255) DEFAULT NULL,
  `destinatario_cap` VARCHAR(7) DEFAULT NULL,
  `destinatario_citta` VARCHAR(255) DEFAULT NULL,
  `destinatario_provincia` VARCHAR(2) DEFAULT NULL,
  `luogo` VARCHAR(255) DEFAULT NULL,
  `luogo_via` VARCHAR(255) DEFAULT NULL,
  `luogo_cap` VARCHAR(7) DEFAULT NULL,
  `luogo_citta` VARCHAR(255) DEFAULT NULL,
  `luogo_provincia` VARCHAR(2) DEFAULT NULL,
  `legenda_causale_trasporto_id` INT(11) DEFAULT NULL,
  `legenda_porto_id` INT(11) DEFAULT NULL,
  `n_colli` INT(11) DEFAULT NULL,
  `vettore_id` INT(11) DEFAULT NULL,
  `note` TEXT,
  PRIMARY KEY (`id`)
) ENGINE=INNODB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

/*Table structure for table `ordini` */

CREATE TABLE `ordini` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `dataOrdine` DATE DEFAULT NULL,
  `fornitore_id` INT(11) DEFAULT NULL,
  `attivita_id` INT(11) DEFAULT NULL,
  `note` TEXT,
  PRIMARY KEY (`id`)
) ENGINE=INNODB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Table structure for table `righeddt` */

CREATE TABLE `righeddt` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `ddt_id` INT(11) DEFAULT NULL,
  `Descrizione` VARCHAR(255) DEFAULT NULL,
  `qta` DOUBLE DEFAULT NULL,
  `um` VARCHAR(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=INNODB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Table structure for table `righeordini` */

CREATE TABLE `righeordini` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `ordine_id` INT(11) DEFAULT NULL,
  `Descrizione` VARCHAR(255) DEFAULT NULL,
  `qta` DOUBLE DEFAULT NULL,
  `um` VARCHAR(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=INNODB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;
