-- MySQL Script generated by MySQL Workbench
-- Fri Jul  3 23:48:48 2020
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema docx
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema docx
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `docx` DEFAULT CHARACTER SET utf8 ;
USE `docx` ;

-- -----------------------------------------------------
-- Table `docx`.`comments`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `docx`.`comments` (
  `id_comments` INT NOT NULL, AUTO_INCREMENT
  `pseudo` VARCHAR(45) NOT NULL,
  `created_at` VARCHAR(45) NOT NULL,
  `commentaire` TEXT NOT NULL,
  PRIMARY KEY (`id_comments`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `docx`.`docs`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `docx`.`docs` (
  `id_docs` INT NOT NULL, AUTO_INCREMENT
  `type` VARCHAR(255) NOT NULL,
  `taille` VARCHAR(255) NOT NULL,
  `created_at` VARCHAR(255) NOT NULL,
  `date_edition` VARCHAR(255) NOT NULL,
  `date_echeance` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id_docs`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `docx`.`utilisateur`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `docx`.`utilisateur` (
  `id_utilisateur` INT NOT NULL AUTO_INCREMENT,
  `prenom` VARCHAR(45) NOT NULL,
  `nom` VARCHAR(45) NOT NULL,
  `username` VARCHAR(255) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `adresse` VARCHAR(255) NOT NULL,
  `password` VARCHAR(45) NOT NULL,
  `premium` VARCHAR(45) NOT NULL,
  `roles` JSON NOT NULL,
  `comments_id_comments` INT NOT NULL,
  `docs_id_docs` INT NOT NULL,
  PRIMARY KEY (`id_utilisateur`, `comments_id_comments`),
  INDEX `fk_utilisateur_comments_idx` (`comments_id_comments` ASC) VISIBLE,
  INDEX `fk_utilisateur_docs1_idx` (`docs_id_docs` ASC) VISIBLE,
  CONSTRAINT `fk_utilisateur_comments`
    FOREIGN KEY (`comments_id_comments`)
    REFERENCES `docx`.`comments` (`id_comments`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_utilisateur_docs1`
    FOREIGN KEY (`docs_id_docs`)
    REFERENCES `docx`.`docs` (`id_docs`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
