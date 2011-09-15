CREATE  TABLE IF NOT EXISTS `%%PREFIX%%jediPaypal_payments` (
  `id_payment` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `currency` CHAR(3) NOT NULL ,
  `amount` DECIMAL(6,2) NOT NULL ,
  `transaction_id` VARCHAR(20) NOT NULL ,
  `payer_email` VARCHAR(50) NOT NULL ,
  `payer_id` VARCHAR(15) NOT NULL ,
  `item_name` VARCHAR(40) NULL ,
  `custom` VARCHAR(100) NULL ,
  PRIMARY KEY (`id_payment`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci