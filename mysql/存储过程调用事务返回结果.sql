
DROP TABLE IF EXISTS `test`;
CREATE TABLE `test` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;


DROP PROCEDURE IF EXISTS  `test_sp1`;
CREATE PROCEDURE `test_sp1`()
    BEGIN
    DECLARE t_error INTEGER DEFAULT 0;
    DECLARE CONTINUE HANDLER FOR SQLEXCEPTION SET t_error=1;

        START TRANSACTION;
            INSERT INTO test (`name`) VALUES('test sql 001');

        IF t_error = 1 THEN
            ROLLBACK;
        ELSE
            COMMIT;
        END IF;
   select t_error;  
END;

call `test_sp1`