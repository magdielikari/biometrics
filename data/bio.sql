-- MySQL Script generated by MySQL Workbench
-- Mon Mar 20 10:54:46 2017
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema bio
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema bio
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `bio` DEFAULT CHARACTER SET utf8 ;
USE `bio` ;

-- -----------------------------------------------------
-- Table `bio`.`file`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bio`.`file` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `path` VARCHAR(127) NOT NULL,
  `name` VARCHAR(113) NOT NULL,
  `created_at` INT NULL,
  `updated_at` INT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `bio`.`data`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bio`.`data` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `time` VARCHAR(71) NOT NULL,
  `number` INT UNSIGNED NOT NULL,
  `name` VARCHAR(127) NOT NULL,
  `event` VARCHAR(71) NOT NULL,
  `created_at` INT NULL,
  `updated_at` INT NULL,
  `file_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_data_file1_idx` (`file_id` ASC),
  CONSTRAINT `fk_data_file1`
    FOREIGN KEY (`file_id`)
    REFERENCES `bio`.`file` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `bio`.`person`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bio`.`person` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(97) NOT NULL,
  `ci` INT UNSIGNED NOT NULL,
  `created_at` INT NULL,
  `updated_at` INT NULL,
  `file_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_person_file1_idx` (`file_id` ASC),
  CONSTRAINT `fk_person_file1`
    FOREIGN KEY (`file_id`)
    REFERENCES `bio`.`file` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `bio`.`event`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bio`.`event` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `year` SMALLINT UNSIGNED NOT NULL,
  `number_years_day` SMALLINT UNSIGNED NOT NULL,
  `unix_time` BIGINT UNSIGNED NOT NULL,
  `event` VARCHAR(71) NOT NULL,
  `created_at` INT NULL,
  `updated_at` INT NULL,
  `person_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_fecha_persona_idx` (`person_id` ASC),
  CONSTRAINT `fk_fecha_persona`
    FOREIGN KEY (`person_id`)
    REFERENCES `bio`.`person` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `bio`.`date`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bio`.`date` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `number_day` TINYINT NOT NULL,
  `number_weeks_day` TINYINT NOT NULL,
  `number_month` TINYINT NOT NULL,
  `year` SMALLINT NOT NULL,
  `number_years_day` SMALLINT NOT NULL,
  `weekday` VARCHAR(17) NOT NULL,
  `month` VARCHAR(17) NOT NULL,
  `created_at` INT NULL,
  `updated_at` INT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `bio`.`record`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bio`.`record` (
  `person_id` INT UNSIGNED NOT NULL,
  `date_id` INT UNSIGNED NOT NULL,
  `counter` TINYINT UNSIGNED NOT NULL,
  `min` BIGINT UNSIGNED NOT NULL,
  `max` BIGINT UNSIGNED NOT NULL,
  `average` BIGINT UNSIGNED NOT NULL,
  `created_at` INT NULL,
  `update_at` INT NULL,
  PRIMARY KEY (`person_id`, `date_id`),
  INDEX `fk_person_has_date_date1_idx` (`date_id` ASC),
  INDEX `fk_person_has_date_person1_idx` (`person_id` ASC),
  CONSTRAINT `fk_person_has_date_person1`
    FOREIGN KEY (`person_id`)
    REFERENCES `bio`.`person` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_person_has_date_date1`
    FOREIGN KEY (`date_id`)
    REFERENCES `bio`.`date` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `bio`.`labor`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bio`.`labor` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `in` BIGINT UNSIGNED NOT NULL,
  `out` BIGINT UNSIGNED NOT NULL,
  `created_at` INT NULL,
  `update_at` INT NULL,
  `person_id` INT UNSIGNED NOT NULL,
  `date_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_person_has_date_date2_idx` (`date_id` ASC),
  INDEX `fk_person_has_date_person2_idx` (`person_id` ASC),
  CONSTRAINT `fk_person_has_date_person2`
    FOREIGN KEY (`person_id`)
    REFERENCES `bio`.`person` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_person_has_date_date2`
    FOREIGN KEY (`date_id`)
    REFERENCES `bio`.`date` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
