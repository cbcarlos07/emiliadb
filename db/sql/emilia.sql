SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

DROP SCHEMA IF EXISTS `emiliabd` ;
CREATE SCHEMA IF NOT EXISTS `emiliabd` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci ;
USE `emiliabd` ;

-- -----------------------------------------------------
-- Table `emiliabd`.`nivel`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `emiliabd`.`nivel` ;

CREATE  TABLE IF NOT EXISTS `emiliabd`.`nivel` (
  `CD_NIVEL` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `DS_NIVEL` VARCHAR(45) NULL ,
  PRIMARY KEY (`CD_NIVEL`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `emiliabd`.`usuario`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `emiliabd`.`usuario` ;

CREATE  TABLE IF NOT EXISTS `emiliabd`.`usuario` (
  `CD_USUARIO` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `NM_USUARIO` VARCHAR(100) NULL ,
  `DS_LOGIN` VARCHAR(45) NULL ,
  `CD_NIVEL` INT UNSIGNED NOT NULL ,
  `DS_SENHA` VARCHAR(100) NULL ,
  `SN_ATIVO` CHAR(1) NULL ,
  `SN_SENHA_ATUAL` CHAR(1) NULL ,
  PRIMARY KEY (`CD_USUARIO`) ,
  INDEX `fk_usuario_nivel1_idx` (`CD_NIVEL` ASC) ,
  CONSTRAINT `fk_usuario_nivel1`
    FOREIGN KEY (`CD_NIVEL` )
    REFERENCES `emiliabd`.`nivel` (`CD_NIVEL` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `emiliabd`.`empresa`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `emiliabd`.`empresa` ;

CREATE  TABLE IF NOT EXISTS `emiliabd`.`empresa` (
  `CD_EMPRESA` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `DS_EMPRESA` VARCHAR(45) NULL ,
  PRIMARY KEY (`CD_EMPRESA`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `emiliabd`.`pessoa`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `emiliabd`.`pessoa` ;

CREATE  TABLE IF NOT EXISTS `emiliabd`.`pessoa` (
  `CD_PESSOA` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `NM_PESSOA` VARCHAR(100) NULL ,
  `NR_CRACHA` VARCHAR(10) NULL ,
  `CD_EMPRESA` INT UNSIGNED NOT NULL ,
  `NR_CEP` VARCHAR(8) NULL ,
  `NR_CASA` VARCHAR(5) NULL ,
  `DS_COMPLEMENTO` VARCHAR(45) NULL ,
  PRIMARY KEY (`CD_PESSOA`) ,
  INDEX `fk_pessoa_empresa1_idx` (`CD_EMPRESA` ASC) ,
  CONSTRAINT `fk_pessoa_empresa1`
    FOREIGN KEY (`CD_EMPRESA` )
    REFERENCES `emiliabd`.`empresa` (`CD_EMPRESA` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `emiliabd`.`telefone`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `emiliabd`.`telefone` ;

CREATE  TABLE IF NOT EXISTS `emiliabd`.`telefone` (
  `CD_PESSOA` INT UNSIGNED NOT NULL ,
  `NR_TELEFONE` VARCHAR(12) NULL ,
  `TP_TELEFONE` CHAR(1) NULL ,
  `DS_OBSERVACAO` VARCHAR(40) NULL ,
  INDEX `fk_telefone_pessoa1_idx` (`CD_PESSOA` ASC) ,
  CONSTRAINT `fk_telefone_pessoa1`
    FOREIGN KEY (`CD_PESSOA` )
    REFERENCES `emiliabd`.`pessoa` (`CD_PESSOA` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `emiliabd`.`refeicao`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `emiliabd`.`refeicao` ;

CREATE  TABLE IF NOT EXISTS `emiliabd`.`refeicao` (
  `CD_REFEICAO` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `DS_REFEICAO` VARCHAR(45) NULL ,
  `DT_REFEICAO` DATE NULL ,
  PRIMARY KEY (`CD_REFEICAO`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `emiliabd`.`tipo_de_prato`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `emiliabd`.`tipo_de_prato` ;

CREATE  TABLE IF NOT EXISTS `emiliabd`.`tipo_de_prato` (
  `CD_TIPO_PRATO` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `DS_TIPO_PRATO` VARCHAR(45) NULL ,
  PRIMARY KEY (`CD_TIPO_PRATO`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `emiliabd`.`prato`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `emiliabd`.`prato` ;

CREATE  TABLE IF NOT EXISTS `emiliabd`.`prato` (
  `CD_PRATO` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `DS_PRATO` VARCHAR(45) NULL ,
  `CD_TIPO_PRATO` INT UNSIGNED NOT NULL ,
  PRIMARY KEY (`CD_PRATO`) ,
  INDEX `fk_prato_tipo_de_prato1_idx` (`CD_TIPO_PRATO` ASC) ,
  CONSTRAINT `fk_prato_tipo_de_prato1`
    FOREIGN KEY (`CD_TIPO_PRATO` )
    REFERENCES `emiliabd`.`tipo_de_prato` (`CD_TIPO_PRATO` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `emiliabd`.`refeicao_prato`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `emiliabd`.`refeicao_prato` ;

CREATE  TABLE IF NOT EXISTS `emiliabd`.`refeicao_prato` (
  `CD_REFEICAO` INT UNSIGNED NOT NULL ,
  `CD_PRATO` INT UNSIGNED NOT NULL ,
  INDEX `fk_refeicao_prato_refeicao1_idx` (`CD_REFEICAO` ASC) ,
  INDEX `fk_refeicao_prato_prato1_idx` (`CD_PRATO` ASC) ,
  CONSTRAINT `fk_refeicao_prato_refeicao1`
    FOREIGN KEY (`CD_REFEICAO` )
    REFERENCES `emiliabd`.`refeicao` (`CD_REFEICAO` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_refeicao_prato_prato1`
    FOREIGN KEY (`CD_PRATO` )
    REFERENCES `emiliabd`.`prato` (`CD_PRATO` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `emiliabd`.`item`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `emiliabd`.`item` ;

CREATE  TABLE IF NOT EXISTS `emiliabd`.`item` (
  `CD_ITEM` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `DS_PRODUTO` VARCHAR(50) NOT NULL ,
  `VL_PRECO` DECIMAL(10,2) UNSIGNED NOT NULL ,
  PRIMARY KEY (`CD_ITEM`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `emiliabd`.`registro`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `emiliabd`.`registro` ;

CREATE  TABLE IF NOT EXISTS `emiliabd`.`registro` (
  `CD_REG_PESSOA` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `CD_PESSOA` INT UNSIGNED NOT NULL ,
  `CD_ITEM` INT UNSIGNED NOT NULL ,
  `VL_PRECO` DECIMAL(10,2) NULL ,
  `DT_REGISTRO` DATE NULL ,
  PRIMARY KEY (`CD_REG_PESSOA`) ,
  INDEX `fk_registro_pessoa1_idx` (`CD_PESSOA` ASC) ,
  INDEX `fk_registro_item1_idx` (`CD_ITEM` ASC) ,
  CONSTRAINT `fk_registro_pessoa1`
    FOREIGN KEY (`CD_PESSOA` )
    REFERENCES `emiliabd`.`pessoa` (`CD_PESSOA` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_registro_item1`
    FOREIGN KEY (`CD_ITEM` )
    REFERENCES `emiliabd`.`item` (`CD_ITEM` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `emiliabd`.`PGTO_PESSOA`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `emiliabd`.`PGTO_PESSOA` ;

CREATE  TABLE IF NOT EXISTS `emiliabd`.`PGTO_PESSOA` (
  `CD_PESSOA` INT UNSIGNED NOT NULL ,
  `MES_REFERENCIA` DATE NULL ,
  `DT_PGTO` DATE NULL ,
  `NR_VALOR` DECIMAL(10,2) NULL ,
  CONSTRAINT `fk_PGTO_PESSOA_pessoa1`
    FOREIGN KEY (`CD_PESSOA` )
    REFERENCES `emiliabd`.`pessoa` (`CD_PESSOA` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `emiliabd`.`nivel`
-- -----------------------------------------------------
START TRANSACTION;
USE `emiliabd`;
INSERT INTO `emiliabd`.`nivel` (`CD_NIVEL`, `DS_NIVEL`) VALUES (NULL, 'Administrador');

COMMIT;

-- -----------------------------------------------------
-- Data for table `emiliabd`.`usuario`
-- -----------------------------------------------------
START TRANSACTION;
USE `emiliabd`;
INSERT INTO `emiliabd`.`usuario` (`CD_USUARIO`, `NM_USUARIO`, `DS_LOGIN`, `CD_NIVEL`, `DS_SENHA`, `SN_ATIVO`, `SN_SENHA_ATUAL`) VALUES (NULL, 'Administrador', 'admin', 1, '25d55ad283aa400af464c76d713c07ad', 'S', 'S');

COMMIT;
