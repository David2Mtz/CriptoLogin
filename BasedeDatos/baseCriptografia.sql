CREATE TABLE IF NOT EXISTS `Usuario` (
  `idUsuario` INT NOT NULL AUTO_INCREMENT,
  `Usuario` VARCHAR(50) NOT NULL,
  `Correo` VARCHAR(45) NOT NULL,
  `Password` VARCHAR(64) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `Corre_UNIQUE` (`Correo` ASC),  -- El email debe ser único
  UNIQUE INDEX `Usuario_UNIQUE` (`Usuario` ASC) -- El nombre de usuario también único
)
ENGINE = InnoDB;


ALTER TABLE `usuario` ADD `Fec_Creac` DATETIME NOT NULL AFTER `Password`;
ALTER TABLE `usuario` ADD `Token` VARCHAR(16) NOT NULL AFTER `Fec_Creac`;
ALTER TABLE `usuario` ADD `Valido` INT NOT NULL AFTER `Token`;

ALTER TABLE `usuario` ADD `Token_Password` VARCHAR(64) NULL DEFAULT NULL AFTER `Valido`, ADD `Fec_Creac_Password` DATETIME NULL DEFAULT NULL AFTER `Token_Password`, ADD `Token_Password_Expiracion` DATETIME NULL DEFAULT NULL AFTER `Fec_Creac_Password`;






