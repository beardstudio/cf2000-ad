-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema livredorv2
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `livredorv2` ;

-- -----------------------------------------------------
-- Schema livredorv2
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `livredorv2` DEFAULT CHARACTER SET utf8 ;
USE `livredorv2` ;

-- -----------------------------------------------------
-- Table `livredorv2`.`themessages`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `livredorv2`.`themessages` ;

CREATE TABLE IF NOT EXISTS `livredorv2`.`themessages` (
  `idthemessages` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `themessagesname` VARCHAR(60) NOT NULL,
  `themessagestext` VARCHAR(600) NOT NULL,
  `themessagesdate` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  `themessagesaccept` TINYINT UNSIGNED NULL DEFAULT 1,
  PRIMARY KEY (`idthemessages`))
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
