ALTER TABLE `impiegati`
CHANGE COLUMN `oreLun` `oreLun` DOUBLE NULL DEFAULT 8 ,
CHANGE COLUMN `oreMar` `oreMar` DOUBLE NULL DEFAULT 8 ,
CHANGE COLUMN `oreMer` `oreMer` DOUBLE NULL DEFAULT 8 ,
CHANGE COLUMN `oreGio` `oreGio` DOUBLE NULL DEFAULT 8 ,
CHANGE COLUMN `oreVen` `oreVen` DOUBLE NULL DEFAULT 8 ,
CHANGE COLUMN `oreSab` `oreSab` DOUBLE NULL DEFAULT 0 ,
CHANGE COLUMN `oreDom` `oreDom` DOUBLE NULL DEFAULT 0 ;
